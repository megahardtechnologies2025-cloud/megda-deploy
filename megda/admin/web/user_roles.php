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
<style>
    td{
        text-align: center; 
        vertical-align: middle;
    }
</style>
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
                        <h4 class="page-title">Roles Administration</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Roles</li>
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
                                <h4 class="card-title">Roles Data</h4>
                                <h6 class="card-subtitle">Roles are the previlages that the user will have.The view restrictions will be based on the role that the user is having. Refer Documentation <a href="https://datatables.net/">Role Administration</a></h6>
                    			<div class="table-responsive bs-example widget-shadow">
                				    <div class="row mt-2 mb-2">
                    			        <div class="col-lg-2 col-md-3 col-sm-12 p-0 ml-2">
                                            <h3 class="title1">Select Role :</h3>
                                        </div>
                                        <?php
                                            session_start();
                                            include_once "php/dbh.php";
                                            if($user_access_list == "1"){
                                                $sql_role = "SELECT role_name FROM user_role where role_name<>'selectrole';";    
                                            }else{
                                                $sql_role = "SELECT role_name FROM user_role where id IS NULL;";
                                            }
                                            
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
                                        <div class="col-lg-2 col-md-3 col-sm-12 p-0">
                                            <select class="form-control search-slt" id="roleselect">
                                                <option value="selectrole" selected="selected">Select Role </option>
                                                <?php foreach($role as $val) {?>
                                                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 col-md-3 col-sm-12 p-0">
                                        </div>                            
                    			        <div class="col-lg-6 col-md-3 col-sm-12 p-0">
                    			        <?php 
                    				        if($user_access_add == "1"){
                    				            echo "<button class='btn btn-success navbar-btn' style='margin-right:10px;float:right' data-toggle='modal' data-target='#addroleModal'><i class='fa fa-plus' style='color:white;margin-right:5px;'></i>ADD NEW ROLE</button>";
                    				        }
                    				        if($user_access_update == "1"){
                    				            echo "<button class='btn btn-info navbar-btn' id='btn_updaterole' style='margin-right:10px;float:right'><i class='fas fa-arrow-up' style='color:white;margin-right:5px;' ></i>UPDATE ROLE</button>";
                    				        }
                    				        if($user_access_delete == "1"){
                    				            echo "<button class='btn btn-danger navbar-btn' id='btn_deleterole' style='margin-right:10px;float:right'><i class='fa fa-times' style='color:white;margin-right:5px;'></i>DELETE ROLE</button>";
                    				        }
            
                    				        
                    				    ?>
                                            
                                        </div>
                    			    </div>
                    			    
                    				<div class="panel-body widget-shadow">
                    					<h3 style="width: 15%;">Role Entitlements:</h3>
                    					<div style="width: 15%;">
                                            <select class="form-control search-slt" id="rolestatus">
                                                <option value="%%" selected="selected">Select Status </option>
                                                <option value="active" selected="selected">Active </option>
                                                <option value="inactive" selected="selected">InActive </option>
                                            </select>
                                        </div>
                    					<table class="table table-bordered stats-table">
                    						<thead>
                    							<tr>
                    							  <th>#</th>
                    							  <th>Entity</th>
                    							  <th>View</th>
                    							  <th>Add</th>
                    							  <th>Update</th>
                    							  <th>Delete</th>
                    							</tr>
                    						</thead>
                    						<tbody>
                    							<tr>
                    							  <th scope="row">1</th>
                    							  <td>Dashboard</td>
                    							  <td><input class="form-check-input" type="checkbox" id="dsb_viw" /></td>
                    							  <td></td>
                    							  <td></td>
                    							  <td></td>
                    							</tr>
                    							<tr>
                    							  <th scope="row">2</th>
                    							  <td>User</td>
                    							  <td><input class="form-check-input" type="checkbox" id="emp_viw" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="emp_add" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="emp_upd" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="emp_del" /></td>
                    							</tr>
                    							<tr>
                    							  <th scope="row">3</th>
                    							  <td>Systems</td>
                    							  <td><input class="form-check-input" type="checkbox" id="prd_viw" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="prd_add" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="prd_upd" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="prd_del" /></td>
                    							</tr>
                    							<tr>
                    							  <th scope="row">4</th>
                    							  <td>Connections</td>
                    							  <td><input class="form-check-input" type="checkbox" id="cat_viw" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="cat_add" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="cat_upd" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="cat_del" /></td>
                    							</tr>
            
                    							<tr>
                    							  <th scope="row">5</th>
                    							  <td>Rules</td>
                    							  <td><input class="form-check-input" type="checkbox" id="set_viw" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="set_add" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="set_upd" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="set_del" /></td>
                    							</tr>
                    							<tr>
                    							  <th scope="row">6</th>
                    							  <td>Observability</td>
                    							  <td><input class="form-check-input" type="checkbox" id="ord_viw" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="ord_add" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="ord_upd" /></td>
                    							  <td><input class="form-check-input" type="checkbox" id="ord_del" /></td>
                    							</tr>
                     							<tr>
                    							  <th scope="row">10</th>
                    							  <td>Reports</td>
                    							  <td><input class="form-check-input" type="checkbox" id="rpt_viw" /></td>
                    							  <td></td>
                    							  <td></td>
                    							  <td></td>
                    							</tr>
            
                    						</tbody>
                    					</table>
                    				</div>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- Add Role Modal -->
                <div id="addroleModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add New Role</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="rolename_new" >Role Name</label>
                                    <input type="text" class="form-control" id="rolename_new" placeholder="Enter Role Name" required>            
                                </div>
                                <div class="form-group">
                                    <label for="roledispname_new" >Role Display Name</label>
                                    <input type="text" class="form-control" id="roledispname_new" placeholder="Enter Role Display Name" required>            
                                </div>
                                <div class="form-group">
                                    <label for="rolestatus_new" >Status</label>
                                    <select id='rolestatus_new' class="form-control">
                                        <option value='active'>Active</option>
                                        <option value='inactive'>Inactive</option>
                                    </select>              
                                </div>  
                                <h3 style="width: 65%;">Select Role Entitlements:</h3>
            					<table class="table table-bordered">
            						<thead>
            							<tr>
            							  <th>#</th>
            							  <th>Entity</th>
            							  <th>View</th>
            							  <th>Add</th>
            							  <th>Update</th>
            							  <th>Delete</th>
            							</tr>
            						</thead>
            						<tbody>
            							<tr>
            							  <th scope="row">1</th>
            							  <td>Dashboard</td>
            							  <td><input class="form-check-input" type="checkbox" id="dsb_viw_new" /></td>
            							  <td></td>
            							  <td></td>
            							  <td></td>
            							</tr>
            							<tr>
            							  <th scope="row">2</th>
            							  <td>User</td>
            							  <td><input class="form-check-input" type="checkbox" id="emp_viw_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="emp_add_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="emp_upd_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="emp_del_new" /></td>
            							</tr>
            							<tr>
            							  <th scope="row">3</th>
            							  <td>Products</td>
            							  <td><input class="form-check-input" type="checkbox" id="prd_viw_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="prd_add_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="prd_upd_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="prd_del_new" /></td>
            							</tr>
            							<tr>
            							  <th scope="row">4</th>
            							  <td>Categories</td>
            							  <td><input class="form-check-input" type="checkbox" id="cat_viw_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="cat_add_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="cat_upd_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="cat_del_new" /></td>
            							</tr>
    
            							<tr>
            							  <th scope="row">5</th>
            							  <td>Settings</td>
            							  <td><input class="form-check-input" type="checkbox" id="set_viw_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="set_add_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="set_upd_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="set_del_new" /></td>
            							</tr>
            							<tr>
            							  <th scope="row">6</th>
            							  <td>Orders</td>
            							  <td><input class="form-check-input" type="checkbox" id="ord_viw_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="ord_add_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="ord_upd_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="ord_del_new" /></td>
            							</tr>
            							<tr>
            							  <th scope="row">7</th>
            							  <td>Customers</td>
            							  <td><input class="form-check-input" type="checkbox" id="cus_viw_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="cus_add_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="cus_upd_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="cus_del_new" /></td>
            							</tr>
            							<tr>
            							  <th scope="row">8</th>
            							  <td>Delivery</td>
            							  <td><input class="form-check-input" type="checkbox" id="del_viw_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="del_add_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="del_upd_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="del_del_new" /></td>
            							</tr>
            							<tr>
            							  <th scope="row">9</th>
            							  <td>Inventory</td>
            							  <td><input class="form-check-input" type="checkbox" id="inv_viw_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="inv_add_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="inv_upd_new" /></td>
            							  <td><input class="form-check-input" type="checkbox" id="inv_del_new" /></td>
            							</tr>        							
            							<tr>
            							  <th scope="row">10</th>
            							  <td>Reports</td>
            							  <td><input class="form-check-input" type="checkbox" id="rpt_viw_new" /></td>
            							  <td></td>
            							  <td></td>
            							  <td></td>
            							</tr>
    
            						</tbody>
            					</table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success btn-sm" id="btn_role_add">Add</button>
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

</body>

<script>
    $(document).ready(function() {
        $("#roleselect").change(function(){
            var selectedrole =  this.value;
		    $.ajax({
		        method:"POST",
		        url:"php/ajax_role.php",
		        data:{
		            role:selectedrole
		        },
		        success:function(response){
   	               //console.log(response);
   	               var obj = JSON.parse(response);
   	               $('#rolestatus').val(obj.status)
   	               //dashboard
   	               if(obj.dashboard[0]=="1"){$("#dsb_viw").prop("checked",true);}else{$("#dsb_viw").prop("checked",false);};
                   //employee
                   if(obj.user[0]=="1"){$("#emp_viw").prop("checked",true);}else{$("#emp_viw").prop("checked",false);};
                   if(obj.user[1]=="1"){$("#emp_add").prop("checked",true);}else{$("#emp_add").prop("checked",false);};
                   if(obj.user[2]=="1"){$("#emp_upd").prop("checked",true);}else{$("#emp_upd").prop("checked",false);};
                   if(obj.user[3]=="1"){$("#emp_del").prop("checked",true);}else{$("#emp_del").prop("checked",false);};
                  //product
                   if(obj.products[0]=="1"){$("#prd_viw").prop("checked",true);}else{$("#prd_viw").prop("checked",false);};
                   if(obj.products[1]=="1"){$("#prd_add").prop("checked",true);}else{$("#prd_add").prop("checked",false);};
                   if(obj.products[2]=="1"){$("#prd_upd").prop("checked",true);}else{$("#prd_upd").prop("checked",false);};
                   if(obj.products[3]=="1"){$("#prd_del").prop("checked",true);}else{$("#prd_del").prop("checked",false);};
                  //categories
                   if(obj.categories[0]=="1"){$("#cat_viw").prop("checked",true);}else{$("#cat_viw").prop("checked",false);};
                   if(obj.categories[1]=="1"){$("#cat_add").prop("checked",true);}else{$("#cat_add").prop("checked",false);};
                   if(obj.categories[2]=="1"){$("#cat_upd").prop("checked",true);}else{$("#cat_upd").prop("checked",false);};
                   if(obj.categories[3]=="1"){$("#cat_del").prop("checked",true);}else{$("#cat_del").prop("checked",false);};
                  //Settings
                   if(obj.settings[0]=="1"){$("#set_viw").prop("checked",true);}else{$("#set_viw").prop("checked",false);};
                   if(obj.settings[1]=="1"){$("#set_add").prop("checked",true);}else{$("#set_add").prop("checked",false);};
                   if(obj.settings[2]=="1"){$("#set_upd").prop("checked",true);}else{$("#set_upd").prop("checked",false);};
                   if(obj.settings[3]=="1"){$("#set_del").prop("checked",true);}else{$("#set_del").prop("checked",false);};
                  //Orders
                   if(obj.orders[0]=="1"){$("#ord_viw").prop("checked",true);}else{$("#ord_viw").prop("checked",false);};
                   if(obj.orders[1]=="1"){$("#ord_add").prop("checked",true);}else{$("#ord_add").prop("checked",false);};
                   if(obj.orders[2]=="1"){$("#ord_upd").prop("checked",true);}else{$("#ord_upd").prop("checked",false);};
                   if(obj.orders[3]=="1"){$("#ord_del").prop("checked",true);}else{$("#ord_del").prop("checked",false);};
                  //Customers
                   if(obj.customers[0]=="1"){$("#cus_viw").prop("checked",true);}else{$("#cus_viw").prop("checked",false);};
                   if(obj.customers[1]=="1"){$("#cus_add").prop("checked",true);}else{$("#cus_add").prop("checked",false);};
                   if(obj.customers[2]=="1"){$("#cus_upd").prop("checked",true);}else{$("#cus_upd").prop("checked",false);};
                   if(obj.customers[3]=="1"){$("#cus_del").prop("checked",true);}else{$("#cus_del").prop("checked",false);};
                  //Delivery
                   if(obj.delivery[0]=="1"){$("#del_viw").prop("checked",true);}else{$("#del_viw").prop("checked",false);};
                   if(obj.delivery[1]=="1"){$("#del_add").prop("checked",true);}else{$("#del_add").prop("checked",false);};
                   if(obj.delivery[2]=="1"){$("#del_upd").prop("checked",true);}else{$("#del_upd").prop("checked",false);};
                   if(obj.delivery[3]=="1"){$("#del_del").prop("checked",true);}else{$("#del_del").prop("checked",false);};
                  //Inventory
                   if(obj.inventory[0]=="1"){$("#inv_viw").prop("checked",true);}else{$("#inv_viw").prop("checked",false);};
                   if(obj.inventory[1]=="1"){$("#inv_add").prop("checked",true);}else{$("#inv_add").prop("checked",false);};
                   if(obj.inventory[2]=="1"){$("#inv_upd").prop("checked",true);}else{$("#inv_upd").prop("checked",false);};
                   if(obj.inventory[3]=="1"){$("#inv_del").prop("checked",true);}else{$("#inv_del").prop("checked",false);};
                  //Reports
                   if(obj.reports[0]=="1"){$("#rpt_viw").prop("checked",true);}else{$("#rpt_viw").prop("checked",false);};

		        }
		    });
        }); 
        
        // Add Role 
        $('#btn_role_add').click(function(){
            var rolename_new = $('#rolename_new').val().trim();
            var roledispname_new = $('#roledispname_new').val().trim();
            var rolestatus_new = $('#rolestatus_new').val().trim();
            
            //var dashboard_new = function abc(){if($('#dsb_viw_new').prop('checked')){return 1;}else{return 0;}};
            
            var dashboard_new = ($('#dsb_viw_new').prop('checked') ? 1 : 0) + "000";
            var employee_new = String($('#emp_viw_new').prop('checked') ? 1 : 0) + String($('#emp_add_new').prop('checked') ? 1 : 0) + String($('#emp_upd_new').prop('checked') ? 1 : 0) + String($('#emp_del_new').prop('checked') ? 1 : 0);
            var product_new = String($('#prd_viw_new').prop('checked') ? 1 : 0) + String($('#prd_add_new').prop('checked') ? 1 : 0) + String($('#prd_upd_new').prop('checked') ? 1 : 0) + String($('#prd_del_new').prop('checked') ? 1 : 0);
            var categories_new = String($('#cat_viw_new').prop('checked') ? 1 : 0) + String($('#cat_add_new').prop('checked') ? 1 : 0) + String($('#cat_upd_new').prop('checked') ? 1 : 0) + String($('#cat_del_new').prop('checked') ? 1 : 0);
            var settings_new = String($('#set_viw_new').prop('checked') ? 1 : 0) + String($('#set_add_new').prop('checked') ? 1 : 0) + String($('#set_upd_new').prop('checked') ? 1 : 0) + String($('#set_del_new').prop('checked') ? 1 : 0);
            var orders_new = String($('#ord_viw_new').prop('checked') ? 1 : 0) + String($('#ord_add_new').prop('checked') ? 1 : 0) + String($('#ord_upd_new').prop('checked') ? 1 : 0) + String($('#ord_del_new').prop('checked') ? 1 : 0);
            var customers_new = String($('#cus_viw_new').prop('checked') ? 1 : 0) + String($('#cus_add_new').prop('checked') ? 1 : 0) + String($('#cus_upd_new').prop('checked') ? 1 : 0) + String($('#cus_del_new').prop('checked') ? 1 : 0);
            var delivery_new = String($('#del_viw_new').prop('checked') ? 1 : 0) + String($('#del_add_new').prop('checked') ? 1 : 0) + String($('#del_upd_new').prop('checked') ? 1 : 0) + String($('#del_del_new').prop('checked') ? 1 : 0);
            var inventory_new = String($('#inv_viw_new').prop('checked') ? 1 : 0) + String($('#inv_add_new').prop('checked') ? 1 : 0) + String($('#inv_upd_new').prop('checked') ? 1 : 0) + String($('#inv_del_new').prop('checked') ? 1 : 0);
            var reports_new = String($('#rpt_viw_new').prop('checked') ? 1 : 0) + "000";
            
            if(rolename_new !='' && rolestatus_new !=''){
                $.ajax({
                    url: 'php/ajax_role.php',
                    type: 'post',
                    data: {insertrole: "insertrole", rolename_new: rolename_new,roledispname_new: roledispname_new,rolestatus_new: rolestatus_new,dashboard_new: dashboard_new,employee_new: employee_new, product_new: product_new, categories_new: categories_new, settings_new: settings_new, orders_new: orders_new, customers_new: customers_new,delivery_new: delivery_new,inventory_new: inventory_new,reports_new: reports_new},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){
                            alert(response.message);
                            $('#addroleModal').modal('toggle'); 
                            location.reload(); 
                        }else{
                            alert(response.message);
                            $('#addroleModal').modal('toggle'); 
                        }
                    }
                });
            }else{
                alert('Please fill required fields...!!');
            }
        });


        // Update Role 
        $('#btn_updaterole').click(function(){
            var rolename_upd = $('#roleselect').val().trim();
            var rolestatus_upd = $('#rolestatus').val().trim();

            var dashboard_upd = ($('#dsb_viw').prop('checked') ? 1 : 0) + "000";
            var employee_upd = String($('#emp_viw').prop('checked') ? 1 : 0) + String($('#emp_add').prop('checked') ? 1 : 0) + String($('#emp_upd').prop('checked') ? 1 : 0) + String($('#emp_del').prop('checked') ? 1 : 0);
            var product_upd = String($('#prd_viw').prop('checked') ? 1 : 0) + String($('#prd_add').prop('checked') ? 1 : 0) + String($('#prd_upd').prop('checked') ? 1 : 0) + String($('#prd_del').prop('checked') ? 1 : 0);
            var categories_upd = String($('#cat_viw').prop('checked') ? 1 : 0) + String($('#cat_add').prop('checked') ? 1 : 0) + String($('#cat_upd').prop('checked') ? 1 : 0) + String($('#cat_del').prop('checked') ? 1 : 0);
            var settings_upd = String($('#set_viw').prop('checked') ? 1 : 0) + String($('#set_add').prop('checked') ? 1 : 0) + String($('#set_upd').prop('checked') ? 1 : 0) + String($('#set_del').prop('checked') ? 1 : 0);
            var orders_upd = String($('#ord_viw').prop('checked') ? 1 : 0) + String($('#ord_add').prop('checked') ? 1 : 0) + String($('#ord_upd').prop('checked') ? 1 : 0) + String($('#ord_del').prop('checked') ? 1 : 0);
            var customers_upd = String($('#cus_viw').prop('checked') ? 1 : 0) + String($('#cus_add').prop('checked') ? 1 : 0) + String($('#cus_upd').prop('checked') ? 1 : 0) + String($('#cus_del').prop('checked') ? 1 : 0);
            var delivery_upd = String($('#del_viw').prop('checked') ? 1 : 0) + String($('#del_add').prop('checked') ? 1 : 0) + String($('#del_upd').prop('checked') ? 1 : 0) + String($('#del_del').prop('checked') ? 1 : 0);
            var inventory_upd = String($('#inv_viw').prop('checked') ? 1 : 0) + String($('#inv_add').prop('checked') ? 1 : 0) + String($('#inv_upd').prop('checked') ? 1 : 0) + String($('#inv_del').prop('checked') ? 1 : 0);
            var reports_upd = String($('#rpt_viw').prop('checked') ? 1 : 0) + "000";
            
            if(rolename_upd !='%%'){
                $.ajax({
                    url: 'php/ajax_role.php',
                    type: 'post',
                    data: {updaterole: "updaterole", rolename_upd: rolename_upd,rolestatus_upd: rolestatus_upd,dashboard_upd: dashboard_upd,employee_upd: employee_upd, product_upd: product_upd, categories_upd: categories_upd, settings_upd: settings_upd, orders_upd: orders_upd, customers_upd: customers_upd,delivery_upd: delivery_upd,inventory_upd: inventory_upd,reports_upd: reports_upd},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){
                            if(rolestatus_upd == 'inactive'){
                                $.ajax({
                                    url: 'php/employee_ajax.php',
                                    type: 'post',
                                    data:{request: "inactivate_emp", updaterole: rolename_upd},
                                    success: function(response){
                                        if(response){
                                            alert("Role and also, Employee with that role Inactivated.");
                                            //alert(response);
                                            location.reload();
                                        }else{
                                            alert("Technical Error.Please contact administrator");
                                        }
                                    }
                                });
                                location.reload();
                            }else{
                                alert("Role updated.");
                            }
                        }else{
                            alert(response.message);
                        }
                    }
                });
            }else{
                alert('Please Select Role...!!');
            }
        });
 
         // Delete Role 
        $('#btn_deleterole').click(function(){ 
            var rolenamedel = $('#roleselect').val().trim();
            var deleteConfirm = confirm("Do you want to delete this role?");
                if (deleteConfirm == true) {
                    $.ajax({
                        url: 'php/ajax_role.php',
                        type: 'post',
                        data:{deleterole: "deleterole", rolenamedel: rolenamedel},
                        dataType: 'json',
                        success: function(response){
                            if(response.status == 1){
                                alert(response.message);
                                location.reload(); 
                            }else{
                                alert("Technical Error.Please contact administrator");
                            }
                        }
                    });
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