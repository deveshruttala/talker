<?php
$db_data = array($_SESSION["uid"]);
$dbUserRow = phpFetchDB('SELECT COUNT(*) FROM messages WHERE message_recipient_id = ? AND message_read_by_recipient = 0', $db_data);
$db_data = "";
?>

<h5>Welcome!</h5>
<hr>
<p>You have <strong><?php echo $dbUserRow["COUNT(*)"]; ?></strong> unread messages.</p>