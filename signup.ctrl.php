<?php
    
    session_start();
    require('system.ctrl.php');
    
    //echo $_POST["formSignUpEmail"];
    //echo $_POST["formSignUpPassword"];
    //echo $_POST["formSignUpPasswordConf"];

    $user_email = $_POST["formSignUpEmail"];
    $user_email_pattern = "~^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$~";
    $user_password = $_POST["formSignUpPassword"];
    $user_password_pattern = "~(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@*$#]).{8,16}~";
    $email_validation = preg_match($user_email_pattern, $user_email);
    $password_validation = preg_match($user_password_pattern, $user_password);

    if ($email_validation && $password_validation && $user_password == $_POST["formSignUpPasswordConf"]) {
        //hash the password before storing it to the database
        $hashed_user_password = password_hash($user_password, PASSWORD_DEFAULT);
        
        
        //checking if the submitted email is already in users table
        $db_data = array($user_email);
        $isAlreadySignedUp = phpFetchDB('SELECT user_email FROM users WHERE user_email = ?', $db_data);
        $db_data = "";

        //if no result is returned, insert new record to the table, otherwise display feedback
        if (!is_array($isAlreadySignedUp)) {
            $db_data = array($user_email, $hashed_user_password, 0, "", "", "");
            phpModifyDB('INSERT INTO users (user_email, user_password, user_verified, user_firstname, user_lastname, user_nickname) values (?, ?, ?, ?, ?, ?)', $db_data);
            $db_data = "";
            phpSendVerificationEmail($user_email, $hashed_user_password);
        }else{
            $_SESSION["msgid"] = "804";
        }
        header('Location: index.php');
    } else if (!$email_validation) {
        $_SESSION["msgid"] = "801";
        $_SESSION["formSignUpEmail"] = $user_email;
        header('Location: index.php');
    } else if (!$password_validation) {
        $_SESSION["msgid"] = "802";
        $_SESSION["formSignUpEmail"] = $user_email;
        header('Location: index.php');
    } else if ($user_password != $_POST["formSignUpPasswordConf"]){
        $_SESSION["msgid"] = "803";
        $_SESSION["formSignUpEmail"] = $user_email;
        header('Location: index.php');
    }
?>