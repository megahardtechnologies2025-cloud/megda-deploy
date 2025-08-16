<?php
	session_start();
	include_once 'dbh.php';
    include_once 'core.php';
    include_once 'libs/php-jwt-master/src/BeforeValidException.php';
    include_once 'libs/php-jwt-master/src/ExpiredException.php';
    include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
    include_once 'libs/php-jwt-master/src/JWT.php';
    use \Firebase\JWT\JWT;	

    $data = json_decode(file_get_contents("php://input"));
    
    $userid = $data->lguserid;
	$password=$data->lgpassword; 
	
    $sql="SELECT * FROM `user` WHERE `username`='$userid' AND `status`='active';";

	$result=mysqli_query($conn,$sql);
	$resultCheck=mysqli_num_rows($result);
	
	if($resultCheck < 1){
		echo json_encode(array("message" => "Wrong Userid or Userid Inactive"));
	}else{
		if($row=mysqli_fetch_assoc($result)){
    		if(password_verify($password, $row['password'])){

                $user_role = $row['role'];
                $sql_usrRole="SELECT * FROM `user_role` WHERE `role_name`='$user_role' and `status`= 'active';";
                $result_usrRole=mysqli_query($conn,$sql_usrRole);
                $resultCheck_usrRole=mysqli_num_rows($result_usrRole);
                
                if($resultCheck_usrRole < 1){
		            echo json_encode(array("message" => "No Active role associated with the user"));
	            }
	            else{

      				$_SESSION['valid'] = "VALIDATED";
      				$_SESSION['usrRole'] = $row['role'];
      				$_SESSION['UserId'] = $row['username'];
      				$_SESSION['firstname'] = $row['firstname'];
      				$_SESSION['lastname'] = $row['lastname'];
      				$_SESSION['email'] = $row['email'];
      				
      				setcookie("username",$row['username'],time()+86400,'/');
    				setcookie("usrRole",$row['role'],time()+86400,'/');
    				setcookie("firstname",$row['firstname'],time()+86400,'/');
    				setcookie("lastname",$row['lastname'],time()+86400,'/');
    				setcookie("avatar",$row['avatar'],time()+86400,'/');
    				setcookie("phone",$row['phone'],time()+86400,'/');
    				setcookie("email",$row['email'],time()+86400,'/');
    				setcookie("status",$row['status'],time()+86400,'/');

                    $row_usrRole=mysqli_fetch_assoc($result_usrRole);
	                $_SESSION['dashboard_access'] = $row_usrRole['dashboard'];
	                $_SESSION['user_access'] = $row_usrRole['user'];
	                $_SESSION['products_access'] = $row_usrRole['products'];
	                $_SESSION['categories_access'] = $row_usrRole['categories'];
	                $_SESSION['settings_access'] = $row_usrRole['settings'];
	                $_SESSION['orders_access'] = $row_usrRole['orders'];
	                $_SESSION['customers_access'] = $row_usrRole['customers'];
	                $_SESSION['delivery_access'] = $row_usrRole['delivery'];
	                $_SESSION['inventory_access'] = $row_usrRole['inventory'];
	                $_SESSION['reports_access'] = $row_usrRole['reports'];

					session_write_close();
					
                    $token = array(
                       "iss" => $iss,
                       "aud" => $aud,
                       "iat" => $iat,
                       "nbf" => $nbf,
                       "data" => array(
                           "id" => $row['username'],
                           "name" => $row['firstname'],
                           "type" => $row['role'],
                           "phone" =>$row['phone']
                       )
                    );
    
                    // generate jwt
                    $jwt = JWT::encode($token, $key);
                    echo json_encode(
                        array(
                            "loginstatus" => "success",
                            "message" => "Login Successful.",
                            "jwt" => $jwt
                        )
                    );
                    exit();
	            }     

			}
	    	else{
	    	    echo json_encode(array("message" => "Wrong Password."));
	    	}
		}
	}
?>
