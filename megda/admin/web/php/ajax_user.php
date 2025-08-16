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
        $sql_userlist="SELECT `id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `phone`, `email`, `last_login`, `type`, `role`, `status`, `date_added`, `date_updated` FROM `user`;";    
    }
    else{
        $sql_userlist="SELECT `id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `phone`, `email`, `last_login`, `type`, `role`, `status`, `date_added`, `date_updated` FROM `user` where `id` IS NULL;";    
    }
    $result_userlist=mysqli_query($conn,$sql_userlist);
    $rows= array();
    while($row=mysqli_fetch_array($result_userlist))
    {
        $rows[]=$row;
    }
    echo json_encode($rows);
}

// Fetch user details for modal
if($request == "loadmodal"){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    $record = mysqli_query($conn,"SELECT * FROM user WHERE id=".$id);

    $response = array();

    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
            "firstname" => $row['firstname'],
            "lastname" => $row['lastname'],
            "username" => $row['username'],
            "email" => $row['email'],
            "phone" => $row['phone'],
            "type" => $row['type'],
            "role" => $row['role'],
            "status" => $row['status'],
            "avatar" => $row['avatar'],
            "id" => $row['id'],
        );

        echo json_encode( array("status" => 1,"data" => $response) );
        exit;
    }else{
        echo json_encode( array("status" => 0) );
        exit;
    }
}


// Insert User from modal
if($request == "insert"){
    $username = "";

    if(isset($_POST['username'])){
        $username = mysqli_escape_string($conn,$_POST['username']);
    }
    $record = mysqli_query($conn,"SELECT username FROM user WHERE username='".$username."'");
    if(mysqli_num_rows($record) > 0){
        echo json_encode( array("status" => 0,"message" => "UserId already exists.Please use a different UserId") );
        exit;
    }else{
        $firstname = mysqli_escape_string($conn,trim($_POST['firstname']));
        $lastname = mysqli_escape_string($conn,trim($_POST['lastname']));
        $username = mysqli_escape_string($conn,trim($_POST['username']));
        $type = mysqli_escape_string($conn,trim($_POST['type']));
        $role = mysqli_escape_string($conn,trim($_POST['role']));
        $status = mysqli_escape_string($conn,trim($_POST['status']));
        $phone = mysqli_escape_string($conn,trim($_POST['phone']));
        $email = mysqli_escape_string($conn,trim($_POST['email']));
        
        $password = password_hash($phone, PASSWORD_BCRYPT);
        $avatar="";
        $last_login="";
        $date_added="";
        $date_updated="";
        if($user_access_add == "1"){
            if( $username != '' && $firstname != '' && $lastname != '' && $type != '' && $role != '' && $status != '' ){
                $insertsql = "INSERT INTO user (`id`,`firstname`,`lastname`,`username`,`type`,`role`,`status`,`password`,`phone`,`email`,`avatar`,`last_login`,`date_added`,`date_updated`) VALUES ( '','".$firstname."','".$lastname."','".$username."','".$type."','".$role."','".$status."','".$password."','".$phone."','".$email."','".$avatar."','".$last_login."','".$date_added."','".$date_updated."');";
                mysqli_query($conn,$insertsql);
                echo json_encode( array("status" => 1,"message" => "User Record Inserted Successfully!!") );
                exit;
            }else{
                echo json_encode( array("status" => 0,"message" => "Please fill all fields...") );
                exit;
            }        
        }
        else{
            echo json_encode( array("status" => 0,"message" => "You do not have previlages to Insert Records...") );
                exit;
        }
    }
}

