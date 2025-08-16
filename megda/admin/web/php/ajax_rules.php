<?php
session_start();
$user_access_list = substr($_COOKIE["user_access"],0,1);
$user_access_add = substr($_COOKIE["user_access"],1,1);
$user_access_update = substr($_COOKIE["user_access"],2,1);
$user_access_delete = substr($_COOKIE["user_access"],3,1);

$loggedin_user = $_COOKIE['UserId'];

include_once 'dbh.php';
$request = "default";
if(isset($_POST['request'])){
    $request = $_POST['request'];
}

// DataTable data
if($request == "default"){

    if($user_access_list == "1"){
        $sql_rulelist="SELECT `id`, `rule_name`, `rule_desc`, `source_system`, `data_entity`, `IO_name`, `base_table`, `rule_criteria`, `rule_status`, `archive_source`, `archive_type`, `archive_attachment`, `activation_date`, `expiration_date`, `frequency`, `execution_start_time`, `execution_end_time`, `reterival_required`, `summary_required`, `summary_type`, `summary_fields`, `parent_id_fields`, `query_fields`, `retention_period`, `archive_destination`, `created_dt`, `created_by`, `updated_dt`, `updated_by` FROM `rules` WHERE 1";    
    }
    else{
        $sql_rulelist="SELECT `id`, `rule_name`, `rule_desc`, `source_system`, `data_entity`, `IO_name`, `base_table`, `rule_criteria`, `rule_status`, `archive_source`, `archive_type`, `archive_attachment`, `activation_date`, `expiration_date`, `frequency`, `execution_start_time`, `execution_end_time`, `reterival_required`, `summary_required`, `summary_type`, `summary_fields`, `parent_id_fields`, `query_fields`, `retention_period`, `archive_destination`, `created_dt`, `created_by`, `updated_dt`, `updated_by` FROM `rules` WHERE `id` IS NULL;";    
    }
    $result_rulelist=mysqli_query($conn,$sql_rulelist);
    $rows= array();
    while($row=mysqli_fetch_array($result_rulelist))
    {
        $rows[]=$row;
    }
    echo json_encode($rows);
}


// Fetch Entities for selected System
if($request == "get_entities_for_system"){
    $system = mysqli_escape_string($conn,$_POST['system']);

    $sql_entities = "SELECT `id`, `entity_name` FROM `entities` WHERE `status`='active' and `system`='$system';";
    $results_entities = mysqli_query($conn, $sql_entities);
    echo "<option value='%%' selected='selected'>Select Entity </option>";
    while($row_entity = mysqli_fetch_array($results_entities)) {        
        echo "<option value='".$row_entity['entity_name']."'>".$row_entity['entity_name']."</option>";
    } 

}


// Fetch Query Fields for selected Entity
if($request == "get_fields_for_entities"){
    $entity = mysqli_escape_string($conn,$_POST['entity']);

    $sql_query_fields = "SELECT query_fields FROM entities WHERE status='active' and entity_name='$entity';";
    $results_query_fields = mysqli_query($conn, $sql_query_fields);
    echo "<option value='%%' selected='selected'>Select Entity </option>";
    while($row_entity = mysqli_fetch_array($results_query_fields)) {        
        $query_fields = $row_entity['query_fields'];
    } 
    preg_match_all('/\[[^\]]+\]/', $query_fields, $matches);
    $fields = $matches[0];
    foreach ($fields as $field){
        echo "<option value='".htmlspecialchars($field)."'>".htmlspecialchars($field)."</option>";      
    }
          

}

