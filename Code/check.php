<?php
require "db.config.php";

$err = false;
$job = isset($_GET['action']) ? $_GET['action'] : null;

if($job == "logout") {
    setcookie("logged_in", 0, time() - 36000);
	setcookie("name", NULL, time() - 36000);
	setcookie("username", NULL, time() - 36000);
	setcookie("role", NULL, time() - 36000);
}
	
	if(isset($_POST['user'])) {
		$user = $_POST['user'];
  		$pw = $_POST['pw'];
  		$query = $link->query("SELECT COUNT(id) as 'count', name, username, role FROM users WHERE `username` = '$user' and `password` = PASSWORD('$pw')");
			
			if($query != false):
				$query = $query->fetch_assoc();
				$num = $query['count'];
			else:
				$num = 0;
			endif;
 
  		if($num == 1) {
			
  			setcookie("logged_in", 1, time() + 86400);
  			setcookie("name", $query['name'], time() + 86395);
			setcookie("username", $query['username'], time() + 86395);
			setcookie("role", $query['role'], time() + 86395);
			
  			header('HTTP/1.1 200 OK');
 			header('Location: index.php');
			
			exit;
			
  			//se sbagliato
  		} else {
  			header('HTTP/1.1 403 Forbidden');
			$err = true;
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
<?php	if($job == "logout") {
        echo '<div class="info-logout">Successfully logged out!</div>';
	} else if($err == true || $job == "error") {
		echo '<div class="info-error">Login failed!</div>';
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