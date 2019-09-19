<?php
require "db.config.php";

$err = false;
$job = isset($_GET['action']) ? $_GET['action'] : null;

if($job == "logout") {
    setcookie("login", 0, time() - 36000);
	setcookie("name", NULL, time() - 36000);
}
	
	if(isset($_POST['user'])) {
		$user = $_POST['user'];
  		$pw = $_POST['pw'];
  		$query = $connessione->query("SELECT count(id) as c, name FROM user WHERE 'username'='$user' and 'password'=PASSWORD('" . $pw . "')");
			if($query != false)
				$num = $query->num_rows;
			else
				$num = 0;
  		if($num == 1) {
  			setcookie("login", 1, time() + 86400);
  			setcookie("name", $query['Name'], time() + 86395);
  			header('HTTP/1.1 200 OK');
 			header('Location: index.php?user='.$user);
			
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
	<meta name="Description" content="Login at Student's system" />
	<title>Student: Login</title>
	<link href="style/style.css" rel="stylesheet" />
    <meta name="MobileOptimized" content="176" />
  	<meta name="viewport" content="width=device-width, user-scalable=0, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
    <style>
    	.logout {
			padding: 2%;
    		color: black;
    		background-color: #bdcddc;
    		border-left: 5px #0090ff solid;
    		text-align:center;
            margin: 2% auto;
			width: 180px;
            font-family: 'courier new', courier, monospace;
		}
		.err-login {
			padding: 2%;
    		color: white;
    		background-color: #ff5555;
    		border-left: 5px #ff9090 solid;
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
        echo '<div class="logout">Logout eseguito con successo!</div>';
	} else if($err == true) {
		echo '<div class="err-login">Login fallito!</div>';
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