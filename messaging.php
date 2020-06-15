<?php



    $db_data = array();
    $dbRecipientsList = phpFetchAllDB('SELECT * FROM users', $db_data);
    $db_data = "";

?>
    <h5>Messaging</h5>
    <hr>

    <div class="row">
        <div class="col-lg-12">
            <form name="formMessaging" action="messaging.ctrl.php" method="post" novalidate>
                <div class="form-group">
                    <label for="formMessagingRecipient">Recipient</label>
                    <select class="form-control <?php if ($_SESSION['msgid']!='301' && $_SESSION['msgid']!='') { echo 'is-valid'; }else{ echo (phpShowInputFeedback($_SESSION['msgid'])[0]); } ?>" id="formMessagingRecipient" name="formMessagingRecipient" onchange="jsMessagingValidateSelect('formMessagingRecipient')">
                        <option value="default" default>Select email</option>
                        <?php foreach ($dbRecipientsList as $dbRecipientRow) { ?>
                            <option value="<?php echo $dbRecipientRow["user_id"]; ?>"<?php if  ($_SESSION['messaging_recipient'] != '' && $_SESSION['messaging_recipient'] == $dbRecipientRow["user_id"]) { echo 'selected'; } ?>
                            ><?php echo $dbRecipientRow["user_email"]; ?></option>
                        <? } ?>

                    </select>

                    <?php if ($_SESSION["msgid"]=="301") { ?>
                        <div class="invalid-feedback">
                            <?php echo (phpShowInputFeedback($_SESSION["msgid"])[1]); ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label for="formMessagingContent">Message</label>
                    <textarea class="form-control <?php if ($_SESSION['msgid']!='302' && $_SESSION['msgid']!='') { echo 'is-valid'; }else{ echo (phpShowInputFeedback($_SESSION['msgid'])[0]); } ?>" id="formMessagingContent" name="formMessagingContent" placeholder="Write the message here. Tags are not allowed." onkeyup="jsMessagingValidateTextArea('formMessagingContent')"></textarea>

                    <?php if ($_SESSION["msgid"]=="302") { ?>
                        <div class="invalid-feedback">
                            <?php echo (phpShowInputFeedback($_SESSION["msgid"])[1]); ?>
                        </div>
                    <?php } ?>
                </div>

                <button type="submit" id="formMessagingSubmit" name="formMessagingSubmit" class="btn btn-primary btn-success mb-5">Send</button>
            </form>
        </div>
    </div>

    <?php
	$db_data = array($_SESSION["uid"], $_SESSION["uid"]);
	$dbMessagesList = phpFetchAllDB('SELECT * FROM messages WHERE message_sender_id = ? OR message_recipient_id = ? ORDER BY message_date DESC', $db_data);
	$db_data = "";
    ?>

    <p><strong>Latest messages</strong></p>

    <div class="row">
        <div class="col-lg-12">
            <table class="table">

            <?php foreach ($dbMessagesList as $dbMessageRow) { ?>
            <tr>
                <td class="message_header">
                    <?php if ($dbMessageRow["message_sender_id"] == $_SESSION["uid"]) { ?>
                        TO: <?php echo phpGetUserEmail($dbMessageRow["message_recipient_id"]); ?>
                    <?php }else{ ?>
                        FROM: <?php echo phpGetUserEmail($dbMessageRow["message_sender_id"]); ?>
                    <?php } ?>
                        | DATE: <?php echo $dbMessageRow["message_date"]; ?>

                    <?php if ($dbMessageRow["message_sender_id"] == $_SESSION["uid"] && $dbMessageRow["message_read_by_recipient"] == 1) { ?>
                        | READ BY RECIPIENT
                    <?php } ?>

                </td>
            </tr>

            <tr><td class="message_content"><?php echo $dbMessageRow["message_content"]; ?></td></tr>
            <?php } ?>

            </table>
        </div>
    </div>


    <script src="messaging.js"></script>

    <?php

//UPDATE MESSAGES READ BY RECIPIENT
$db_data = array($_SESSION["uid"]);
phpModifyDB('UPDATE messages SET message_read_by_recipient = 1 WHERE message_recipient_id = ?', $db_data);
$db_date = "";


$_SESSION["messaging_recipient"] = "";


?>

<?php
    }
?>