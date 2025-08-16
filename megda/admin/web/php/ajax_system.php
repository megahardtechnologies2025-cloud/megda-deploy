<?php
session_start();
$user_access_list = substr($_COOKIE["user_access"],0,1);
$user_access_add = substr($_COOKIE["user_access"],1,1);
$user_access_update = substr($_COOKIE["user_access"],2,1);
$user_access_delete = substr($_COOKIE["user_access"],3,1);

include_once 'dbh.php';
$request = "default";
if(isset($_POST['request'])){
    $request = $_POST['request'];
}

// DataTable data
if($request == "default"){

    if($user_access_list == "1"){
        $sql_systemlist="SELECT `id`, `system_name`, `system_details`, `database_type`, `database_name`, `REST_endpoint`, `filesystem_path`, `status`, `created_dt`, `created_by`, `updated_dt`, `updated_by` FROM `system`;";    
    }
    else{
        $sql_systemlist="SELECT `id`, `system_name`, `system_details`, `database_type`, `database_name`, `REST_endpoint`, `filesystem_path`, `status`, `created_dt`, `created_by`, `updated_dt`, `updated_by` FROM `system` where `id` IS NULL;";    
    }
    $result_systemlist=mysqli_query($conn,$sql_systemlist);
    $rows= array();
    while($row=mysqli_fetch_array($result_systemlist))
    {
        $rows[]=$row;
    }
    echo json_encode($rows);
}

// Insert user from modal
if($request == "insert"){
    $system_name = "";

    if(isset($_POST['system_name'])){
        $system_name = mysqli_escape_string($conn,$_POST['system_name']);
    }
    $record = mysqli_query($conn,"SELECT `system_name` FROM `system` WHERE `system_name`='".$system_name."'");
    if(mysqli_num_rows($record) > 0){
        echo json_encode( array("status" => 0,"message" => "System with same name exists.Please use a different System Name") );
        exit;
    }else{
        $system_name = mysqli_escape_string($conn,trim($_POST['system_name']));
        $system_details = mysqli_escape_string($conn,trim($_POST['system_details']));
        
        if($user_access_add == "1"){
            if( $system_name != '' ){
                $insertsql = "INSERT INTO `system` (`system_name`,`system_details`,`status`) VALUES ( '$system_name','$system_details','creating');";
                mysqli_query($conn,$insertsql);
                echo json_encode( array("status" => 1,"message" => "System Record Inserted Successfully!!") );
                exit;
            }else{
                echo json_encode( array("status" => 0,"message" => "Please fill all fields...") );
                exit;
            }        
        }
        else{
            echo json_encode( array("status" => 0,"message" => "You do not have previlages to Insert System Records...") );
                exit;
        }
    }
}


// Fetch user details for modal
if($request == "loadmodal"){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    $record = mysqli_query($conn,"SELECT * FROM system WHERE id=".$id);

    $response = array();

    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
            "system_name" => $row['system_name'],
            "system_details" => $row['system_details'],
            "database_type" => $row['database_type'],
            "database_name" => $row['database_name'],
            "REST_endpoint" => $row['REST_endpoint'],
            "filesystem_path" => $row['filesystem_path'],
            "status" => $row['status'],
            "id" => $row['id'],
        );

        echo json_encode( array("status" => 1,"data" => $response) );
        exit;
    }else{
        echo json_encode( array("status" => 0) );
        exit;
    }
}


// Update user from modal
if($request == "update"){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM system WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){
        $system_name = mysqli_escape_string($conn,trim($_POST['system_name']));
        $system_details = mysqli_escape_string($conn,trim($_POST['system_details']));
        $database_type = mysqli_escape_string($conn,trim($_POST['database_type']));
        $database_name = mysqli_escape_string($conn,trim($_POST['database_name']));
        $REST_endpoint = mysqli_escape_string($conn,trim($_POST['REST_endpoint']));
        $filesystem_path = mysqli_escape_string($conn,trim($_POST['filesystem_path']));

        if($user_access_update == "1"){
            if( $system_name != ''  ){
                mysqli_query($conn,"UPDATE system SET system_name='".$system_name."',system_details='".$system_details."',database_type='".$database_type."',database_name='".$database_name."',REST_endpoint='".$REST_endpoint."',filesystem_path='".$filesystem_path."' WHERE id=".$id);
                echo json_encode( array("status" => 1,"message" => "Record updated.") );
                exit;
            }else{
                echo json_encode( array("status" => 0,"message" => "Please fill all fields.") );
                exit;
            }
        }
        else{
            echo json_encode( array("status" => 0,"message" => "You do not have previlages to Update Records...") );
            exit;
            
        }
    }else{
        echo json_encode( array("status" => 0,"message" => "Invalid ID.") );
        exit;
    }
}

// InActivate user
if($request == "inactivate"){
    $id = 0;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT `id` FROM `system` WHERE `id`=".$id);
    if(mysqli_num_rows($record) > 0){
        mysqli_query($conn,"UPDATE `system` SET `status`='inactive' WHERE `id`=".$id);
        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}

// Activate user
if($request == "activate"){
    $id = 0;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT `id` FROM `system` WHERE `id`=".$id);
    if(mysqli_num_rows($record) > 0){
        mysqli_query($conn,"UPDATE `system` SET `status`='active' WHERE `id`=".$id);
        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}




?>
