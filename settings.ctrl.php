<?php
    session_start();
    require('system.ctrl.php');

    //BASICS FORM
    if(isset($_POST["formSettingsBasicsSubmit"])){
      $user_firstname = $_POST["formSettingsBasicsFirstName"];
      $user_lastname = $_POST["formSettingsBasicsLastName"];
      $user_nickname = $_POST["formSettingsBasicsNickName"];
      $user_age = $_POST["formSettingsBasicsAge"];
      $user_names_pattern = "~^[a-zA-Z]{3,15}$~";
      $user_age_pattern = "~^[2-9]{1}[0-9]{1}$~";

      $firstname_validation = preg_match($user_names_pattern, $user_firstname);
	  $lastname_validation = preg_match($user_names_pattern, $user_lastname);
	  $nickname_validation = preg_match($user_names_pattern, $user_nickname);
      $age_validation = preg_match($user_age_pattern, $user_age);

      //query the database only if at least one name matches the regex pattern
	  if ($firstname_validation || $lastname_validation || $nickname_validation || $age_validation) {
        //get the current values from the database and store them so we can potentially save them back if some value is actually empty
        $db_data = array($_SESSION["uid"]);
        $dbUserRow = phpFetchDB('SELECT * FROM users WHERE user_id = ?', $db_data);
        $db_data = "";

        //check each of the four inputs validation, if not valid, assign the db value instead
        if (!$firstname_validation) {
          $user_firstname = $dbUserRow["user_firstname"];
        }
        if (!$lastname_validation) {
          $user_lastname = $dbUserRow["user_lastname"];
        }
        if (!$nickname_validation) {
          $user_nickname = $dbUserRow["user_nickname"];
        }
        if (!$age_validation) {
            $user_age = $dbUserRow["user_age"];
        }


        //update the database row
        $db_data = array($user_firstname, $user_lastname, $user_nickname, $user_age, $_SESSION["uid"]);
        phpModifyDB('UPDATE users SET user_firstname = ?, user_lastname = ?, user_nickname = ?, user_age = ? WHERE user_id = ?', $db_data);
        $db_data = "";

        //system feedback - your settings has been updated
        $_SESSION["msgid"] = "211";

      }else{
        //input feedback - for Javascript turned off
        if (!$firstname_validation && $user_firstname!="") {
          $_SESSION["msgid"] = "201";
        }else if (!$lastname_validation && $user_lastname!="") {
          $_SESSION["msgid"] = "202";
        }else if (!$nickname_validation && $user_nickname!="") {
          $_SESSION["msgid"] = "203";
        }else if (!$age_validation && $user_age!=0) {
          $_SESSION["msgid"] = "208";  
        }
      }
    }

    if(isset($_POST["formSettingsBasicsClear"])) {
        //update the database row by setting empty strings
        $db_data = array("", "", "", 0, $_SESSION["uid"]);
        phpModifyDB('UPDATE users SET user_firstname = ?, user_lastname = ?, user_nickname = ?, user_age = ? WHERE user_id = ?', $db_data);
        $db_data = "";
    
        //system feedback - your settings has been updated
        $_SESSION["msgid"] = "212";
    }
    

    //PASSWORD FORM
    if(isset($_POST["formSettingsPasswordSubmit"])){
        
        $password_current = $_POST["formSettingsPasswordCurrent"];
        $password_new = $_POST["formSettingsPasswordNew"];
        $password_conf = $_POST["formSettingsPasswordConf"];
        $password_pattern = "~(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@*$#]).{8,16}~";

        $current_validation = preg_match($password_pattern, $password_current);
        $new_validation = preg_match($password_pattern, $password_new);
        $conf_validation = preg_match($password_pattern, $password_conf);

        //*** FIRST CASE ***
        //CURRENT MATCHES REGEX: NO
        if (!$current_validation) {
            //echo "FIRST CASE: current matches regex: no";
            $_SESSION["msgid"] = "204";



        //*** SECOND CASE ***
        //CURRENT MATCHES REGEX: YES
        //NEW MATCHES REGEX: NO
        } else if(!$new_validation) {
            //echo "SECOND CASE: current matches regex: yes | new matches regex: no";
            $_SESSION["msgid"] = "206";



        //*** THIRD CASE ***
        //CURRENT MATCHES REGEX: YES
        //NEW MATCHES REGEX: YES
        //CURRENT DIFFERS NEW: NO
        } else if($password_current == $password_new) {
            //echo "THIRD CASE: current matches regex: yes | new matches regex: yes | current differs new: no";
            $_SESSION["msgid"] = "207";


        //*** FOURTH CASE ***
        //CURRENT MATCHES REGEX: YES
        //NEW MATCHES REGEX: YES
        //CURRENT DIFFERS NEW: YES
        //NEW MATCHES CONF: NO
        } else if($password_new != $password_conf) {
            //echo "FOURTH CASE: current matches regex: yes | new matches regex: yes | current differs new: yes | new matches conf: no";
            $_SESSION["msgid"] = "803";


        //*** FIFTH CASE ***
        //CURRENT MATCHES REGEX: YES
        //NEW MATCHES REGEX: YES
        //CURRENT DIFFERS NEW: YES
        //NEW MATCHES CONF: YES
        } else {
            //echo "FIFTH CASE: current matches regex: yes | new matches regex: yes | current differs new: yes | new matches conf: yes";
            $db_data = array($_SESSION["uid"]);
            //fetching the row by uid, fetch returns the first (and only) result entry
            $dbUserRow = phpFetchDB('SELECT * FROM users WHERE user_id = ?', $db_data);
            $db_data = "";


            // if current password matches the password in the database, store the new password
            if (password_verify($password_current, $dbUserRow["user_password"])) {

                //hash the new password before storing it to the database
                $hashed_password_new = password_hash($password_new, PASSWORD_DEFAULT);

                //update the database row
                $db_data = array($hashed_password_new, $_SESSION["uid"]);
                phpModifyDB('UPDATE users SET user_password = ? WHERE user_id = ?', $db_data);
                $db_data = "";

                // show system-wide feedback that the password has been successfully changed
                $_SESSION["msgid"] = "213";

            } else {

                $_SESSION["msgid"] = "205";

            }


        }

    }

    header('Location: gate.php?module=settings');
?>
