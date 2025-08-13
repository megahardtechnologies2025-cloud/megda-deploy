<?php
session_start();
$user_access_list = substr($_SESSION["user_access"],0,1);
$user_access_add = substr($_SESSION["user_access"],1,1);
$user_access_update = substr($_SESSION["user_access"],2,1);
$user_access_delete = substr($_SESSION["user_access"],3,1);

include_once 'dbh.php';
$request = "default";
if(isset($_POST['request'])){
    $request = $_POST['request'];
}

// DataTable data
if($request == "default"){
	$system_name = $_POST['systemname'];
    if($user_access_list == "1"){
        $sql_entitylist="SELECT `id`, `entity_name`, `IO_name`, `table_name`, `query_hierarchy`, `query_fields`, `parent_id_fields`, `summary_fields`, `system`, `status`, `created` FROM `entities`;";    
    }
    else{
        $sql_entitylist="SELECT `id`, `entity_name`, `IO_name`, `table_name`, `query_hierarchy`,`query_fields`, `parent_id_fields`, `summary_fields`, `system`, `status`, `created` FROM `entities` where `id` IS NULL;";    
    }
    $result_entitylist=mysqli_query($conn,$sql_entitylist);
    $rows= array();
    while($row=mysqli_fetch_array($result_entitylist))
    {
        $rows[]=$row;
    }
    echo json_encode($rows);
}


// Insert entity from modal
if($request == "insert"){
    $entity_name = "";

    if(isset($_POST['entity_name'])){
        $entity_name = mysqli_escape_string($conn,$_POST['entity_name']);
    }
    $record = mysqli_query($conn,"SELECT entity_name FROM entities WHERE entity_name='".$entity_name."'");
    if(mysqli_num_rows($record) > 0){
        echo json_encode( array("status" => 0,"message" => "Data Entity with same name already exists.Please use a different Name") );
        exit;
    }else{
        $entity_name = mysqli_escape_string($conn,trim($_POST['entity_name']));
        $IO_name = mysqli_escape_string($conn,trim($_POST['IO_name']));
        $table_name = mysqli_escape_string($conn,trim($_POST['table_name']));
        $query_fields = mysqli_escape_string($conn,trim($_POST['query_fields']));
        $summary_fields = mysqli_escape_string($conn,trim($_POST['summary_fields']));
        $parent_id_fields = mysqli_escape_string($conn,trim($_POST['parent_id_fields']));
        $system = mysqli_escape_string($conn,trim($_POST['system']));
        
        if($user_access_add == "1"){
            if( $entity_name != ''  ){
                $insertsql = "INSERT INTO entities (`entity_name`,`IO_name`,`table_name`,`query_fields`,`summary_fields`,`parent_id_fields`,`system`,`status`) VALUES ( '".$entity_name."','".$IO_name."','".$table_name."','".$query_fields."','".$summary_fields."','".$parent_id_fields."','".$system."','creating');";
                mysqli_query($conn,$insertsql);
                echo json_encode( array("status" => 1,"message" => $insertsql."Data Entity Record Inserted Successfully!!") ); //
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

// Fetch entity details for modal
if($request == "loadmodal"){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    $record = mysqli_query($conn,"SELECT * FROM entities WHERE id=".$id);

    $response = array();

    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
            "entity_name" => $row['entity_name'],
            "IO_name" => $row['IO_name'],
            "table_name" => $row['table_name'],
            "query_fields" => $row['query_fields'],
            "summary_fields" => $row['summary_fields'],
            "parent_id_fields" => $row['parent_id_fields'],
            "system" => $row['system'],
            "id" => $row['id'],
        );

        echo json_encode( array("status" => 1,"data" => $response) );
        exit;
    }else{
        echo json_encode( array("status" => 0) );
        exit;
    }
}



// Update entity from modal
if($request == "update"){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM entities WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){
        $entity_name = mysqli_escape_string($conn,trim($_POST['entity_name']));
        $IO_name = mysqli_escape_string($conn,trim($_POST['IO_name']));
        $table_name = mysqli_escape_string($conn,trim($_POST['table_name']));
        $query_fields = mysqli_escape_string($conn,trim($_POST['query_fields']));
        $summary_fields = mysqli_escape_string($conn,trim($_POST['summary_fields']));
        $parent_id_fields = mysqli_escape_string($conn,trim($_POST['parent_id_fields']));
        $system = mysqli_escape_string($conn,trim($_POST['system']));

        if($user_access_update == "1"){
            if( $entity_name != '' ){
                mysqli_query($conn,"UPDATE entities SET entity_name='".$entity_name."',IO_name='".$IO_name."',table_name='".$table_name."',query_fields='".$query_fields."',summary_fields='".$summary_fields."',parent_id_fields='".$parent_id_fields."',system='".$system."' WHERE id=".$id);
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

// InActivate entity
if($request == "inactivate"){
    $id = 0;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT `id` FROM `entities` WHERE `id`=".$id);
    if(mysqli_num_rows($record) > 0){
        mysqli_query($conn,"UPDATE `entities` SET `status`='inactive' WHERE `id`=".$id);
        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}

// Activate entity
if($request == "activate"){
    $id = 0;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT `id` FROM `entities` WHERE `id`=".$id);
    if(mysqli_num_rows($record) > 0){
        mysqli_query($conn,"UPDATE `entities` SET `status`='active' WHERE `id`=".$id);
        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}




?>