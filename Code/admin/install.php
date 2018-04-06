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
<?
function createclassroom($name) {
	require ../db.config.php;
	$sql = 'CREATE TABLE '.$name.' (
id int(4) NOT NULL auto_increment,
date varchar(16) NOT NULL,
title char(225) NOT NULL,
contnent blob NOT NULL,
author char(225) NOT NULL,
ip_host char(26) NOT NULL,
PRIMARY KEY (id),
UNIQUE KEY id (id),
KEY id_2 (id))';
	mysql_query($sql);
}
switch($_GET['step']) {
case 2:
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
<?
if(!isset($_POST['add'])) { 
	createclassroom($_POST['c_name']);
} else if (!isset($_POST['finish'])) {
	createclassroom($_POST['c_name']);
	header('Location: ../');
} 
break;
case 'end':
echo '<div class="form"><p style="font-size: 18pt;">Student Online Application has been installed!</p></div>';
break;
default:
if(!isset($_POST['ok'])) { 
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
<?php
} else {
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

$connessione = mysql_connect($db_server, $db_user, $db_pass) or die (mysql_error());
$db = mysql_select_db($datab, $connessione) or die (mysql_error());
'."?>";
$dbconf = fopen('db.config.php','w');
fwrite($dbconf, $txt);
header('Location: ?step=2');
break;
};
};
?>
</body>
</html>