<?php

session_start();
require('system.ctrl.php');

$verify_link_email = $_GET["email"];
$verify_link_hash = $_GET["hash"];


//checking if the email from the link is actually in the database
$db_data = array($verify_link_email);
$isAlreadySignedUp = phpFetchDB('SELECT * FROM users WHERE user_email = ?', $db_data);
$db_data = "";


if (!is_array($isAlreadySignedUp)) {

	//email not registered -> feedback message
    $_SESSION["msgid"] = "807";
    header('Location: index.php');

} else if ($isAlreadySignedUp["user_verified"] == 1 ) {

    //email registered, but already activated -> feedback message
    $_SESSION["msgid"] = "806";
    header('Location: index.php');

} else if ($isAlreadySignedUp["user_verified"] == 0 && $isAlreadySignedUp["user_password"] == $verify_link_hash) {

    //email registered, but not activated -> set verified to 1 -> feedback message
    $db_data = array(1, $isAlreadySignedUp["user_email"]);
    phpModifyDB('UPDATE users SET user_verified = ? WHERE user_email = ?', $db_data);
    $db_data = "";
    $_SESSION["msgid"] = "811";
    header('Location: index.php');

} else {

    //hash doesn't match the password
    $_SESSION["msgid"] = "807";
    header('Location: index.php');
}

?>
