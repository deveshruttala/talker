<?php
	session_start();
	require('system.ctrl.php');

	$posts_content = $_POST["formPostsContent"];
	$posts_group_id = $_POST["formPostsGroupID"];
	$posts_content_pattern = "~^[^<>]{1,}$~";

	$posts_content_validation = preg_match($posts_content_pattern, $posts_content);


	//query the database only if post content is regex compliant
	if ($posts_content_validation) {

		//insert the database row
		$db_data = array($posts_group_id, $_SESSION["uid"], nl2br($posts_content));
		phpModifyDB('INSERT INTO posts (post_group_id, post_author_id, post_content) values (?, ?, ?)', $db_data);
		$db_data = "";

		//system feedback - your message has been sent
		$_SESSION["msgid"] = "511";

	}else{
		//input feedback - for Javascript turned off
		if (!$posts_content_validation) {
			//message not regex compliant
			$_SESSION["msgid"] = "501";
			//return the messaging_recipient back to the form
			$_SESSION["posts_content"] = $posts_content;
		}
	}


	header('Location: gate.php?module=posts&gid=' . $posts_group_id);

?>
