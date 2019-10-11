<!DOCTYPE html>
<html>
	<head>
		<meta name="Author" content="Marko">
		<meta name="theme-color" content="black">
		<meta name="Description" content="Installing Student Online Application" />
		
		<link rel="shortcut icon" href="../rsc/icon.png" type="image/x-icon">
		
		<title>Student | Install page</title>
		<style>
@import url('https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed:400,600i&subset=latin-ext');
@keyframes trasparenza {

                from {opacity: 0;}

                to {opacity: 1;}
}
input[type=url],
input[type=email],
input[type=text],
input[type=password], 
input[type=tel] {
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
html, body {
	margin: 0;
	padding: 0;
    background-color: black;
	background-repeat: no-repeat;
	font-family: "Comic Sans MS", cursive, sans-serif;
	height: 100%;
	width: 100%;
}
body {
	display: grid;
	grid-template-rows: 15% auto 15%;
	grid-template-columns: 30% auto 30%;
}
div.form {
	grid-row: 2;
	grid-column: 2;
    padding: 5%;
    border-radius: 25px;
    background-color: white;
	text-align: center;
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
	$sql_1 = "CREATE TABLE `$name` (
		`id` int(4) NOT NULL AUTO_INCREMENT,
		`title` varchar(255) CHARACTER SET latin1 NOT NULL,
		`content` blob NOT NULL,
		`date` date NOT NULL,
		`ip` char(25) CHARACTER SET latin1 NOT NULL,
		`author` char(20) COLLATE utf8_unicode_ci NOT NULL,
		PRIMARY KEY (`id`),
		UNIQUE KEY `id` (`id`),
		KEY `id_2` (`id`)
	) DEFAULT CHARSET=utf8 COMMENT='posts for $name';";

$sql_2 = "INSERT INTO `$name` (`id`, `title`, `content`, `date`, `ip`, `author`) VALUES(0, 'Errore', 0x51756573746120706167696e61206e6f6e20636f6e7469656e65206e756c6c61206d692064697370696163652e2e2e20506f73746120706572207072696d6f212056697375616c697a7a61206c6120677569646120e29e9c203c6120687265663d222e2e2f61646d696e2f67756964652e706870223e7064663c2f613e, '2019-06-19', '', 'Admin');";
$sql_3 = "INSERT INTO `classrooms` (`id`, `name`, `members`, `can_students_post`) VALUES (NULL, '$name', '".'{"teachers":["Admin"],"students":[]}'."', '1');";
	
	$query = $link->query( $sql_1 );
	
	echo $query ? "" : $link->error;
	
	$query = $link->query( $sql_2 );
	
	echo $query ? "" : $link->error;
	
	$query = $link->query( $sql_3 );
	
	echo $query ? "" : $link->error;
}
function createAdmin($user, $pw) {
	require "../db.config.php";
	$query = $link->query("INSERT INTO `users` (`id`, `role`, `username`, `name`, `email`, `password`, `ip`) VALUES ('1', 'administrator', '".$user."', 'Administrator', '$webmaster_mail', PASSWORD('" . $pw . "'), '');");
	
	echo $query ? "" : $link->error;
}

function createtables() {
	require "../db.config.php";
	$sql_1 = "CREATE TABLE users (
		`id` int(3) NOT NULL AUTO_INCREMENT,
		`role` char(45) NOT NULL,
		`username` char(20) NOT NULL,
		`name` char(255) NOT NULL,
		`email` char(255) NOT NULL,
		`password` char(255) NOT NULL,
		`icon` blob NOT NULL,
		`ip` char(25) NOT NULL,
		`session` varchar(255) NOT NULL,
		PRIMARY KEY (`id`),
		UNIQUE KEY `id` (`id`),
		KEY `id_2` (`id`)
	);";
	
	$sql_2 = "CREATE TABLE `classrooms` (
		`id` int(11) NOT NULL AUTO_INCREMENT ,
		`name` char(25) COLLATE utf16_bin NOT NULL ,
		`members` blob COLLATE utf16_bin NOT NULL,
		`can_students_post` tinyint(1) NOT NULL DEFAULT 1 ,
		PRIMARY KEY (`id`),
		UNIQUE KEY `id` (`id`),
		KEY `id_2` (`id`)
	);";
	
	$query = $link->query( $sql_1 );
	
	echo $query ? "" : $link->error;
	
	$query = $link->query( $sql_2 );
	
	echo $query ? "" : $link->error;
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
	<input type="text" name="user" placeholder="Admin Username" required />
		<br />
		<label for="pw">Password</label>
		<br />
	<input type="password" name="pw" placeholder="Admin Password" required />
		<br />
	<input type="submit" name="add" value="Create"/>
	</form>
</div>
<?php
} else {
	createAdmin($_POST['user'], $_POST['pw']);
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
	<input type="text" name="c_name" placeholder="Classroom name" />
		<br />
	<input type="submit" name="add" value="Add" />
	<input type="submit" name="finish" value="Finish" />
	</form>
</div>
<?php
if(isset($_POST['add'])) { 
	if(isset($_POST['c_name']) || $_POST['c_name'] != "")
		createclassroom($_POST['c_name']);
	
} else if (isset($_POST['finish'])) {
	
	if(isset($_POST['c_name']) || $_POST['c_name'] != "")
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
	$txt ='
<?php
//1. Path info

//Your app path here
$domain = "'.$_SERVER["HTTP_HOST"].'";
$path[\'real\'] = "'.dirname(__DIR__).'";
$path[\'server\'] = "'.dirname($_SERVER['PHP_SELF'], 2).'/";

//2. General stuff

$time = date("D/d/m/Y H:i");

//Webmaster\'s email
$webmaster_mail = "'.$_POST["web_email"].'";

//3. Database info 
//Mysql Url
$db_server = "'.$_POST["db_url"].'";

//User and password
$db_user = "'.$_POST["db_user"].'";
$db_pass = "'.$_POST["db_pass"].'";

//DB Name
$db = "'.$_POST["db_name"].'";

//Link to MySql

$link = mysqli_connect($db_server, $db_user, $db_pass, $db);
?>';

$apache_config = "
#StudentOS
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase " . str_replace('\\', '/', dirname($_SERVER['PHP_SELF'], 2)) . "/
RewriteRule ^classes/([A-z0-9+]*)([:]?)([a-z+]*)$ classroom/?class=$1&action=$3 [L]
</IfModule>";



$dbconf = fopen('../db.config.php','w');
$ap_conf = fopen('../.htaccess','a');
fwrite($dbconf, $txt);
fwrite($ap_conf, $apache_config);

#creo le tabelle
createtables();

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
	<label for="db_url">Url DB</label>
		<br />
	<input type="text" name="db_url" placeholder="Url DataBase" required />
		<br />
	<input type="submit" name="ok" value="Next"/>
	<input type="reset" value="Reset"/>
	</form>
</div>
</body>
</html>