<?php
	session_start();
	require('system.ctrl.php');

	if ($_POST["formGroupsUnbookmarkButton"] == unbookmark) {

		//detele the record from the bookmarks table for the signed-in user
		$db_data = array($_SESSION["uid"], $_POST["formGroupsGroupID"]);
		phpModifyDB('DELETE FROM bookmarks WHERE user_id =? AND group_id = ?', $db_data);
		$db_data = "";

		//system feedback - group has been deleted
		$_SESSION["msgid"] = "611";

	}

	//go to the list of groups
	header('Location: gate.php?module=bookmarks');
?>
