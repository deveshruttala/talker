<?php
	session_start();
	require('system.ctrl.php');


	$messaging_recipient = $_POST["formMessagingRecipient"];
	$messaging_content = $_POST["formMessagingContent"];
	$messaging_content_pattern = "~^[^<>]{1,}$~";

	$messaging_content_validation = preg_match($messaging_content_pattern, $messaging_content);


	//query the database only if recipient is valid and content is regex compliant
	if ($messaging_recipient != "default" && $messaging_content_validation) {
        
        //insert the database row
        $db_data = array($_SESSION["uid"], $messaging_recipient, $messaging_content, 0);
        phpModifyDB('INSERT INTO messages (message_sender_id, message_recipient_id, message_content, message_read_by_recipient) values (?, ?, ?, ?)', $db_data);
        $db_data = "";

        //system feedback - your message has been sent
        $_SESSION["msgid"] = "311";

	}else{
		//input feedback - for Javascript turned off
		if ($messaging_recipient == "default") {
			//default recipient selected
            $_SESSION["msgid"] = "301";
		}else if (!$messaging_content_validation) {
			//message not regex compliant
            $_SESSION["msgid"] = "302";
            //return the messaging_recipient back to the form
            $_SESSION["messaging_recipient"] = $messaging_recipient;
		}
    }
    
    header('Location: gate.php?module=messaging');
?>
