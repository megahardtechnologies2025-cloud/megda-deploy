<!DOCTYPE html>
<html dir="web" lang="en">
<?php
session_start();

//header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");


if (isset($_COOKIE['PHPSESSID'])){
	include_once 'php/dbh.php';
	
	$user_access_list = substr($_SESSION["user_access"],0,1);
	$user_access_add = substr($_SESSION["user_access"],1,1);
	$user_access_update = substr($_SESSION["user_access"],2,1);
	$user_access_delete = substr($_SESSION["user_access"],3,1);

	if($_SESSION["user_access"] == "0000"){
	    header('Location: noaccess.php');    
	}	


?>
<?php include 'include/head.php';?>
<style>
/* Semi-transparent fullscreen overlay */
.preloader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.5); /* 50% white overlay */
    z-index: 9999;
    display: none;
    justify-content: center;
    align-items: center;
    pointer-events: all; /* capture clicks */
}

/* Prevent clicking anything underneath */
body.loading {
    pointer-events: none;
}

/* Loader styles (if not already defined) */
.lds-ripple {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
}
.lds-ripple div {
    position: absolute;
    border: 4px solid #3498db;
    border-radius: 50%;
    animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}
.lds-ripple div:nth-child(2) {
    animation-delay: -0.5s;
}
@keyframes lds-ripple {
    0% {
        top: 36px;
        left: 36px;
        width: 0;
        height: 0;
        opacity: 1;
    }
    100% {
        top: 0px;
        left: 0px;
        width: 72px;
        height: 72px;
        opacity: 0;
    }
}


