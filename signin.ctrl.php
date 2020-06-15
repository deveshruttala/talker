<?php
	session_start();
	require('system.ctrl.php');

	$user_email = $_POST["formSignInEmail"];
	$user_email_pattern = "~^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$~";

	$user_password = $_POST["formSignInPassword"];
	$user_password_pattern = "~(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@*$#]).{8,16}~";

	$email_validation = preg_match($user_email_pattern, $user_email);
	$password_validation = preg_match($user_password_pattern, $user_password);


	if ($email_validation && $password_validation) { //query the database only if email and password are regex pattern compliant

		$db_data = array($user_email);
		//fetching the row by email, fetch returns the first (and only) result entry
		$dbUserRow = phpFetchDB('SELECT * FROM users WHERE user_email = ?', $db_data);
		$db_data = "";

		if (!is_array($dbUserRow)) { //even regex compliant attempt can result in nonexistent record
			//echo "regex ok -> user does not exist -> wrong email or password -> feedback message";
			$_SESSION["msgid"] = "808";
			header('Location: index.php');

		} else if (!password_verify($user_password, $dbUserRow["user_password"])) { //user OK, password WRONG

			//echo "user ok, password wrong -> wrong email or password -> feedback message";
			$_SESSION["msgid"] = "808";
			header('Location: index.php');

		} else if (password_verify($user_password, $dbUserRow["user_password"])) { //user OK, password OK, activated

			//echo "user ok, password ok, activation ok -> allow user in the system -> feedback message";
            $_SESSION["uid"] = $dbUserRow["user_id"];
            setcookie("cookieUserEmail", $user_email, time()+60);
            setcookie("cookieUserPassword", $dbUserRow["user_password"], time()+60);
			header('Location: gate.php?module=home');
		}


	} else { //not regex pattern compliant -> cannot be in the database, don't query the database, return feedback

		//echo "not regex compliant -> wrong email or password -> feedback message";
		$_SESSION["msgid"] = "808";
		header('Location: index.php');
	}

?>
