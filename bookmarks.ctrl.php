<?php
	session_start();
	require('system.ctrl.php');

	$group_id = $_POST["formPostsGroupID"];

    //insert the database row
    $db_data = array($_SESSION["uid"], $group_id);
	phpModifyDB('INSERT INTO bookmarks (user_id, group_id) values (?, ?)', $db_data);
	$db_data = "";

	//system feedback - your message has been sent
	$_SESSION["msgid"] = "611";

	header('Location: gate.php?module=bookmarks');

?>