</style>
<body>
    <?php include 'include/preloader.php';?>
    <div id="main-wrapper">
        <?php include 'include/topbar.php';?>
        <?php include 'include/sidebar.php';?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Entity Administration</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Rules</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Rules</h4>
                                <h6 class="card-subtitle">Here you will be able to create new rules and activate/inactivate a rule. Refer Documentation <a href="https://datatables.net/">Rules</a></h6>
                                <div class="table-responsive">
                                    <input id="useracc" value="<?php echo $_SESSION["user_access"]?>" type="hidden">
                                    <button id = "AddNewRule" class="btn btn-primary" style="float:right;">Add New Rule</button>
                                    <!--button id = "RESTCall" class="btn btn-primary" style="float:right;">REST API CALL TEST</button-->
                                    <table id="rule_table" class="table table-striped table-bordered display nowrap stats-table cell-border compact stripe">
                                        <thead>
                					        <tr>
        										<th>Action</th>
                					            <th>Status</th> 
                					            <th>id</th> 
                					            <th>Rule Name</th> 
                					            <th>Rule Desc</th> 
                					            <th>Source System</th>
                					            <th>Data Entity</th> 
                					            <th>IO Name</th> 
                					            <th>Base Table</th> 
                					            <th>Rule Criteria</th> 
                					            <th>Archive Type</th>
                					            <th>Archive Attach</th> 
                					            <th>Frequency</th> 
                					            <th>Start Time</th> 
                					            <th>End Time</th>
                					            <th>Retrieval Required</th>
                					            <th>Summary Required</th>
                					            <th>Summary Type</th>                					            
                					            <th>Query Fields</th> 
                					            <th>Summary Fields</th> 
                					            <th>ParentID Fields</th> 
                					            <th>Archive Destination</th> 
                					            <th>Retention Period</th>                					            
                					            <th>Activation Date</th> 
                					            <th>Expiration Date</th>
                					       </tr> 
                                        </thead>
                                        <!--tfoot style="display: table-header-group;">
                                            <tr>
                					            <th>id</th> 
                					            <th>Entity Name</th> 
                					            <th>IO Name</th> 
                					            <th>Table Name</th>
                					            <th>Query Fields</th> 
                					            <th>Summary Fields</th> 
                					            <th>ParentID Fields</th> 
                					            <th>System</th> 
                					            <th>Status</th>
                                            </tr>
                                        </tfoot-->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Edit Modal -->
            <div id="updateModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Entity Update</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="entity_name_upd" >Entity Name</label>
                                <input type="text" class="form-control" id="entity_name_upd" placeholder="Enter Entity Name" required>            
                            </div>
                            <div class="form-group">
                                <label for="IO_name_upd" >IO Name</label>
                                <input type="text" class="form-control" id="IO_name_upd" placeholder="Enter IO Name" required>            
                            </div>
                            <div class="form-group">
                                <label for="table_name_upd" >Table Name</label>
                                <input type="text" class="form-control" id="table_name_upd" placeholder="Enter Table Name" required>            
                            </div>
                            <div class="form-group">
                                <label for="query_fields_upd" >Query Fields</label>
                                <textarea class="form-control" id="query_fields_upd" rows="2" maxlength="500"></textarea>            
                            </div>
                            <div class="form-group">
                                <label for="parent_id_fields_upd" >ParentID Fields</label>
                                <textarea class="form-control" id="parent_id_fields_upd" rows="2" maxlength="500"></textarea>            
                            </div>
                            <div class="form-group">
                                <label for="summary_fields_upd" >Summary Fields</label>
                                <textarea class="form-control" id="summary_fields_upd" rows="2" maxlength="500"></textarea>            
                            </div>                            
                            <?php
                                $sql_system = "SELECT system_name FROM `system` WHERE status='active';";
                                $results_system = mysqli_query($conn, $sql_system);
                                $system=array();
                                if ($results_system->num_rows > 0) {
                                    while($row_system = $results_system->fetch_assoc()) {
                                        array_push($system,$row_system["system_name"]);
                                    }
                                } else {
                                    $system=array('');
                                }
                            ?>
                            <div class="form-group">
                                <label for="system_upd" >System</label>
                                <select id='system_upd' class="form-control">
                                    <option value='%%'>Select System</option>
                                    <?php foreach($system as $val) {?>
                                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                    <?php } ?>
                                </select>              
                            </div>   
 
                            <input type="hidden" class="form-control" id="entity_id" readonly>   
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-sm" id="btn_entitysave">Save</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Add Modal -->
            <div id="insertModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Entity - Add</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="entity_name" >Entity Name</label>
                                <input type="text" class="form-control" id="entity_name" placeholder="Enter Entity Name" required>            
                            </div>
                            <div class="form-group">
                                <label for="IO_name" >IO Name</label>
                                <input type="text" class="form-control" id="IO_name" placeholder="Enter IO Name" required>            
                            </div>
                            <div class="form-group">
                                <label for="table_name" >Table Name</label>
                                <input type="text" class="form-control" id="table_name" placeholder="Enter Table Name" required>            
                            </div>
                            <div class="form-group">
                                <label for="query_fields" >Query Fields</label>
                                <textarea class="form-control" id="query_fields" rows="2" maxlength="500"></textarea>            
                            </div>
                            <div class="form-group">
                                <label for="parent_id_fields" >ParentID Fields</label>
                                <textarea class="form-control" id="parent_id_fields" rows="2" maxlength="500"></textarea>            
                            </div>
                            <div class="form-group">
                                <label for="summary_fields" >Summary Fields</label>
                                <textarea class="form-control" id="summary_fields" rows="2" maxlength="500"></textarea>            
                            </div>                            
                            <?php
                                $sql_system = "SELECT system_name FROM `system` WHERE status='active';";
                                $results_system = mysqli_query($conn, $sql_system);
                                $system=array();
                                if ($results_system->num_rows > 0) {
                                    while($row_system = $results_system->fetch_assoc()) {
                                        array_push($system,$row_system["system_name"]);
                                    }
                                } else {
                                    $system=array('');
                                }
                            ?>
                            <div class="form-group">
                                <label for="system" >System</label>
                                <select id='system' class="form-control">
                                    <option value='%%'>Select System</option>
                                    <?php foreach($system as $val) {?>
                                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                    <?php } ?>
                                </select>              
                            </div>   
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-sm" id="btn_entityadd">Add</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            </div>
<div class="preloader-overlay preloader" style="display: none;">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>                                 
            <?php include 'include/footer.php';?>
        </div>
    </div>
    <?php include 'include/customiser.php';?>
    
    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="../../dist/js/app.min.js"></script>
    <script src="../../dist/js/app.init.js"></script>
    <script src="../../dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../../assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->

    <!-- start - This is for Data Tables -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" media="all" />
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

