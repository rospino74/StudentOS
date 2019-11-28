<?php
session_start();
require_once("db.config.php");
#session_id(rand());

$err = isset($_GET['action']) ? $_GET['action'] : false;

if($err == "logout") {
	$query = $link->prepare("UPDATE `users` SET `session` = '' WHERE `session` = ?");
	$query->execute([session_id()]);

	session_destroy();
    setcookie("logged_in", 0, time() - 36000, $path['server'], $domain, true, false);
	setcookie("session", 0, time() - 36000, $path['server'], $domain, true, false);
	session_start();
}
	
if(isset($_POST['user'])) {
	$user = $_POST['user'];
	$pw = $_POST['pw'];
	$query = $link->prepare("SELECT COUNT(id) as 'count', id, session FROM users WHERE `username` = ? and `password` = PASSWORD(?)");
		
		if($query->execute([$user, $pw]) != false):
			$result = $query->fetch(PDO::FETCH_ASSOC);
			
			$num = $result['count'];
			//$session = $result['session'];
			
		else:
			$num = 0;
		endif;

	if($num == 1) {		
		$query = $link->prepare("UPDATE `users` SET `session` = ? WHERE `id` = ?");
		
		if($query->execute([session_id(), $result['id']]) != false){
			header('HTTP/1.1 200 OK');

			setcookie("session", session_id(), 0, $path['server'], $domain, true, true);
			setcookie("logged_in", 1, 0, $path['server'], $domain, true, true);
			
			if(isset($_GET['ref']))
				header("Location: $_GET[ref]");
			else
				header('Location: index.php');
			exit;
		} else {
			$err = "error";
			return;
		}
		
		//if wrong
	} else {
		header('HTTP/1.1 401 Unauthorized');
		$err = "wrong";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="theme-color" content="#53e300"/>
	<meta name="Author" content="Marko"/>
	<meta name="Description" content="Login into Student's system" />
	<title>Student | Sign in page</title>
	
	<link rel="shortcut icon" href="rsc/icon.png" type="image/x-icon">
	<link href="rsc/icon-hires.png" rel="icon" sizes="192x192" />
	<link href="rsc/icon.png" rel="icon" sizes="128x128" />
	
	<link href="style/style.css" rel="stylesheet" />
	<link href="style/input.css" rel="stylesheet" />
	
    <meta name="MobileOptimized" content="176" />
  	<meta name="viewport" content="width=device-width, user-scalable=0, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
    <style>
    	.info-logout {
			padding: 2%;
    		color: white;
    		background-color: #0bf;
			border-radius: 5px;
    		text-align:center;
            margin: 2% auto;
			width: 180px;
            font-family: 'courier new', courier, monospace;
		}
		.info-error {
			padding: 2%;
    		color: white;
    		background-color: #f55;
			border-radius: 5px;
    		text-align:center;
            margin: 2% auto;
			width: 180px;
            font-family: 'courier new', courier, monospace;
		}
    </style>
</head>
<body>
<div class="centrato">
	<p style="text-align: center; font-size: 18pt; font-family: terminal, monaco, monospace; color: #3C3; font-weight: bold;">Accesso</p>
<?php
	if($err == "logout") {
        echo '<div class="info-logout">Successfully logged out!</div>';
	} else if($err == "error") {
		echo '<div class="info-error">Login failed!</div>';
		session_destroy();
	} else if($err == "wrong") {
		echo '<div class="info-error">Username/Password wrong!</div>';
		session_destroy();
	} else if($err == "old-session") {
		echo '<div class="info-error">Session expired!</div>';
		//session_destroy();
	}
?>
    <form action="" method="POST" class="centrato">
		<p style="text-align: center;">
			<label for="user" style="font-size: 12pt; font-family: 'courier new', courier, monospace; color: #33cc33; font-weight: bold; ">username</label><br />
			<input name="user" type="text" required /><br />
			<label for="pw" style="font-size: 12pt; font-family: 'courier new', courier, monospace; color: #33cc33; font-weight: bold;">password</label><br />
    		<input name="pw" type="password" required />
			<br /><br />
    		<input name="ok" type="submit" value="Invia" />
    	</p>
	</form>
</div>
</body>
</html>