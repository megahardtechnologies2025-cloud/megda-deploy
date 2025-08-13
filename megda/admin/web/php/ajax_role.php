<?php 
    include_once 'dbh.php';

//Read Role
    if(isset($_POST["role"])){
        $selectedrole = $_POST["role"];
        $sql_role = "SELECT * FROM `user_role` WHERE `role_name`='$selectedrole';";
        $result_role = mysqli_query($conn, $sql_role);
        while($row_role = mysqli_fetch_array($result_role)) {
            $dashboard = $row_role['dashboard'];
            $user = $row_role['user'];
            $products = $row_role['products'];
            $categories = $row_role['categories'];
            $settings = $row_role['settings'];
            $orders = $row_role['orders'];
            $customers = $row_role['customers'];
            $delivery = $row_role['delivery'];
            $inventory = $row_role['inventory'];
            $reports = $row_role['reports'];
            $status = $row_role['status'];

            
            $role_return = array(
                "status"=>$status,
                "dashboard"=>$dashboard, 
                "user"=>$user,
                "products"=>$products,
                "categories"=>$categories,
                "settings"=>$settings,
                "orders"=>$orders,
                "customers"=>$customers,
                "delivery"=>$delivery,
                "inventory"=>$inventory,
                "reports"=>$reports
            );
            echo json_encode($role_return);
        }
    }

// Add Role
    if(isset($_POST["insertrole"])){
        $rolename_new = $_POST["rolename_new"];
        $roledispname_new = $_POST["roledispname_new"];
        $rolestatus_new = $_POST["rolestatus_new"];
        
        $dashboard_new = $_POST["dashboard_new"];
        $user_new = $_POST["user_new"];
        $product_new = $_POST["product_new"];
        $categories_new = $_POST["categories_new"];
        $settings_new = $_POST["settings_new"];
        $orders_new = $_POST["orders_new"];
        $customers_new = $_POST["customers_new"];
        $delivery_new = $_POST["delivery_new"];
        $inventory_new = $_POST["inventory_new"];
        $reports_new = $_POST["reports_new"];
        
        
        $sql_role_new = "INSERT INTO `user_role` (`id`, `role_name`, `role_disp_name`, `dashboard`, `user`, `products`, `categories`, `settings`, `orders`, `customers`, `delivery`, `inventory`, `reports`, `status`) VALUES (NULL, '$rolename_new', '$roledispname_new', '$dashboard_new', '$user_new', '$product_new', '$categories_new', '$settings_new', '$orders_new', '$customers_new', '$delivery_new', '$inventory_new', '$reports_new', '$rolestatus_new');"; 
        mysqli_query($conn,$sql_role_new);
        echo json_encode( array("status" => 1,"message" => "Role added Successfully!!") );
        exit;
    }
    
// Update Role
    if(isset($_POST["updaterole"])){
        $rolename_upd = $_POST["rolename_upd"];
        $rolestatus_upd = $_POST["rolestatus_upd"];

        $dashboard_upd = $_POST["dashboard_upd"];
        $user_upd = $_POST["user_upd"];
        $product_upd = $_POST["product_upd"];
        $categories_upd = $_POST["categories_upd"];
        $settings_upd = $_POST["settings_upd"];
        $orders_upd = $_POST["orders_upd"];
        $customers_upd = $_POST["customers_upd"];
        $delivery_upd = $_POST["delivery_upd"];
        $inventory_upd = $_POST["inventory_upd"];
        $reports_upd = $_POST["reports_upd"];
        
        
        $sql_role_upd = "UPDATE `user_role` SET `status`='$rolestatus_upd',`dashboard`='$dashboard_upd',`user`='$user_upd',`products`='$product_upd',`categories`='$categories_upd',`settings`='$settings_upd',`orders`='$orders_upd',`customers`='$customers_upd',`delivery`='$delivery_upd',`inventory`='$inventory_upd',`reports`='$reports_upd' WHERE role_name = '$rolename_upd';"; 
        mysqli_query($conn,$sql_role_upd);
        echo json_encode( array("status" => 1,"message" => "Role updated Successfully!!"));
        exit;
    }
    
// Delete Role
    if(isset($_POST["deleterole"])){
        $rolename_del = $_POST["rolenamedel"];  
        $sql_role_del = "DELETE FROM `user_role` WHERE role_name = '$rolename_del';"; 
        mysqli_query($conn,$sql_role_del);
        echo json_encode( array("status" => 1,"message" => "Role deleted Successfully!!"));
        exit;
    }

?>