// Insert entity from modal
if($request == "insert"){

    $rule_name = mysqli_escape_string($conn,trim($_POST['rule_name']));
    $system = mysqli_escape_string($conn,trim($_POST['system']));
    $data_entity = mysqli_escape_string($conn,trim($_POST['data_entity']));
    $rule_desc = mysqli_escape_string($conn,trim($_POST['rule_desc']));
    $rule_criteria = mysqli_escape_string($conn,trim($_POST['rule_criteria']));
    $archive_type = mysqli_escape_string($conn,trim($_POST['archive_type']));
    $archive_attachment = mysqli_escape_string($conn,trim($_POST['archive_attachment']));
    $reterival_required = mysqli_escape_string($conn,trim($_POST['reterival_required']));
    $summary_required = mysqli_escape_string($conn,trim($_POST['summary_required']));
    $summary_type = mysqli_escape_string($conn,trim($_POST['summary_type']));
    $rrule = mysqli_escape_string($conn,trim($_POST['rrule']));
    $execution_start_time = mysqli_escape_string($conn,trim($_POST['execution_start_time']));
    $execution_end_time = mysqli_escape_string($conn,trim($_POST['execution_end_time']));
    $archive_destination = mysqli_escape_string($conn,trim($_POST['archive_destination']));  
    $retention_period = (int)(mysqli_escape_string($conn,trim($_POST['retention_period'])))*365;

    $activation_date = '2999-01-01 00:00:00';
    $expiration_date = '2999-01-01 00:00:00';

    //Get Summary Fields
    $sql_entity = "SELECT `query_fields`,`parent_id_fields`,`summary_fields`,`IO_name`,`table_name` FROM `entities` where entity_name = '$data_entity';";
    $results_entity = mysqli_query($conn, $sql_entity);
    $row_entity = mysqli_fetch_assoc($results_entity);  
    $query_fields = $row_entity['query_fields'];
    $parent_id_fields = $row_entity['parent_id_fields'];
    $summary_fields = $row_entity['summary_fields'];
    $IO_name = $row_entity['IO_name'];
    $table_name = $row_entity['table_name'];

    //Get Data Entity Fields
    $sql_system = "SELECT * FROM `system` where system_name = '$system';";
    $results_system = mysqli_query($conn, $sql_system);
    $row_system = mysqli_fetch_assoc($results_system);  
    
    $record_count = 0;
    
    if($user_access_add == "1"){
        if( $rule_name != ''  ){

            $REST_endpoint = $row_system['REST_endpoint'];


            // ========== SIEBEL OBJECTS ==========
            $business_object = rawurlencode($data_entity);
            $business_component = rawurlencode($data_entity);

            // ========== QUERY PARAMETERS ==========
            $search_spec_raw = $rule_criteria;
            $search_spec = urlencode($search_spec_raw);

            $query_params = "SearchSpec=" . $search_spec_raw . "&recordcountneeded=true";


            // ========== FINAL URL ==========
            $rest_url = "$REST_endpoint/{$business_object}/{$business_component}?$query_params";

            // ========== INIT CURL ==========
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $rest_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => true,           // Get headers
                CURLOPT_NOBODY => true,           // HEAD request
                CURLOPT_CUSTOMREQUEST => 'HEAD',
                CURLOPT_HTTPHEADER => [
                    'Authorization: Basic U0FETUlOOlNJRUJFTA==',
                    'Accept: application/json',
                    'User-Agent: PHP-cURL/1.0'
                ],
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 10,
            ]);

            $response = curl_exec($curl);

            // ========== HANDLE ERRORS ==========
            if ($response === false) {
                echo json_encode([
                    "status" => 0,
                    "error" => curl_error($curl),
                    "url" => $rest_url
                ]);
                curl_close($curl);
                exit;
            }

            // ========== PARSE HEADERS ==========
            $header_lines = explode("\r\n", $response);
            $header_array = [];

            foreach ($header_lines as $line) {
                if (strpos($line, ': ') !== false) {
                    list($key, $value) = explode(': ', $line, 2);
                    $header_array[trim($key)] = trim($value);
                }
            }

            curl_close($curl);

            // ========== BUILD OUTPUT ==========
            $record_count = isset($header_array['Total-Record-Count']) ? $header_array['Total-Record-Count'] : 0;

      
            
            $insertsql = "INSERT INTO `rules`(`rule_name`, `rule_desc`, `source_system`, `data_entity`, `IO_name`, `base_table`, `rule_criteria`, `rule_status`, `archive_source`, `archive_type`, `archive_attachment`, `activation_date`, `expiration_date`, `frequency`, `execution_start_time`, `execution_end_time`, `reterival_required`, `summary_required`, `summary_type`, `summary_fields`, `parent_id_fields`, `query_fields`,`retention_period`, `archive_destination`,`total_count`, `created_dt`, `created_by`, `updated_dt`, `updated_by`) VALUES ('$rule_name','$rule_desc','$system','$data_entity','$IO_name','$table_name','$rule_criteria','creating','','$archive_type','$archive_attachment','$activation_date','$expiration_date','$rrule','$execution_start_time','$execution_end_time','$reterival_required','$summary_required','$summary_type','$summary_fields','$parent_id_fields','$query_fields','$retention_period','$archive_destination','$record_count',now(),'$loggedin_user',now(),'$loggedin_user')";
            mysqli_query($conn,$insertsql);
            echo json_encode( array("status" => 1,"message" => "Rule Record Added Successfully. Total Qualifying record count :".$record_count) ); //
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

// Fetch entity details for modal
if($request == "loadmodal"){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    $record = mysqli_query($conn,"SELECT * FROM rules WHERE id=".$id);

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
    $record = mysqli_query($conn,"SELECT `id` FROM `rules` WHERE `id`=".$id);
    if(mysqli_num_rows($record) > 0){
        mysqli_query($conn,"UPDATE `rules` SET `rule_status`='inactive',`expiration_date`=now() WHERE `id`=".$id);
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
    $record = mysqli_query($conn,"SELECT `id`,`source_system`,`data_entity`,`base_table`,`rule_criteria` FROM `rules` WHERE `id`=".$id);
    if(mysqli_num_rows($record) > 0){
    	$row_rule = mysqli_fetch_assoc($record);
    	$source_system = $row_rule['source_system'];
    	$data_entity = $row_rule['data_entity'];
    	$base_table = $row_rule['base_table'];
		$rule_criteria = $row_rule['rule_criteria'];
    	
    	$result_entity = mysqli_query($conn,"SELECT * FROM `entities` WHERE `system`='$source_system' AND `entity_name`='$data_entity';" );
        $row_entity = mysqli_fetch_assoc($result_entity);
    	$query_field_map = $row_entity['query_field_map'];
    	
   		$map_string = $row_entity['query_field_map'];
    	$map_string_php = "return [" . $map_string . "];";
		$fieldMap = eval($map_string_php);
		if (!is_array($fieldMap)) {
    		die("Invalid query_field_map format in DB.");
		}

		$sql_criteria = preg_replace_callback('/\[(.*?)\]/', function ($m) use ($fieldMap) {
    		$key = trim($m[1]);
    		return isset($fieldMap[$key]) ? $fieldMap[$key] : $key;
		}, $rule_criteria);
    
    	$sql = "SELECT ROW_ID FROM SIEBEL." . $base_table . " WHERE " . $sql_criteria;
    	$sql_escaped = mysqli_real_escape_string($conn,$sql);
    
    	$update_rule = "UPDATE `rules` SET `rule_status`='active',`activation_date`=now(), `expiration_date`='2999-01-01 00:00:00',`rule_criteria_sql`='$sql_escaped' WHERE `id`=".$id;
        mysqli_query($conn,$update_rule);

$escaped_query = escapeshellarg($sql_escaped);
$escaped_rule_id = escapeshellarg($id);
$escaped_system = escapeshellarg($source_system);
$escaped_entity = escapeshellarg($data_entity);
  
// Use escapeshellarg for each argument
$cmd = "/usr/local/bin/oracle_wrapper.sh " .
       escapeshellarg($sql) . ' ' .
       escapeshellarg($id) . ' ' .
       escapeshellarg($source_system) . ' ' .
       escapeshellarg($data_entity);
//echo $cmd;    
    
$output = shell_exec($cmd);
    
//$command = "/usr/bin/python3/python3 /opt/cx_oracle_offline/scripts/oracle_to_mysql.py $escaped_query $escaped_rule_id $escaped_system $escaped_entity";
//$command = "/usr/bin/python3 /opt/cx_oracle_offline/scripts/query_sibel_write_mysql.py";
    
    //$output = shell_exec($command);
    //echo "<pre>$output</pre>";
    
        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}

// Fetch Record Count
if($request == "getRecordCount"){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    $record = mysqli_query($conn,"select `rules`.`rule_name`,`rules`.`data_entity`,`rules`.`rule_criteria`, `system`.`REST_endpoint` from `rules` INNER JOIN `system` ON `system`.system_name = `rules`.source_system WHERE `rules`.id=".$id);



    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);

        $rule_name = $row['rule_name'];
        $data_entity = $row['data_entity'];
        $rule_criteria = urlencode($row['rule_criteria']);
        $REST_endpoint = $row['REST_endpoint'];


        // ========== SIEBEL OBJECTS ==========
        $business_object = rawurlencode($data_entity);
        $business_component = rawurlencode($data_entity);

        // ========== QUERY PARAMETERS ==========
        $search_spec_raw = $rule_criteria;
        $search_spec = urlencode($search_spec_raw);

        $query_params = "SearchSpec=" . $search_spec_raw . "&recordcountneeded=true&childlinks=none";


        // ========== FINAL URL ==========
        $rest_url = "$REST_endpoint/{$business_object}/{$business_component}?$query_params";

        // ========== INIT CURL ==========
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $rest_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,           // Get headers
            CURLOPT_NOBODY => true,           // HEAD request
            CURLOPT_CUSTOMREQUEST => 'HEAD',
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic U0FETUlOOlNJRUJFTA==',
                'Accept: application/json',
                'User-Agent: PHP-cURL/1.0'
            ],
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = curl_exec($curl);

        // ========== HANDLE ERRORS ==========
        if ($response === false) {
            echo json_encode([
                "status" => 0,
                "error" => curl_error($curl),
                "url" => $rest_url
            ]);
            curl_close($curl);
            exit;
        }

        // ========== PARSE HEADERS ==========
        $header_lines = explode("\r\n", $response);
        $header_array = [];

        foreach ($header_lines as $line) {
            if (strpos($line, ': ') !== false) {
                list($key, $value) = explode(': ', $line, 2);
                $header_array[trim($key)] = trim($value);
            }
        }

        curl_close($curl);

        // ========== BUILD OUTPUT ==========
        $record_count = isset($header_array['Total-Record-Count']) ? $header_array['Total-Record-Count'] : 'Not found';

        echo json_encode([
            "status" => 1,
            "record_count" => $record_count,
            "url" => $rest_url,
            "headers" => $header_array
        ]);
        exit;
    
    }
}


?>