// Update User from modal
if($request == "update"){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM user WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){
        $firstname = mysqli_escape_string($conn,trim($_POST['firstname']));
        $lastname = mysqli_escape_string($conn,trim($_POST['lastname']));
        $type = mysqli_escape_string($conn,trim($_POST['type']));
        $role = mysqli_escape_string($conn,trim($_POST['role']));
        $status = mysqli_escape_string($conn,trim($_POST['status']));
        $phone = mysqli_escape_string($conn,trim($_POST['phone']));
        $email = mysqli_escape_string($conn,trim($_POST['email']));

        if($user_access_update == "1"){
            if( $firstname != '' && $lastname != '' && $type != '' && $role != '' && $status != '' && $phone != '' && $email != '' ){
                mysqli_query($conn,"UPDATE employee SET firstname='".$firstname."',lastname='".$lastname."',type='".$type."',role='".$role."',status='".$status."',phone='".$phone."',email='".$email."' WHERE id=".$id);
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

// InActivate Employee
if($request == "inactivate"){
    $id = 0;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT `id` FROM `user` WHERE `id`=".$id);
    if(mysqli_num_rows($record) > 0){
        mysqli_query($conn,"UPDATE `user` SET `status`='inactive' WHERE `id`=".$id);
        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}

// Activate Employee
if($request == "activate"){
    $id = 0;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT `id` FROM `user` WHERE `id`=".$id);
    if(mysqli_num_rows($record) > 0){
        mysqli_query($conn,"UPDATE `user` SET `status`='active' WHERE `id`=".$id);
        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}

// InActivate Employee
if($request == "inactivate_emp"){
    if(isset($_POST['updaterole'])){
        $role_inactive_emp = mysqli_escape_string($conn,$_POST['updaterole']);
    }
    mysqli_query($conn,"UPDATE `user` SET `status`='inactive' WHERE `role`='".$role_inactive_emp."';");
    echo 1;
    exit;

}

// Update Avatar
if($request == "imgupload"){
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/employee/' . $_FILES['file']['name']);
        $id = 0;
        if(isset($_POST['rowid'])){
            $id = mysqli_escape_string($conn,$_POST['rowid']);
        }
        //Check id
        $record = mysqli_query($conn,"SELECT `id` FROM `user` WHERE `id`=".$id);
        if(mysqli_num_rows($record) > 0){
            $filepath = 'uploads/employee/' . $_FILES['file']['name'];
            mysqli_query($conn,"UPDATE `user` SET `avatar`='$filepath' WHERE `id`=".$id);
            echo "image uploaded successfully";
            exit;
        }else{
            echo $id;
            exit;
        }        
    }
} 

// Fetch user details for profile view
if($request == "profile_load"){
    if(isset($_POST['userid'])){
        $id = mysqli_escape_string($conn,$_POST['userid']);
    }

    $record = mysqli_query($conn,"SELECT * FROM user WHERE username='".$id."';");

    $response = array();

    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
            "firstname" => $row['firstname'],
            "lastname" => $row['lastname'],
            "username" => $row['username'],
            "email" => $row['email'],
            "phone" => $row['phone'],
            "type" => $row['type'],
            "role" => $row['role'],
            "status" => $row['status'],
            "avatar" => $row['avatar'],
            "id" => $row['id'],
        );

        echo json_encode( array("status" => 1,"data" => $response) );
        exit;
    }else{
        echo json_encode( array("status" => 0) );
        exit;
    }
}

// Update Employee in profile view
if($request == "update_profile"){
    if(isset($_POST['userid'])){
        $id = mysqli_escape_string($conn,$_POST['userid']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM user WHERE username='".$id."';");
    if(mysqli_num_rows($record) > 0){
        $firstname = mysqli_escape_string($conn,trim($_POST['firstname']));
        $lastname = mysqli_escape_string($conn,trim($_POST['lastname']));
        $phone = mysqli_escape_string($conn,trim($_POST['phone']));
        $email = mysqli_escape_string($conn,trim($_POST['email']));

        if( $firstname != '' && $lastname != '' && $phone != '' && $email != '' ){
            mysqli_query($conn,"UPDATE user SET firstname='".$firstname."',lastname='".$lastname."',phone='".$phone."',email='".$email."' WHERE username='".$id."';");
            echo json_encode( array("status" => 1,"message" => "User Profile updated.") );
            exit;
        }else{
            echo json_encode( array("status" => 0,"message" => "Please fill all fields.") );
            exit;
        }
    }else{
        echo json_encode( array("status" => 0,"message" => "Invalid ID.") );
        exit;
    }
}

// Update Profile Avatar
if($request == "profileimgupload"){
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/employee/' . $_FILES['file']['name']);
        if(isset($_POST['avataruserid'])){
            $id = mysqli_escape_string($conn,$_POST['avataruserid']);
        }
        //Check id
        $record = mysqli_query($conn,"SELECT `id` FROM `user` WHERE `username`='".$id."';");
        if(mysqli_num_rows($record) > 0){
            $filepath = 'uploads/employee/' . $_FILES['file']['name'];
            mysqli_query($conn,"UPDATE `user` SET `avatar`='$filepath' WHERE `username`='".$id."';");
            echo "image uploaded successfully";
            exit;
        }else{
            echo $id;
            exit;
        }        
    }
} 

// Update Profile Password
if($request == "updatepassword"){
    if(isset($_POST['userid'])){
        $id = mysqli_escape_string($conn,$_POST['userid']);
        $password = mysqli_escape_string($conn,$_POST['password']);
        $password_encrypt = password_hash($password, PASSWORD_BCRYPT);
    }
    //Check id
    $record = mysqli_query($conn,"SELECT `id` FROM `user` WHERE `username`='".$id."';");
    if(mysqli_num_rows($record) > 0){
        mysqli_query($conn,"UPDATE `user` SET `password`='$password_encrypt' WHERE `username`='".$id."';");
        echo "Password updated successfully!!";
        exit;
    }else{
        echo "Issue with Password Update. Please contact Administrator";
        exit;
    }        
} 



?>
