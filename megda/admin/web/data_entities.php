<!DOCTYPE html>
<html dir="web" lang="en">
<?php
session_start();
if($_SESSION['valid']=="VALIDATED")
{
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
                                    <li class="breadcrumb-item active" aria-current="page">Data Entities</li>
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
                                <h4 class="card-title">Data Entities</h4>
                                <h6 class="card-subtitle">Data Entities are the required details about the data that needs archival. This will be a one time setup for each data entity. Refer Documentation <a href="https://datatables.net/">Data Entities</a></h6>
                                <div class="table-responsive">
                                    <input id="useracc" value="<?php echo $_SESSION["user_access"]?>" type="hidden">
                                    <button id = "AddEntity" class="btn btn-primary" style="float:right;" data-toggle="modal" data-target="#insertModal">Add Data Entity</button>
                                    <table id="entity_table" class="table table-striped table-bordered display nowrap stats-table cell-border compact stripe">
                                        <thead>
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
                					            <!--th>Image</th-->
                					            <th>Action</th> 
                					       </tr> 
                                        </thead>
                                        <tfoot style="display: table-header-group;">
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
                                        </tfoot>
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
            {document.getElementById("AddEntity").style.display="none";}    
        }
        if(useracc.substring(2, 3) == "0"){
            $(".entity_fetchbyid").hide();
        }

        var EntityDataTable = $("#entity_table").DataTable({
            "ajax":{
                "url" : "php/ajax_entity.php",
                "dataSrc" : ""
            },
            "columns" : [
                {"data" : "id"},
                {"data" : "entity_name"},
                {"data" : "IO_name"},
                {"data" : "table_name"},
                {"data" : "query_fields"},
                {"data" : "summary_fields"},
                {"data" : "parent_id_fields"},
                {"data" : "system"},
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
                }
            ],
            "deferRender": true,
            "aoColumns": [
              { "sWidth": "2%" }, 
              { "sWidth": "12%" }, 
              { "sWidth": "8%" },
              { "sWidth": "8%" },
              { "sWidth": "10%" },
              { "sWidth": "20%" },
              { "sWidth": "6%" },
              { "sWidth": "6%" },
              { "sWidth": "6%" },
              { "sWidth": "6%" },
              { "sWidth": "16%" },
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