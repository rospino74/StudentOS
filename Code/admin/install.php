<!DOCTYPE html>
<html>
	<head>
		<meta name="Author" content="Marko">
		<meta name="theme-color" content="black">
		<meta name="Description" content="Installing Student Online Application" />
		<link rel="stylesheet" src="../style/style.css" />
		<title>Install StudentOA</title>
		<style>
@import url('https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed:400,600i&subset=latin-ext');
@keyframes trasparenza {

                from {opacity: 0;}

                to {opacity: 1;}
}
input[type=url] {
    border: none;
    border-bottom: 1px solid #33cc33;
	margin: 2% 0;
	transition-property: border;
	transition-duration: 0.5s;
	-moz-transition-property: border;
	-moz-transition-duration: 0.5;
	-o-transition-property: border;
	-o-transition-duration: 0.5s;
	-webkit-transition-property: border;
	-webkit-transition-duration: 0.5s;
}
body {
    margin: 0;
    background-color: black;
	background-repeat: no-repeat;
	background-image: url('https://media.licdn.com/mpr/mpr/AAEAAQAAAAAAAAziAAAAJDdkMzY3ZmI0LWY0M2ItNDA1Yy1hYmJiLTc0NDNlYWRhZDIyOA.jpg');
    font-family: "Comic Sans MS", cursive, sans-serif;
}
div.form {
   /* margin-left: auto !important;
   margin-right: auto !important;*/
	margin: 10%;
    padding: 5%;
    border-radius: 25px;
    background-color: white;
    height: 80%;
	float: left;
    animation-name: trasparenza;
    animation-duration: 0.5s;
}
h1 {
    text-align: center;
color: #33cc33;
}
h5 {
    margin-top: 5%;
    border-bottom: 1px #ccc solid;
    padding-bottom: 2%;
}
set {
margin: auto;
color: #33CC33;
text-align:center;
}
code {
    margin-top:5%;
    background-color: #333;
    color: white;
    padding: 2%;
    border-radius: 15px;
    font-style: italic;
    font-family: 'Barlow Semi Condensed', sans-serif;
}
	</style>
	</head>
	<body>
<?php
function createclassroom($name) {
	require "../db.config.php";
	$sql = "CREATE TABLE `$name` (
  `id` int(4) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `content` blob NOT NULL,
  `date` date NOT NULL,
  `ip` char(25) CHARACTER SET latin1 NOT NULL,
  `author` char(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='posts for $name';

INSERT INTO `$name` (`id`, `title`, `content`, `date`, `ip`, `author`) VALUES(0, 'Errore', 0x51756573746120706167696e61206e6f6e20636f6e7469656e65206e756c6c61206d692064697370696163652e2e2e20506f73746120706572207072696d6f212056697375616c697a7a61206c6120677569646120e29e9c203c6120687265663d222e2e2f61646d696e2f67756964652e706870223e7064663c2f613e, '2019-06-19', '', 'Admin');";
	mysqli_query($connessione, $sql);
}
function createaccount($user, $pw) {
	require "../db.config.php";
	$sql = 'CREATE TABLE user (
	`id` int(3) NOT NULL AUTO_INCREMENT,
	`role` char(45) NOT NULL,
	`username` char(20) NOT NULL,
	`name` char(255) NOT NULL,
	`email` char(255) NOT NULL,
	`password` char(20) NOT NULL,
	`ip` char(25) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `id` (`id`),
	KEY `id_2` (`id`))';
	mysqli_query($connessione, $sql);
	mysqli_query($connessione, "INSERT INTO `acesso` (`id`, `role`, `username`, `name`, `email`, `password`, `ip`) VALUES ('1', 'administrator', '".$user."', 'Administrator', '', PASSWORD('" . $pw . "'), '', '', '');");
}
switch($_GET['step']) {
case  2:
if(!isset($_POST['add'])) { 
?>
	<div class="form">
	<h1>Creating Main User</h1>
	<form action="" method="POST" autocomplete="off">	
	<label for="user">Username</label>
		<br />
	<input type="text" name="user" placeholder="Admin Username" required/>
		<br />
		<label for="pw">Password</label>
		<br />
	<input type="password" name="pw" placeholder="Admin Password" required/>
		<br />
	<input type="submit" name="add" value="Create" style="float: left;"/>
	<input type="reset"/>
	</form>
</div>
<?php
} else {
	createaccount($_POST['user'], $_POST['pw']);
	header('Location: ?step=3');
} 
exit;
break;
case 3:
?>
<div class="form">
<h1>Creating classroom</h1>
	<form action="" method="POST" autocomplete="off">	
	<label for="web_email">Name of Classroom: </label>
		<br />
	<input type="text" name="c_name" placeholder="Classroom name" required />
		<br />
	<input type="submit" name="add" value="Add" style="float: left;"/>
	<input type="submit" name="finish" value="Finish" style="float: right; background-color: orange;"/>
	</form>
</div>
<?php
if(isset($_POST['add'])) { 
	createclassroom($_POST['c_name']);
} else if (isset($_POST['finish'])) {
	createclassroom($_POST['c_name']);
	header('Location: ../');
} 
exit;
break;
case 'end':
echo '<div class="form"><p style="font-size: 18pt;">Student Online Application has been installed!</p></div>';
exit;
break;
}
if(isset($_POST['ok'])) {
	$txt = "<?php".'
//1. generic info
//domain url and path
$domain = "'.$_SERVER["HTTP_HOST"].'";
$path = "";
$site = $domain . $path;
//2. info for connecting to DB 
$data = date("D/d/m/Y H:i");
//server of DB
$db_server = "'.$_POST["db_url"].'";
//user and password DataBase
$db_user = "'.$_POST["db_user"].'";
$db_pass = "'.$_POST["db_pass"].'";
//name of DataBase
$datab = "'.$_POST["db_name"].'";
//email webmaster
$webmaster_mail = "'.$_POST["web_email"].'";

//Mi connetto al DB

$connessione = mysqli_connect($db_server, $db_user, $db_pass, $datab);
'."?>";
$dbconf = fopen('../db.config.php','w');
fwrite($dbconf, $txt);
header('Location: ?step=2');
exit;
}
?>
<div class="form">
<h1>Settings Pre-install</h1>
	<form action="" method="POST" autocomplete="off">	
	<label for="web_email">Email: </label>
		<br />
	<input type="email" name="web_email" placeholder="Webmaser Email" required />
		<br />
	<label for="db_url">DB name</label>
		<br />
	<input type="text" name="db_name" placeholder="Name of DB" required />
		<br />
	<label for="db_user">Username DB</label>
		<br />
	<input type="text" name="db_user" placeholder="Username DataBase" required />
		<br />
	<label for="db_pass">Password DB</label>
		<br />
	<input type="text" name="db_pass" placeholder="Password DataBase" />
		<br />
	<label for="db_url">Url DB (http only)</label>
		<br />
	<input type="url" name="db_url" placeholder="Url DataBase (HTTP)" required />
		<br />
	<input type="submit" name="ok" value="Next" style="float: left;"/>
	<input type="reset" value="Reset" style="float: right;"/>
	</form>
</div>
</body>
</html>