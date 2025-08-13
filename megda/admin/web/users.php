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
                        <h4 class="page-title">User Administration</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                                <h4 class="card-title">User Data</h4>
                                <h6 class="card-subtitle">Users are the set of people who can access this application. Users should always be created with appropriate previlages. Refer Documentation <a href="https://datatables.net/">User Creation</a></h6>
                                <div class="table-responsive">
                                    <input id="useracc" value="<?php echo $_SESSION["user_access"]?>" type="hidden">
                                    <button id = "AddEmployee" class="btn btn-primary" style="float:right;" data-toggle="modal" data-target="#insertModal">Add User</button>
                                    <table id="user_table" class="table table-striped table-bordered display nowrap stats-table cell-border compact stripe">
                                        <thead>
                					        <tr> 
                					            <th>id</th> 
                					            <th>First Name</th> 
                					            <th>Last Name</th> 
                					            <th>User Id</th>
                					            <th>Phone</th> 
                					            <th>Email</th> 
                					            <th>Type</th> 
                					            <th>Role</th> 
                					            <th>Status</th>
                					            <!--th>Image</th-->
                					            <th>Action</th> 
                					       </tr> 
                                        </thead>
                                        <tfoot style="display: table-header-group;">
                                            <tr>
                					            <th>id</th> 
                					            <th>First Name</th> 
                					            <th>Last Name</th> 
                					            <th>User Id</th>
                					            <th>Phone</th> 
                					            <th>Email</th> 
                					            <th>Type</th> 
                					            <th>Role</th> 
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
                            <h4 class="modal-title">Employee Update</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="username" >User Id</label>
                                <input type="text" class="form-control" id="username" placeholder="Enter User Id" readonly>            
                            </div>
                            <div class="form-group">
                                <label for="firstname" >First Name</label>
                                <input type="text" class="form-control" id="firstname" placeholder="Enter First Name" required>            
                            </div>
                            <div class="form-group">
                                <label for="lastname" >Last Name</label>
                                <input type="text" class="form-control" id="lastname" placeholder="Enter Last Name" required>            
                            </div>
                            <div class="form-group">
                                <label for="phone" >Phone</label>
                                <input type="number" class="form-control" id="phone" placeholder="Enter Contact Phone Number" required maxlength="10" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">            
                            </div>
                            <div class="form-group">
                                <label for="email" >Email Id</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter Email Id" required>            
                            </div>

                            <div class="form-group">
                                <label for="type" >Type</label>
                                <select id='type' class="form-control">
                                    <option value='employee'>Employee</option>
                                    <option value='contractor'>Contractor</option>
                                    <option value='others'>Others</option>
                                </select>              
                            </div> 
                            <?php
                                $sql_role = "SELECT role_name FROM user_role WHERE status='active';";
                                $results_role = mysqli_query($conn, $sql_role);
                                $role=array();
                                if ($results_role->num_rows > 0) {
                                    while($row_role = $results_role->fetch_assoc()) {
                                        array_push($role,$row_role["role_name"]);
                                    }
                                } else {
                                    $role=array('');
                                }
                            ?>
                            <div class="form-group">
                                <label for="role" >Role</label>
                                <select id='role' class="form-control">
                                    <option value='%%'>Select Role</option>
                                    <?php foreach($role as $val) {?>
                                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                    <?php } ?>
                                </select>              
                            </div>   
                            <div class="form-group">
                                <label for="status" >Status</label>
                                <select id='status' class="form-control">
                                    <option value='active'>Active</option>
                                    <option value='inactive'>Inactive</option>
                                </select>              
                            </div>  
                            <input type="hidden" class="form-control" id="userid" readonly>   
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-sm" id="btn_empsave">Save</button>
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
                            <h4 class="modal-title">Employee Add</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="firstname1" >First Name</label>
                                <input type="text" class="form-control" id="firstname1" placeholder="Enter First Name" required>            
                            </div>
                            <div class="form-group">
                                <label for="lastname1" >Last Name</label>
                                <input type="text" class="form-control" id="lastname1" placeholder="Enter Last Name" required>            
                            </div>
                            <div class="form-group">
                                <label for="username1" >User Id</label>
                                <input type="text" class="form-control" id="username1" placeholder="Enter User Id" required>            
                            </div>
                            <div class="form-group">
                                <label for="phone1" >Phone</label>
                                <input type="number" class="form-control" id="phone1" placeholder="Enter Contact Phone Number" required maxlength="10" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">            
                            </div>
                            <div class="form-group">
                                <label for="email1" >Email Id</label>
                                <input type="email" class="form-control" id="email1" placeholder="Enter Email Id" required>            
                            </div>

                            <div class="form-group">
                                <label for="type1" >Type</label>
                                <select id='type1' class="form-control">
                                    <option value='employee'>Employee</option>
                                    <option value='contractor'>Contractor</option>
                                    <option value='others'>Others</option>
                                </select>              
                            </div>   
                            <?php
                                $sql_role = "SELECT role_name FROM user_role WHERE status='active';";
                                $results_role = mysqli_query($conn, $sql_role);
                                $role=array();
                                if ($results_role->num_rows > 0) {
                                    while($row_role = $results_role->fetch_assoc()) {
                                        array_push($role,$row_role["role_name"]);
                                    }
                                } else {
                                    $role=array('');
                                }
                            ?>
                            <div class="form-group">
                                <label for="role1" >Role</label>
                                <select id='role1' class="form-control">
                                    <option value='%%'>Select Role</option>
                                    <?php foreach($role as $val) {?>
                                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                    <?php } ?>
                                </select>              
                            </div>     
                            <div class="form-group">
                                <label for="status1" >Status</label>
                                <select id='status1' class="form-control">
                                    <option value='active'>Active</option>
                                    <option value='inactive'>Inactive</option>
                                </select>              
                            </div>  
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-sm" id="btn_useradd">Add</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Avatar -->
            <div class="modal fade" id="edit_photo">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add/Update Avatar </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" class="id" name="rowid" id="rowid">

                            <div class="form-group">
                                <label for="photo" class="col-sm-3 control-label">Avatar</label>
                                <div class="col-sm-9">
                                  <input type="file" id="img_avatar" name="img_avatar" class="img" required onchange="return fileValidation(this.id)">
                                </div>
                            </div>
                        </div>
                        <script>
                            function fileValidation(idnum) { 
                                var fileInput = document.getElementById(idnum); 
                                var filePath = fileInput.value; 
                                var allowedExtensions =  /(\.jpg|\.jpeg|\.png|\.bmp|\.gif)$/i; 
                                  
                                if (!allowedExtensions.exec(filePath)) { 
                                    alert('Only .jpg, .jpeg, .png, .gif, .bmp documents types are allowed'); 
                                    fileInput.value = ''; 
                                    return false; 
                                }  
                                else  
                                { 
                                    if (fileInput.files.length > 0) { 
                                        for (const i = 0; i <= fileInput.files.length - 1; i++) { 
                                            const fsize = fileInput.files.item(i).size; 
                                            const file = Math.round((fsize / 1024)); 
                                            // The size of the file. 
                                            if (file >= 1024) { 
                                                alert("File too Big, please select a file less than 1 Mb");
                                                fileInput.value = '';
                                                return false; 
                                            } 
                                            else { 
                                                return true; 
                                            } 
                                        } 
                                    }                                                 
                                 } 
                            }             
                        </script>                        
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                          <button class="btn btn-success btn-flat" name="upload_avatar" id="upload_avatar"><i class="fa fa-check-square-o"></i> Add / Update</button>
                          </form>
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
            $(".user_fetchbyid").hide();
            $(".user_avatar_update").hide();
        }

        var UsrDataTable = $("#user_table").DataTable({
            "ajax":{
                "url" : "php/ajax_user.php",
                "dataSrc" : ""
            },
            "columns" : [
                {"data" : "id"},
                {"data" : "firstname"},
                {"data" : "lastname"},
                {"data" : "username"},
                {"data" : "phone"},
                {"data" : "email"},
                {"data" : "type"},
                {"data" : "role"},
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
                /*{
                    "data" : "avatar",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            div_start = '<div class="d-flex align-items-center">';
                            img ='<img src=' + data + ' style="height: 30pt;width: 30pt;margin-right:10pt;"/>';
                            if(useracc.substring(2, 3) == "1"){
                                btnimgedit = '<button class="btn btn-secondary  user_avatar_update" data-id='+ row.id +' data-toggle="modal" data-target="#edit_photo" ><i class="fas fa-user"></i></button>';
                            }else{
                                btnimgedit ='';
                            }
                            div_end = '</div>';
                            data = div_start + img + btnimgedit + div_end;
                        }
                        return data;
                    }
                },*/
                { 
                    "data": "id",
                    "render": function(data, type, row, meta){ //data-id='".$row['id']."' data-toggle="modal" data-target="#updateModal"
                        if(type === 'display'){
                            div_start = '<div class="d-flex align-items-center">';
                            if(useracc.substring(2, 3) == "1"){
                                btn1 ='<button class="btn btn-info  user_fetchbyid" style="margin-right:10pt;" data-id='+ data +' data-toggle="modal" data-target="#updateModal"><i class="fas fa-pencil-alt" style="color:white;"></i></button>';    
                            }else{
                                btn1 = '';
                            }
                            if(useracc.substring(3, 4) == "1"){
                                if(row.status == 'active'){
                                    btn2 ='<button class="btn  btn-danger user_inactivate" data-id='+ data +' style="margin-right:10pt;"><i class="fa fa-minus-square" style="color:white;"></i></button>';      
                                }
                                else{
                                    btn2 ='<button class="btn  btn-success user_activate" data-id='+ data +'><i class="fa fa-check-square" style="color:white;"></i></button>';    
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
                    title: 'User Report',
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
        $('#user_table').on('click','.user_inactivate',function(){
            var id = $(this).data('id');
            var deleteConfirm = confirm("Do you want to inactivate the User?");
            if (deleteConfirm == true) {
                $.ajax({
                    url: 'php/ajax_user.php',
                    type: 'post',
                    data:{request: "inactivate", id: id},
                    success: function(response){
                        if(response == 1){
                            alert("User Inactivated.");
                            UsrDataTable.ajax.reload();
                        }else{
                            alert("Technical Error.Please contact administrator");
                        }
                    }
                });
            } 
        });
        
        // Activate record
        $('#user_table').on('click','.user_activate',function(){
            var id = $(this).data('id');
            var deleteConfirm = confirm("Do you want to Activate the User?");
            if (deleteConfirm == true) {
                $.ajax({
                    url: 'php/ajax_user.php',
                    type: 'post',
                    data:{request: "activate", id: id},
                    success: function(response){
                        if(response == 1){
                            alert("User Activated.");
                            UsrDataTable.ajax.reload();
                        }else{
                            alert("Technical Error.Please contact administrator");
                        }
                    }
                });
            } 
        });

        // Edit Button click : Fetch record by Id
        $('#user_table').on('click','.user_fetchbyid',function(){
            if(useracc.substring(2, 3) == "1"){
                var id = $(this).data('id');
                $.ajax({
                    url: 'php/ajax_user.php',
                    type: 'post',
                    data: {request: "loadmodal", id: id},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){
                            $('#userid').val(response.data.id);
                            $('#username').val(response.data.username);
                            $('#firstname').val(response.data.firstname);
                            $('#lastname').val(response.data.lastname);
                            $('#phone').val(response.data.phone);
                            $('#email').val(response.data.email);
                            $('#type').val(response.data.type);
                            $('#role').val(response.data.role);
                            $('#status').val(response.data.status);
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

        // Update User 
        $('#btn_usersave').click(function(){
            var id = $('#userid').val();
            var firstname = $('#firstname').val().trim();
            var lastname = $('#lastname').val().trim();
            var type = $('#type').val().trim();
            var role = $('#role').val().trim();
            var status = $('#status').val().trim();
            var phone = $('#phone').val().trim();
            var email = $('#email').val().trim();

            if(firstname !='' && lastname != '' && type != '' && role != '%%' && status != '' && phone != '' && email != ''){
                $.ajax({
                    url: 'php/ajax_user.php',
                    type: 'post',
                    data: {request: "update", id: id,firstname: firstname, lastname: lastname, type: type, role: role, status: status, phone:phone, email:email},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){
                            alert(response.message);
                            $('#firstname','#lastname','#email','#phone').val('');
                            $('#type').val('others');
                            $('#role').val('others');
                            $('#status').val('inactive');
                            UsrDataTable.ajax.reload();
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

        // Edit Avatar click : Fetch record by Id
        $('#user_table').on('click','.user_avatar_update',function(){
            if(useracc.substring(2, 3) == "1"){
                var rowid = $(this).data('id');
                $('#rowid').val(rowid);
                
            }else{
                $('#edit_photo').modal('toggle'); 
                alert("You do not have access to update records!!")
            }
        });

        // Upload Avatar button click
        $('#upload_avatar').click(function(){
            var file_data = $('#img_avatar').prop('files')[0];  
            var avatarrowid = $('#rowid').val();
            var form_data = new FormData();                  
            form_data.append('request', "imgupload");
            form_data.append('rowid', avatarrowid);
            form_data.append('file', file_data);
            //alert(form_data);                             
            $.ajax({
                url: 'php/ajax_user.php', 
                dataType: 'text', 
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(response){
                    alert(response);
                    UsrDataTable.ajax.reload();
                    $('#edit_photo').modal('toggle');  
                }
             });
        });


        // Add User 
        $('#btn_useradd').click(function(){
            var username = $('#username1').val().trim();
            var firstname = $('#firstname1').val().trim();
            var lastname = $('#lastname1').val().trim();
            var type = $('#type1').val().trim();
            var role = $('#role1').val().trim();
            var status = $('#status1').val().trim();
            var phone = $('#phone1').val().trim();
            var email = $('#email1').val().trim();

            if(username !='' && firstname !='' && lastname != '' && type != '' && role != '%%' && status != '' && phone != '' && email != ''){
                $.ajax({
                    url: 'php/ajax_user.php',
                    type: 'post',
                    data: {request: "insert", username: username,firstname: firstname, lastname: lastname, type: type, role: role, status: status, phone: phone,email: email},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){
                            console.log(response.message);
                            alert(response.message);
                            $('#firstname1').val('');
                            $('#lastname1').val('');
                            $('#username1').val('');
                            $('#phone1').val('');
                            $('#email1').val('');
                            $('#type1').val('others');
                            $('#role1').val('others');
                            $('#status1').val('inactive');
                            UsrDataTable.ajax.reload();
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


        // Add User 
        $('#btn_useradd').click(function(){
            var username = $('#username1').val().trim();
        
            
        });            
        
    }); 

       
</script>


<?php 
}else{
    header('Location: index.php');
}
?>
</html>