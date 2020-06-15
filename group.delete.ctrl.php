<?php
	session_start();
	require('system.ctrl.php');

	if ($_POST["formGroupsDeleteButton"] == delete) {

		//delete all posts assigned to the group, delete the group
		$db_data = array($_POST["formGroupsGroupID"]);
		phpModifyDB('DELETE FROM posts WHERE post_group_id = ?', $db_data);
		phpModifyDB('DELETE FROM groups WHERE group_id = ?', $db_data);
		$db_data = "";

		//system feedback - group has been deleted
		$_SESSION["msgid"] = "413";

	}

	//go to the list of groups
	header('Location: gate.php?module=groups');
?>
