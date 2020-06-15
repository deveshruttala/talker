<?php
	session_start();
	require('system.ctrl.php');

	//check if session uid exists and not empty
	if (isset($_SESSION["uid"]) && $_SESSION["uid"]!="") {
		//empty session uid
        $_SESSION["uid"]="";
        setcookie("cookieUserEmail", '', time()-3600);
        setcookie("cookieUserPassword", '', time()-3600);
		header('Location: index.php');
	}else{
		header('Location: index.php');
	}
?>
