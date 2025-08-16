<!DOCTYPE html>
<html dir="web" lang="en">
<?php
session_start();
if (isset($_COOKIE['PHPSESSID'])){
	include_once 'php/dbh.php';
	
	$user_access_list = substr($_COOKIE["user_access"],0,1);
	$user_access_add = substr($_COOKIE["user_access"],1,1);
	$user_access_update = substr($_COOKIE["user_access"],2,1);
	$user_access_delete = substr($_COOKIE["user_access"],3,1);

	if($_COOKIE["user_access"] == "0000"){
	    header('Location: noaccess.php');    
	}

	$system_id = $_GET["id"];
	$record = mysqli_query($conn,"SELECT * FROM `system` WHERE id=".$system_id);
	$row = mysqli_fetch_assoc($record);

?>
<?php include 'include/head.php';?>
<body>
    <?php include 'include/preloader.php';?>
    <div id="main-wrapper">
        <?php include 'include/topbar.php';?>
        <?php include 'include/sidebar.php';?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Systems Administration</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">System Details </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
        	<input type="text" class="form-control" id="system_id" hidden readonly value = "<?php echo $system_id; ?>">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">System Details</h4>
                                <h6 class="card-subtitle">Systems are the enterprise applications that are enabled for Archival. System details like DB, REST Endpoints, File Systems are specified here. Refer Documentation <a href="https://datatables.net/"> Systems </a></h6>
                                <div class="card-body bg-light">
                                    <h4 class="card-title m-t-10 p-b-20">System : </h4>
                                    <div class="row border-bottom">
                                        <div class="col-sm-12 col-lg-6">
                                            <div class="form-group row align-items-center m-b-0">
                                                <label for="system_name" class="col-3 text-right control-label col-form-label">System Name</label>
                                                <div class="col-9 border-left p-t-10 p-b-10">
                                                    <input type="system_name" class="form-control" id="system_name" placeholder="System Name" readonly value = "<?php echo $row['system_name']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-6">
                                            <div class="form-group row align-items-center m-b-0">
                                                <label for="system_details" class="col-3 text-right control-label col-form-label">System Details</label>
                                                <div class="col-9 border-left p-t-10 p-b-10">
                                                    <input type="text" class="form-control" id="system_details" placeholder="System Details" readonly value = "<?php echo $row['system_details']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
      			<div class="row">
      				<div class="col-12">
      					<div class="card"><div class="card-body">
							<ul class="nav nav-tabs" role="tablist">
    							<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#entities" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Entities</span></a> </li>
    							<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sourcedb" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Source DB Connections</span></a> </li>
    							<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#rest" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">REST End-Points</span></a> </li>
							</ul>

							<div class="tab-content tabcontent-border">
    							<div class="tab-pane active" id="entities" role="tabpanel">
        							<div class="p-20">
                                <div class="table-responsive">
                                    <input id="useracc" value="<?php echo $_COOKIE["user_access"]?>" type="hidden">
                                    <button id = "AddEntity" class="btn btn-primary" style="float:right;" data-toggle="modal" data-target="#insertModal">Add Data Entity</button>
                                    <table id="entity_table" class="table table-striped table-bordered display stats-table cell-border compact stripe">
                                        <thead>
                					        <tr> 
                					            <th>Action</th>
                                                <th>Status</th>
                					            <th>Entity Name</th> 
                					            <th>IO Name</th> 
                					            <th>Table Name</th>
                                                <!--th>Query Heirarchy</th--> 
                					            <th>Query Fields</th> 
                					            <th>Summary Fields</th> 
                					            <th>ParentID Fields</th> 
                					            <th>System</th>
                					       </tr> 
                                        </thead>
                                    </table>
                                </div>
        							</div>
    							</div>
    							<div class="tab-pane  p-20" id="sourcedb" role="tabpanel">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Database Details</h4>
                                <h6 class="card-subtitle">Database details are required to fetch the qualifying records for a Rule. This can be Production or an Replica of production. Id`s should match. <a href="https://datatables.net/"> Database Connections </a></h6>
                                <div class="card-body bg-light">
                                    <div class="row border-bottom">
                                        <div class="col-sm-12 col-lg-12">
                                            <div class="form-group row align-items-center m-b-0">
                                                <label for="system_name" class="col-3 text-right control-label col-form-label">Database Type</label>
                                                <div class="col-9 border-left p-t-10 p-b-10">
                                                	    <select class="custom-select form-control" id="database_type" name="database_type">
                                                             <option value="">Select Database Type</option>
                                                             <option value="oracle" <?php if($row['database_type']=='oracle'){echo "selected";}?> >ORACLE</option>
                                                             <option value="mssql" <?php if($row['database_type']=='mssql'){echo "selected";}?> >MSSQL</option>
                                                             <option value="db2" <?php if($row['database_type']=='db2'){echo "selected";}?> >DB2</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-12">
                                            <div class="form-group row align-items-center m-b-0">
                                                <label for="system_details" class="col-3 text-right control-label col-form-label">Database Name</label>
                                                <div class="col-9 border-left p-t-10 p-b-10">
                                                    <input type="text" class="form-control" id="system_details" placeholder="System Details" value = "<?php echo $row['database_name']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row border-bottom">
                                        <div class="col-sm-12 col-lg-12">
                                            <div class="form-group row align-items-center m-b-0">
                                                <label for="system_name" class="col-3 text-right control-label col-form-label">Database Connection String</label>
                                                <div class="col-9 border-left p-t-10 p-b-10">
                                                    <input type="text" class="form-control" id="system_name" placeholder="System Name" value = "<?php echo $row['db_connect_string']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                                
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
                                
                                </div>
    							<div class="tab-pane p-20" id="rest" role="tabpanel">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">REST Endpoint Details</h4>
                                <h6 class="card-subtitle">REST End points are required for fetching the record hierarchy and also for cascade deleting the data. <a href="https://datatables.net/"> REST End points </a></h6>
                                <div class="card-body bg-light">
                                    <div class="row border-bottom">
                                        <div class="col-sm-12 col-lg-12">
                                            <div class="form-group row align-items-center m-b-0">
                                                <label for="REST_endpoint" class="col-3 text-right control-label col-form-label">Query End point</label>
                                                <div class="col-9 border-left p-t-10 p-b-10">
                                                    <input type="text" class="form-control" id="REST_endpoint" placeholder="REST End point for Query" value = "<?php echo $row['REST_endpoint']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row border-bottom">
                                        <div class="col-sm-12 col-lg-12">
                                            <div class="form-group row align-items-center m-b-0">
                                                <label for="REST_endpoint_delete" class="col-3 text-right control-label col-form-label">Delete End point</label>
                                                <div class="col-9 border-left p-t-10 p-b-10">
                                                    <input type="text" class="form-control" id="REST_endpoint_delete" placeholder="REST End point for Delete" value = "<?php echo $row['REST_endpoint_delete']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                                
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
                                                                                
                                                
                                                
                                </div>
							</div>						
                        </div></div>   
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
    <!--chartis chart-->
    <script src="../../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 charts -->
    <script src="../../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../../assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../../assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../../dist/js/pages/dashboards/dashboard1.js"></script>
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
            {document.getElementById("AddEntity").style.display="none";}    
        }
        if(useracc.substring(2, 3) == "0"){
            $(".entity_fetchbyid").hide();
        }
		var systemname =  $('#system_name').val();
        var EntityDataTable = $("#entity_table").DataTable({
            "ajax":{
                "url" : "php/ajax_entity.php",
        		"data": { "systemname": systemname },            
                "dataSrc" : ""
            },
            "columns" : [
               { 
                    "data": "id",
                    "render": function(data, type, row, meta){ //data-id='".$row['id']."' data-toggle="modal" data-target="#updateModal"
                        if(type === 'display'){
                            div_start = '<div class="d-flex align-items-center">';
                            if(useracc.substring(2, 3) == "1"){
                                btn1 ='<button class="btn btn-info  entity_fetchbyid" style="margin-right:10pt;" data-id='+ data +' data-toggle="modal" data-target="#updateModal"><i class="fas fa-pencil-alt" style="color:white;"></i></button>';    
                            }else{
                                btn1 = '';
                            }
                            if(useracc.substring(3, 4) == "1"){
                                if(row.status == 'active'){
                                    btn2 ='<button class="btn  btn-danger entity_inactivate" data-id='+ data +' style="margin-right:10pt;"><i class="fa fa-minus-square" style="color:white;"></i></button>';      
                                }
                                else{
                                    btn2 ='<button class="btn  btn-success Entity_activate" data-id='+ data +'><i class="fa fa-check-square" style="color:white;"></i></button>';    
                                }
                            }else{
                                btn2='';
                            }
                            div_end = '</div>';
                            data = div_start + btn1 + btn2 + div_end;
                        }
                        return data;
                    }
                },
                {
                    "data" : "status",
                    "render": function(data, type, row, meta){
                        if(data === "active"){
                            data ='<button class="btn btn-success ">' + data + '</button>';
                        }
                        else{
                            data ='<button class="btn btn-danger ">' + data + '</button>';
                        }
                        return data;
                    }
                },               
                {"data" : "entity_name"},
                {"data" : "IO_name"},
                {"data" : "table_name"},
            	//{"data" : "query_hierarchy"},
                {"data" : "query_fields"},
                {"data" : "summary_fields"},
                {"data" : "parent_id_fields"},
                {"data" : "system"}
            ],
            "deferRender": true,
        	"bAutoWidth": false,
            "aoColumns": [
              { "sWidth": "5%" }, 
              { "sWidth": "5%" }, 
              { "sWidth": "10%" },
              { "sWidth": "5%" },
              { "sWidth": "5%" },
              { "sWidth": "10%" },
              { "sWidth": "30%" },
              { "sWidth": "10%" },
              { "sWidth": "10%" },
              { "sWidth": "5%" },
            ],
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
                    title: 'Entity Report',
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
        $('#entity_table').on('click','.entity_inactivate',function(){
            var id = $(this).data('id');
            var deleteConfirm = confirm("Do you want to inactivate the Data Entity?");
            if (deleteConfirm == true) {
                $.ajax({
                    url: 'php/ajax_entity.php',
                    type: 'post',
                    data:{request: "inactivate", id: id},
                    success: function(response){
                        if(response == 1){
                            alert("Data Entity Inactivated.");
                            EntityDataTable.ajax.reload();
                        }else{
                            alert("Technical Error.Please contact administrator");
                        }
                    }
                });
            } 
        });
        
        // Activate record
        $('#entity_table').on('click','.Entity_activate',function(){
            var id = $(this).data('id');
            var deleteConfirm = confirm("Do you want to Activate the Entity?");
            if (deleteConfirm == true) {
                $.ajax({
                    url: 'php/ajax_entity.php',
                    type: 'post',
                    data:{request: "activate", id: id},
                    success: function(response){
                        if(response == 1){
                            alert("Data Entity Activated.");
                            EntityDataTable.ajax.reload();
                        }else{
                            alert("Technical Error.Please contact administrator");
                        }
                    }
                });
            } 
        });

        // Edit Button click : Fetch record by Id
        $('#entity_table').on('click','.entity_fetchbyid',function(){
            if(useracc.substring(2, 3) == "1"){
                var id = $(this).data('id');
                $.ajax({
                    url: 'php/ajax_entity.php',
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
                    url: 'php/ajax_entity.php',
                    type: 'post',
                    data: {request: "update", id: id,entity_name: entity_name, IO_name: IO_name, table_name: table_name, query_fields: query_fields, summary_fields: summary_fields, parent_id_fields:parent_id_fields, system:system},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){
                            alert(response.message);
                            $('#entity_name_upd','#IO_name_upd','#table_name_upd','#query_fields_upd','#summary_fields_upd','#parent_id_fields_upd').val('');
                            $('#system_upd').val('%%');
                            EntityDataTable.ajax.reload();
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
                    url: 'php/ajax_entity.php',
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

                            EntityDataTable.ajax.reload();
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


        // Add Entity 
        $('#btn_entityadd').click(function(){
            var Entityname = $('#Entityname1').val().trim();
        
            
        });            
        
    }); 

       
</script>


<?php 
}else{
    header('Location: index.php');
}
?>
</html>
