<?php
session_start();
require('system.ctrl.php');

//if session uid not set or empty, check if cookieUserEmail and cookieUserPassword exist and not empty
if (!isset($_SESSION["uid"]) || $_SESSION["uid"]=="") {
	//if cookieUserEmail and cookieUserPassword exist and not empty,
	//compare values with database and store session uid or redirect
	if (isset($_COOKIE["cookieUserEmail"]) && $_COOKIE["cookieUserEmail"]!="" && isset($_COOKIE["cookieUserPassword"]) && $_COOKIE["cookieUserPassword"]!="") {
		$db_data = array($_COOKIE["cookieUserEmail"]);
		//fetching the row by email, fetch returns the first (and only) result entry
		$dbUserRow = phpFetchDB('SELECT * FROM users WHERE user_email = ?', $db_data);
		$db_data = "";
		if (is_array($dbUserRow) && $_COOKIE["cookieUserPassword"] == $dbUserRow["user_password"]) {
			$_SESSION["uid"] = $dbUserRow["user_id"];
		}else{
			header('Location: index.php');
		}
	}else{
		header('Location: index.php');
	}
}

//fetching the row by uid, fetch returns the first (and only) result entry
$db_data = array($_SESSION["uid"]);
$dbUserRow = phpFetchDB('SELECT * FROM users WHERE user_id = ?', $db_data);
$db_data = "";

if ($dbUserRow["user_verified"] != 1) {
	phpSendVerificationEmail($dbUserRow["user_email"], $dbUserRow["user_password"]);
	$_SESSION["resend"] = 1;
}

header('Location: gate.php');

?>
