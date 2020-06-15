<?php
require ("db-conn.inc.php");
require ("PHPMailer/PHPMailer.php");
require ("PHPMailer/Exception.php");
require ("PHPMailer/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Place directly inside Bootstrap container to keep the right structure of Bootstrap document
function phpShowSystemFeedback($feedback_id) {
	switch ($feedback_id) {
        case "211":
		$feedback_type="success";
		$feedback_text="Data updated successfully!";
        break;

        case "212":
		$feedback_type="success";
		$feedback_text="Data removed successfully!";
        break;

        case "213":
		$feedback_type="success";
		$feedback_text="Password changed successfully!";
        break;

        case "311":
		$feedback_type="success";
		$feedback_text="Message sent successfully!";
        break;

        case "411":
		$feedback_type="success";
		$feedback_text="Group has been created successfully!";
        break;

        case "412":
		$feedback_type="success";
		$feedback_text="Group name has been changed successfully!";
        break;

        case "413":
		$feedback_type="success";
		$feedback_text="Group has been deleted!";
        break;

        case "511":
		$feedback_type="success";
		$feedback_text="Post has been successfully sent!";
        break;

        case "512":
		$feedback_type="success";
		$feedback_text="Post has been successfully updated!";
        break;

        case "513":
		$feedback_type="success";
		$feedback_text="Post has been deleted!";
        break;

        case "611":
		$feedback_type="success";
		$feedback_text="Bookmarks updated!";
        break;
        
        case "804":
		$feedback_type="danger";
		$feedback_text="This email is already used!";
        break;
        
        case "806":
		$feedback_type="danger";
		$feedback_text="Your account has been already activated!";
        break;
        
        case "807":
		$feedback_type="danger";
		$feedback_text="Verification link is corrupted!";
        break;
        
        case "808":
		$feedback_type="danger";
		$feedback_text="Wrong email or password!";
        break;
        
        case "809":
		$feedback_type="danger";
		$feedback_text="Your account hasn't been activated yet. Please, check your inbox first. <a href='resend.ctrl.php'>Resend verification email</a>";
		break;

		case "811":
		$feedback_type="success";
		$feedback_text="Your account has been activated, you can sign in!";
		break;

        case "812":
		$feedback_type="warning";
		$feedback_text="Check your inbox and verify your email address!";
		break;

    }

	return [$feedback_type, $feedback_text];
}

function phpShowInputFeedback($feedback_id) {
	switch ($feedback_id) {
        case "201":
		$feedback_type="is-invalid";
		$feedback_text="First name must be between 3 and 15 characters long and can contain only letters.";
        break;
        
        case "202":
		$feedback_type="is-invalid";
		$feedback_text="Last name must be between 3 and 15 characters long and can contain only letters.";
        break;
        
        case "203":
		$feedback_type="is-invalid";
		$feedback_text="Nickname must be between 3 and 15 characters long and can contain only letters.";
        break;

        case "204":
        $feedback_type="is-invalid";
        $feedback_text="Password must be between 8 and 16 characters long, with at least one uppercase and lowercase character, one number and one special character (@, *, $ or #).";
        break;

        case "205":
        $feedback_type="is-invalid";
        $feedback_text="Current password is invalid.";
        break;

        case "206":
        $feedback_type="is-invalid";
        $feedback_text="Password must be between 8 and 16 characters long, with at least one uppercase and lowercase character, one number and one special character (@, *, $ or #).";
        break;

        case "207":
        $feedback_type="is-invalid";
        $feedback_text="New password must be different from the current password.";
        break;

        case "208":
		$feedback_type="is-invalid";
		$feedback_text="Age must be between 20 and 99.";
        break;

        case "301":
        $feedback_type="is-invalid";
        $feedback_text="Choose the email address of the recipient.";
        break;

        case "302":
        $feedback_type="is-invalid";
        $feedback_text="Message can not be empty and can not contain '<' and '>' characters.";
        break;

        case "401":
        $feedback_type="is-invalid";
        $feedback_text="Group name can not be empty and can not contain '<' and '>' characters.";
        break;

        case "501":
        $feedback_type="is-invalid";
        $feedback_text="Post can not be empty and can not contain '<' and '>' characters.";
        break;

        case "801":
		$feedback_type="is-invalid";
		$feedback_text="This is not a valid email address";
		break;

		case "802":
		$feedback_type="is-invalid";
		$feedback_text="Password must be between 8 and 16 characters long, with at least one uppercase and lowercase character, one number and one special character (@, *, $ or #).";
		break;

		case "803":
		$feedback_type="is-invalid";
		$feedback_text="Passwords don't match";
		break;

		case "805":
		$feedback_type="is-invalid";
		$feedback_text="This email is not registered!";
		break;

		default:
		$feedback_type="";
		$feedback_text="Unspecified error or warning";
		break;
    }

	return [$feedback_type, $feedback_text];
}

// Create, update or delete a record in the database
function phpModifyDB($db_query, $db_data) {
    global $connection;

    $statement = $connection->prepare($db_query);
    $statement->execute($db_data);
}

// Get the information from the database
function phpFetchDB($db_query, $db_data) {
    global $connection;

    $statement = $connection->prepare($db_query);
    $statement->execute($db_data);

    //setting the fetch mode and returning the result
    return $statement->fetch(PDO::FETCH_ASSOC);
}

// Get the information from the database
function phpFetchAllDB($db_query, $db_data) {
    global $connection;

    $statement = $connection->prepare($db_query);
    $statement->execute($db_data);

    //setting the fetch mode and returning the result
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Return user's email based on his id
function phpGetUserEmail($user_id) {
	$db_data = array($user_id);
	$db_result = phpFetchDB('SELECT user_email FROM users WHERE user_id = ?', $db_data);
	return $db_result['user_email'];
}

// Return group's name based on its id
function phpGetGroupName($group_id) {
	$db_data = array($group_id);
	$db_result = phpFetchDB('SELECT group_name FROM groups WHERE group_id = ?', $db_data);
	return $db_result['group_name'];
}

// Return group's owner id based on group's id
function phpGetGroupOwnerID($group_id) {
	$db_data = array($group_id);
	$db_result = phpFetchDB('SELECT group_owner_id FROM groups WHERE group_id = ?', $db_data);
	return $db_result['group_owner_id'];
}



function phpSendEmail($to, $subject, $content) {

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "deveshruttala@gmail.com";
    $mail->Password = SMTP_PSWD;
    $mail->setFrom('deveshruttala@gmail.com','devesh ruttala');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $content;
    
    if (!$mail->send()) {
        echo "Mailer Error:" . $mail->ErrorInfo;
        } else{
           $_SESSION["msgid"] = "812";
        }
    }

function phpShowEmailInputValue($user_email) {
    if ($user_email != "") {
        $content="value='" . $user_email . "'";
    }else{
        $content="";
    }

    return $content;
}

function phpSendVerificationEmail($user_email, $hashed_user_password) {
	$verify_message = '

	Welcome to Talker! Thanks for signing up!<br><br>
	Your account has been created but before you can login you need to activate it with the link below.<br><br>

	Please click this link to activate your account:
	<a href="http://'.$_SERVER["HTTP_HOST"].'/verify.php?email='.$user_email.'&hash='.$hashed_user_password.'">Verify your email</a>

	';

	phpSendEmail($user_email, 'Verify your account', $verify_message);
}


?>
