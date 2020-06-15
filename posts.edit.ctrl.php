<?php
	session_start();
	require('system.ctrl.php');

	$posts_id = $_POST["formPostsPostID"];
	$posts_content = $_POST["formPostsContentEdited" . $posts_id];
	$posts_group_id = $_POST["formPostsGroupID"];
    $posts_content_pattern = "~^[^<>]{1,}$~";
    
    if ($_POST["formPostsDeleteButton"] == delete) {
        //delete the database row
        $db_data = array($posts_id);
        phpModifyDB('DELETE FROM posts WHERE post_id = ?', $db_data);
        $db_data = "";

        //system feedback - your message has been deleted
        $_SESSION["msgid"] = "513";

    } else {
        $posts_content_validation = preg_match($posts_content_pattern, $posts_content);


        //query the database only if post content is regex compliant
        if ($posts_content_validation) {

            //update the database row
            $db_data = array(nl2br($posts_content), $posts_id);
            phpModifyDB('UPDATE posts SET post_content = ? WHERE post_id = ?', $db_data);
        $db_data = "";

            //system feedback - your message has been updated
            $_SESSION["msgid"] = "512";

        }
    }
    

	


	header('Location: gate.php?module=posts&gid=' . $posts_group_id);

?>
