<?php
	session_start();
	require('system.ctrl.php');

	$group_name = $_POST["formGroupName"];
	$group_name_pattern = "~^[^<>]{1,}$~";

	$group_name_validation = preg_match($group_name_pattern, $group_name);

	//query the database only if the group name regex compliant
	if ($group_name_validation) {

        if ($_POST["formPostsGroupID"] != "") {

            //update the database row
            $db_data = array($group_name, $_POST["formPostsGroupID"]);
            phpModifyDB('UPDATE groups SET group_name = ? WHERE group_id = ?', $db_data);
            $db_data = "";
    
            //system feedback - group name has been changed
            $_SESSION["msgid"] = "412";
            //go to the list of posts
            header('Location: gate.php?module=posts&gid=' . $_POST["formPostsGroupID"]);
    
        } else {

            //insert the database row
            $db_data = array($_SESSION["uid"], $group_name);
            phpModifyDB('INSERT INTO groups (group_owner_id, group_name) values (?, ?)', $db_data);
            $db_data = "";

            //system feedback - your group has been created
            $_SESSION["msgid"] = "411";
            //go to the list of groups
            header('Location: gate.php?module=groups');

        }

	}else{
		//group name not regex compliant
        $_SESSION["msgid"] = "401";
        //return the group_name back to the form
        $_SESSION["group_name"] = $group_name;

        if ($_POST["formPostsGroupID"] != "") {
            //go to the group - editing mode
            header('Location: gate.php?module=group&gid=' . $_POST["formPostsGroupID"]);
        } else {
            //go to the group - creating mode
            header('Location: gate.php?module=group');
        }
	}

?>