</body>

<script>
    $(document).ready(function () {
        var useracc = $("#useracc").val();
        
        if(useracc.substring(1, 2) == "0"){
            {document.getElementById("AddNewRule").style.display="none";}    
        }
        if(useracc.substring(2, 3) == "0"){
            $(".rule_fetchbyid").hide();
        }

        var RuleDataTable = $("#rule_table").DataTable({
            "ajax":{
                "url" : "php/ajax_rules.php",
                "dataSrc" : ""
            },
            "columns" : [
			{ 
                    "data": "id",
                    "render": function(data, type, row, meta){ //data-id='".$row['id']."' data-toggle="modal" data-target="#updateModal"
                        if(type === 'display'){
                            div_start = '<div class="d-flex align-items-center">';
                            if(useracc.substring(2, 3) == "1"){
                                btn0 ='<button class="btn btn-primary  rule_fetchCountbyid" style="margin-right:10pt;" data-id='+ data +' ><i class="fas fa-calculator" style="color:white;"></i></button>';    
                            }else{
                                btn0 = '';
                            }
                        	if(useracc.substring(2, 3) == "1"){
                                btn1 ='<button class="btn btn-info  rule_fetchbyid" style="margin-right:10pt;" data-id='+ data +' data-toggle="modal" data-target="#updateModal"><i class="fas fa-pencil-alt" style="color:white;"></i></button>';    
                            }else{
                                btn1 = '';
                            }
                            if(useracc.substring(3, 4) == "1"){
                                if(row.rule_status == 'active'){
                                    btn2 ='<button class="btn  btn-danger rule_inactivate" data-id='+ data +' style="margin-right:10pt;"><i class="fa fa-minus-square" style="color:white;"></i></button>';      
                                }
                                else{
                                    btn2 ='<button class="btn  btn-success rule_activate" data-id='+ data +'><i class="fa fa-check-square" style="color:white;"></i></button>';    
                                }
                            }else{
                                btn2='';
                            }
                            div_end = '</div>';
                            data = div_start + btn0 + btn2 + div_end;
                        }
                        return data;
                    }
                },            
                {
                    "data" : "rule_status",
                    "render": function(data, type, row, meta){
                        if(data === "active"){
                            data ='<button class="btn btn-success ">' + data + '</button>';
                        }
                        else if(data === "creating"){
                            data ='<button class="btn btn-warning ">' + data + '</button>';
                        }
                        else{
                            data ='<button class="btn btn-danger ">' + data + '</button>';
                        }
                        return data;
                    }
                },                
				{ 
                    "data": "id",
                    "render": function(data, type, row, meta){ //data-id='".$row['id']."' data-toggle="modal" data-target="#updateModal"
                        if(type === 'display'){
							data = '<a href="rule_dashboard.php?id='+data+'">'+data+'</a>';
                        }
                        return data;
                    }
                }, 
                {"data" : "rule_name"},
                {"data" : "rule_desc"},
                {"data" : "source_system"},
                {"data" : "data_entity"},
                {"data" : "IO_name"},
                {"data" : "base_table"},
                {"data" : "rule_criteria"},
                {"data" : "archive_type"},
                {"data" : "archive_attachment"},
                {"data" : "frequency"},
                {"data" : "execution_start_time"},
                {"data" : "execution_end_time"},
                {"data" : "reterival_required"},
                {"data" : "summary_required"},
                {"data" : "summary_type"},
                {"data" : "query_fields"},
                {"data" : "summary_fields"},
                {"data" : "parent_id_fields"},
                {"data" : "archive_destination"},
                {"data" : "retention_period"},
                {"data" : "activation_date"},
                {"data" : "expiration_date"}
            ],
            "deferRender": true,
            dom: 'Bfrtip',
            "aaSorting": [],
            buttons: [
                'csv',
                'excel',
                'print',
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                    },
                    title: 'Rule Report',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    customize: function(doc) {
                    //   doc.styles.tableHeader.fontSize = 7; 
                    //   doc.defaultStyle.fontSize = 6; 
                      doc.defaultStyle.alignment = 'left';
                    },
                },
            ],
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
     
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
     
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        });

        // Inactivate record
        $('#rule_table').on('click','.rule_inactivate',function(){
            var id = $(this).data('id');
            var deleteConfirm = confirm("Do you want to inactivate the Rule?");
            if (deleteConfirm == true) {
                $.ajax({
                    url: 'php/ajax_rules.php',
                    type: 'post',
                    data:{request: "inactivate", id: id},
                    success: function(response){
                        if(response == 1){
                            alert("Rule Inactivated.");
                            RuleDataTable.ajax.reload();
                        }else{
                            alert("Technical Error.Please contact administrator");
                        }
                    }
                });
            } 
        });
        
        // Activate record
        $('#rule_table').on('click','.rule_activate',function(){
            var id = $(this).data('id');
            var deleteConfirm = confirm("Do you want to Activate the Rule?");
            if (deleteConfirm == true) {
                $.ajax({
                    url: 'php/ajax_rules.php',
                    type: 'post',
                    data:{request: "activate", id: id},
                    success: function(response){
                        if(response == 1){
                            alert("Rule Activated.");
                            RuleDataTable.ajax.reload();
                        }else{
                        	console.log(response);
                            alert("Technical Error.Please contact administrator");
                        }
                    }
                });
            } 
        });

        // Edit Button click : Fetch record by Id
        $('#rule_table').on('click','.rule_fetchbyid',function(){
            if(useracc.substring(2, 3) == "1"){
                var id = $(this).data('id');
                $.ajax({
                    url: 'php/ajax_rules.php',
                    type: 'post',
                    data: {request: "loadmodal", id: id},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){
                            $('#entity_id').val(response.data.id);
                            $('#entity_name_upd').val(response.data.entity_name);
                            $('#IO_name_upd').val(response.data.IO_name);
                            $('#table_name_upd').val(response.data.table_name);
                            $('#query_fields_upd').val(response.data.query_fields);
                            $('#summary_fields_upd').val(response.data.summary_fields);
                            $('#parent_id_fields_upd').val(response.data.parent_id_fields);
                            $('#system_upd').val(response.data.system);
                        }else{
                            alert("Invalid ID.");
                        }
                    }
                });
            }else{
                $('#updateModal').modal('toggle'); 
                alert("You do not have access to update records!!")
            }
            
        });

        // Update Entity 
        $('#btn_entitysave').click(function(){
            var id = $('#entity_id').val();

            var entity_name = $('#entity_name_upd').val().trim();
            var IO_name = $('#IO_name_upd').val().trim();
            var table_name = $('#table_name_upd').val().trim();
            var query_fields = $('#query_fields_upd').val().trim();
            var summary_fields = $('#summary_fields_upd').val().trim();
            var parent_id_fields = $('#parent_id_fields_upd').val().trim();
            var system = $('#system_upd').val().trim();

            if(id !='' && entity_name != ''){
                $.ajax({
                    url: 'php/ajax_rules.php',
                    type: 'post',
                    data: {request: "update", id: id,entity_name: entity_name, IO_name: IO_name, table_name: table_name, query_fields: query_fields, summary_fields: summary_fields, parent_id_fields:parent_id_fields, system:system},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){
                            alert(response.message);
                            $('#entity_name_upd','#IO_name_upd','#table_name_upd','#query_fields_upd','#summary_fields_upd','#parent_id_fields_upd').val('');
                            $('#system_upd').val('%%');
                            RuleDataTable.ajax.reload();
                            $('#updateModal').modal('toggle');                            
                        }else{
                            alert(response.message);
                        }
                    }
                });
            }else{
                alert('Please fill all Required fields.');
            }
        });



        // Add Entity 
        $('#btn_entityadd').click(function(){
            var entity_name = $('#entity_name').val().trim();
            var IO_name = $('#IO_name').val().trim();
            var table_name = $('#table_name').val().trim();
            var query_fields = $('#query_fields').val().trim();
            var summary_fields = $('#summary_fields').val().trim();
            var parent_id_fields = $('#parent_id_fields').val().trim();
            var system = $('#system').val().trim();

            if(entity_name !='' ){
                $.ajax({
                    url: 'php/ajax_rules.php',
                    type: 'post',
                    data: {request: "insert", entity_name: entity_name,IO_name: IO_name, table_name: table_name, query_fields: query_fields, summary_fields: summary_fields, parent_id_fields: parent_id_fields, system: system},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){
                            console.log(response.message);
                            alert(response.message);
                            $('#entity_name').val('');
                            $('#IO_name').val('');
                            $('#table_name').val('');
                            $('#query_fields').val('');
                            $('#summary_fields').val('');
                            $('#parent_id_fields').val('others');

                            RuleDataTable.ajax.reload();
                            $('#insertModal').modal('toggle');                            
                        }else{
                            alert(response.message);
                        }
                    }
                });
            }else{
                alert('Please fill all fields...!!');
            }
        });

        // Count Button click : Fetch record Count by Id
        $('#rule_table').on('click','.rule_fetchCountbyid',function(){
            if(useracc.substring(2, 3) == "1"){
                var id = $(this).data('id');
                $.ajax({
                    url: 'php/ajax_rules.php',
                    type: 'post',
                    data: {request: "getRecordCount", id: id},
                    dataType: 'json',
    				beforeSend: function () {
        				$('.preloader').fadeIn(200);
        				$('body').addClass('loading'); // disable all clicks
    				},                
                    success: function(response){
                        if(response.status == 1){
                        	//console.log(response);
                        	var TotalRecCount = response.record_count;
							alert("Total Qualifying records for this Rule is : "+TotalRecCount);
                        }else{
                            alert("Invalid ID.");
                        }
                    },
    				complete: function () {
        				$('.preloader').fadeOut(200);
        				$('body').removeClass('loading'); // enable clicks again
    				}                
                });
            }else{
                alert("You do not have access to this feature!!")
            }
            
        });

    
    
        // Add New Rule button  
        $('#AddNewRule').click(function(){
            window.location.href = "rules_wizard.php";              
        });  
        
        // Add New Rule button  
        $('#RESTCall').click(function(){

            var settings = {
              "url": "https://10.65.34.122/siebel/v1.0/data/Service Request/Service Request?childlinks=none&SearchSpec=[Status]='Closed'&recordcountneeded=true",
              "crossDomain": true,
              "method": "HEAD",
              "timeout": 0,
              "headers": {
                "Authorization": "Basic U0FETUlOOlNJRUJFTA=="
              },
              success: function(data, textStatus, jqXHR) {
        		const TotalRecCount = jqXHR.getResponseHeader('Total-Record-Count');
        		if (TotalRecCount) {
            		console.log('Record Count:', TotalRecCount);
                	alert("Total Qualifying records for this Rule is : "+TotalRecCount);
        		}
              },
			  error: function(jqXHR, textStatus, errorThrown) {
        		console.error('AJAX Error:', textStatus, errorThrown);
        		console.error('Response Headers on Error:', jqXHR.getAllResponseHeaders());
    		  }
            };

            
            $.ajax(settings).done(function (response) {
              //console.log(response);
            });             
        });          
        
    }); 

       
</script>


<?php 
}else{
    header('Location: index.php');
}
?>
</html>
