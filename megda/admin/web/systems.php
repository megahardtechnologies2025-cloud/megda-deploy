<!DOCTYPE html>
<html dir="web" lang="en">
<?php
session_start();
if (isset($_COOKIE['username'])){
	include_once 'php/dbh.php';
	
	$user_access_list = substr($_COOKIE["user_access"],0,1);
	$user_access_add = substr($_COOKIE["user_access"],1,1);
	$user_access_update = substr($_COOKIE["user_access"],2,1);
	$user_access_delete = substr($_COOKIE["user_access"],3,1);

	if($_COOKIE["user_access"] == "0000"){
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
                        <h4 class="page-title">Systems Administration</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Systems </li>
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
                                <h4 class="card-title">Systems</h4>
                                <h6 class="card-subtitle">Systems are the enterprise applications that are enabled for Archival. System details like DB, REST Endpoints, File Systems are specified here. Refer Documentation <a href="https://datatables.net/"> Systems </a></h6>
                                <div class="table-responsive">
                                    <input id="useracc" value="<?php echo $_COOKIE["user_access"]?>" type="hidden">
                                    <button id = "AddSystem" class="btn btn-primary" style="float:right;" data-toggle="modal" data-target="#insertModal">Add New System</button>
                                    <table id="system_table" class="table table-striped table-bordered display nowrap stats-table cell-border compact stripe">
                                        <thead>
                					        <tr> 
                					            <th>id</th> 
                					            <th>System Name</th> 
                					            <th>System Details</th> 
                					            <th>Status</th>
                					            <th>Action</th> 
                					       </tr> 
                                        </thead>
                                    </table>
                                </div>
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
                            <h4 class="modal-title">System - Add</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="system_name" >System Name</label>
                                <input type="text" class="form-control" id="system_name" placeholder="Enter System Name" required>            
                            </div>
                            <div class="form-group">
                                <label for="system_details" >System Details</label>
                                <textarea class="form-control" id="system_details" rows="2" maxlength="500"></textarea>            
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-sm" id="btn_systemadd">Add</button>
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
        console.log(useracc);
        
        if(useracc.substring(1, 2) == "0"){
            {document.getElementById("AddUser").style.display="none";}    
        }
        if(useracc.substring(2, 3) == "0"){
            $(".system_fetchbyid").hide();
        }

        var SystemDataTable = $("#system_table").DataTable({
            "ajax":{
                "url" : "php/ajax_system.php",
                "dataSrc" : ""
            },
            "columns" : [
                {"data" : "id"},
                {"data" : "system_name"},
                {"data" : "system_details"},
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
                    "render": function(data, type, row, meta){ 
                        if(type === 'display'){
                            div_start = '<div class="d-flex align-items-center">';
                            if(useracc.substring(2, 3) == "1"){
                                btn1 ='<button class="btn btn-info  system_fetchbyid" style="margin-right:10pt;" data-id='+ data +' ><i class="fas fa-share" style="color:white;"></i></button>';    
                            }else{
                                btn1 = '';
                            }
                            if(useracc.substring(3, 4) == "1"){
                                if(row.status == 'active'){
                                    btn2 ='<button class="btn  btn-danger system_inactivate" data-id='+ data +' style="margin-right:10pt;"><i class="fa fa-minus-square" style="color:white;"></i></button>';      
                                }
                                else{
                                    btn2 ='<button class="btn  btn-success system_activate" data-id='+ data +'><i class="fa fa-check-square" style="color:white;"></i></button>';    
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
              { "sWidth": "10%" }, 
              { "sWidth": "20%" }, 
              { "sWidth": "50%" },
              { "sWidth": "20%" }
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
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                    },
                    title: 'System Report',
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


        // Add System 
        $('#btn_systemadd').click(function(){
            var system_name = $('#system_name').val().trim();
            var system_details = $('#system_details').val().trim();

            if(system_name !=''){
                $.ajax({
                    url: 'php/ajax_system.php',
                    type: 'post',
                    data: {request: "insert", system_name: system_name,system_details: system_details},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){
                            console.log(response.message);
                            alert(response.message);
                            $('#system_name').val('');
                            $('#system_details').val('');
                            SystemDataTable.ajax.reload();
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

        // Inactivate record
        $('#system_table').on('click','.system_inactivate',function(){
            var id = $(this).data('id');
            var deleteConfirm = confirm("Do you want to inactivate the System?");
            if (deleteConfirm == true) {
                $.ajax({
                    url: 'php/ajax_system.php',
                    type: 'post',
                    data:{request: "inactivate", id: id},
                    success: function(response){
                        if(response == 1){
                            alert("System Inactivated.");
                            SystemDataTable.ajax.reload();
                        }else{
                            alert("Technical Error.Please contact administrator");
                        }
                    }
                });
            } 
        });
        
        // Activate record
        $('#system_table').on('click','.system_activate',function(){
            var id = $(this).data('id');
            var deleteConfirm = confirm("Do you want to Activate the System?");
            if (deleteConfirm == true) {
                $.ajax({
                    url: 'php/ajax_system.php',
                    type: 'post',
                    data:{request: "activate", id: id},
                    success: function(response){
                        if(response == 1){
                            alert("System Activated.");
                            SystemDataTable.ajax.reload();
                        }else{
                            alert("Technical Error.Please contact administrator");
                        }
                    }
                });
            } 
        });

        // Edit Button click : Fetch record by Id
        $('#system_table').on('click','.system_fetchbyid',function(){
            if(useracc.substring(2, 3) == "1"){
                var id = $(this).data('id');
           		window.location.href = "system_details.php?id="+id;
            }else{
                alert("You do not have access to update records!!")
            }
            
        });

        // Update User 
        $('#btn_systemsave').click(function(){
            var id = $('#systemid').val();
            var system_name = $('#system_name_upd').val().trim();
            var system_details = $('#system_details_upd').val().trim();
            var database_type = $('#database_type_upd').val().trim();
            var database_name = $('#database_name_upd').val().trim();
            var REST_endpoint = $('#REST_endpoint_upd').val().trim();
            var filesystem_path = $('#filesystem_path_upd').val().trim();

            if(system_name !='' ){
                $.ajax({
                    url: 'php/ajax_system.php',
                    type: 'post',
                    data: {request: "update", id: id,system_name: system_name, system_details: system_details, database_type: database_type, database_name: database_name, REST_endpoint: REST_endpoint, filesystem_path: filesystem_path},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){
                            alert(response.message);
                            $('#system_name_upd','#system_details_upd','#database_name_upd','#REST_endpoint_upd','#filesystem_path_upd').val('');
                            $('#database_type').val('%%');

                            SystemDataTable.ajax.reload();
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





        
        
    }); 

       
</script>


<?php 
}else{
    header('Location: index.php');
}
?>
</html>
