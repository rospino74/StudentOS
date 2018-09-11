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
    	#logout {
			padding: 2%;
    		color: black;
    		background-color: #bdcddc;
    		border-left: 5px #0090ff solid;
    		text-align:center;
            margin: 2% auto;
			width: 180px;
            height: 50px;
            font-family: 'courier new', courier, monospace;
		}
    </style>
</head>
<body>
<?php
$job = $_GET['logout'];
	setcookie(login, 1, time() - 36000);
	setcookie(username, Gg, time() - 36000);
 	if(!isset($_POST['user'])) {
 ?>
<div class="centrato">
	<p style="text-align: center; font-size: 18pt; font-family: terminal, monaco, monospace; color: #3C3; font-weight: bold;">Accesso</p>
<?	if(isset($job)) {
		setcookie(login, 1, time() - 36000);
		setcookie(username, Gg, time() - 36000);
        echo '<div id="logout">logout eseguito con successo!</div>';
};
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
<?
	} else {
  		$user = $_POST['user'];
  		$pw = $_POST['pw'];
  		$sql1 = "SELECT * FROM `acesso` WHERE `nome` = ".$user.";";
  		$userame = mysqli_fetch_array($sql1);
  		$query = mysqli_query($connessione, "SELECT id FROM acesso WHERE nome='$user' and password='" . md5($pw) ."'");
  		/*$query = mysqli_query($sql);*/
  		$num = $query->num_rows;
  		if($num == 1) {
  			setcookie(login, 1, time() + 86400);
  			setcookie(username, $username['persona'], time() + 86395);
  			header('HTTP/1.1 200 OK');
 			header('Location: index.php?user='.$user);
  			//se sbagliato
  		} else {
  			header('HTTP/1.1 403 Forbidden');
  			echo '<h4 style="color: red; text-align: center; font-family: Pricedown; font-size: 128dp;">Coppia<br /><i>Utente / Password errata</i><br /> o non specificata!</h4>';
		};
 }
?>
</body>
</html>