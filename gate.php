<?php
 session_start(); require('system.ctrl.php');
 
 //if session uid not set or empty, check if cookieUserEmail and cookieUserPassword exist and not empty
    if (!isset($_SESSION["uid"]) || $_SESSION["uid"]=="") {
        //if cookieUserEmail and cookieUserPassword exist and not empty,
        //compare values with database and store session uid or redirect
        if (isset($_COOKIE["cookieUserEmail"]) && $_COOKIE["cookieUserEmail"]!="" && isset($_COOKIE["cookieUserPassword"]) && $_COOKIE["cookieUserPassword"]!="") {
            $db_data = array($_COOKIE["cookieUserEmail"]);
            //fetching the row by email, fetch returns the first (and only) result entry
            $dbUserRow = phpFetchDB('SELECT * FROM users WHERE user_email = ?', $db_data);
            $db_data = "";
            if (is_array($dbUserRow) && $_COOKIE["cookieUserPassword"] == $dbUserRow["user_password"]) {
                $_SESSION["uid"] = $dbUserRow["user_id"];
            }else{
                header('Location: index.php');
            }
        }else{
            header('Location: index.php');
        }
	}
	
	//fetching the row by uid, fetch returns the first (and only) result entry
	$db_data = array($_SESSION["uid"]);
	$dbUserRow = phpFetchDB('SELECT * FROM users WHERE user_id = ?', $db_data);
	$db_data = "";

	if ($dbUserRow["user_verified"] != 1 && $_SESSION["resend"] != 1) {
		$_SESSION["msgid"] = "809";
	}

 ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>TALKER</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

		<!-- Talker CSS -->
		<link rel="stylesheet" href="talker.css">
	</head>
	<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="#">TALKER</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item <?php if ($_GET['module']=='home') { echo 'active'; } ?>">
					<a class="nav-link" href="gate.php?module=home">Home<?php if ($_GET['module']=='home') { ?><span class="sr-only"> (current)</span><?php } ?></a>
				</li>
				<li class="nav-item <?php if ($_GET['module']=='messaging') { echo 'active'; } ?>">
					<a class="nav-link" href="gate.php?module=messaging">Messaging<?php if ($_GET['module']=='messaging') { ?><span class="sr-only"> (current)</span><?php } ?></a>
				</li>
				<li class="nav-item <?php if ($_GET['module']=='groups') { echo 'active'; } ?>">
					<a class="nav-link" href="gate.php?module=groups">Groups<?php if ($_GET['module']=='groups') { ?><span class="sr-only"> (current)</span><?php } ?></a>
				</li>
				<li class="nav-item <?php if ($_GET['module']=='bookmarks') { echo 'active'; } ?>">
					<a class="nav-link" href="gate.php?module=bookmarks">Bookmarks<?php if ($_GET['module']=='bookmarks') { ?><span class="sr-only"> (current)</span><?php } ?></a>
				</li>
				<li class="nav-item <?php if ($_GET['module']=='settings') { echo 'active'; } ?>">
					<a class="nav-link" href="gate.php?module=settings">Settings<?php if ($_GET['module']=='settings') { ?><span class="sr-only"> (current)</span><?php } ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="logout.ctrl.php">Logout</a>
				</li>
			</ul>
			<a class="nav-link-user" href="#"><?php echo $dbUserRow["user_email"]; ?></a>
		</div>
	</nav>

	<div class="container">

		<!-- SYSTEM-WIDE FEEDBACK -->
		<?php if (isset($_SESSION["msgid"]) && $_SESSION["msgid"]!="" && phpShowSystemFeedback($_SESSION["msgid"])[0]!="") { ?>
		<div class="row">
			<div class="col-12">
				<div class="alert alert-<?php echo (phpShowSystemFeedback($_SESSION['msgid'])[0]); ?>" role="alert">
					<?php echo (phpShowSystemFeedback($_SESSION['msgid'])[1]); ?>
				</div>
			</div>
		</div>
		<?php } ?>
		<!-- SYSTEM-WIDE FEEDBACK -->

		<?php if ($dbUserRow["user_verified"] == 0) { ?>
	
		<div class="jumbotron jumbotron-fluid">
		  <div class="container">
			<h1 class="display-3">Access denied!</h1>
			<p class="lead">You need to verify your email address before you can use this feature.</p>
		  </div>
		</div>
	  
		<?php } else { ?>

		<!-- LOAD MODULE -->
		<?php
		switch ($_GET["module"]) {
			case "home":
			include('home.php');
			break;
			
			case "settings":
			include('settings.php');
			break;

			case "messaging":
			include('messaging.php');
			break;

			case "group":
			include('group.php');
			break;

			case "groups":
			include('groups.php');
			break;

			case "bookmarks":
			include('bookmarks.php');
			break;

			case "posts":
			include('posts.php');
			break;

			default:
			break;
		}
		?>
		<!-- LOAD MODULE -->

		<?php } ?>


	</div>


	<?php $_SESSION["msgid"]=""; $_SESSION["resend"] = 0; ?>

	<script src="gate.js"></script>

	<!-- Optional Javascript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>
