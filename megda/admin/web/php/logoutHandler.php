<?php
    session_start();
    $_SESSION['valid'] = "INVALID";
    session_unset(); 
    session_destroy(); 

    setcookie("username","",time()-3600,'/');
	setcookie("empRole","",time()-3600,'/');
	setcookie("firstname","",time()-3600,'/');
	setcookie("lastname","",time()-3600,'/');
	setcookie("avatar","",time()-3600,'/');
	setcookie("phone","",time()-3600,'/');
	setcookie("email","",time()-3600,'/');
	setcookie("status","",time()-3600,'/');
	
	echo ("<script>location.href='../index.php'</script>");
?>