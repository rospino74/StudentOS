<?php
//1. Path info

//Your app path here
$domain = "localhost";
$path['real'] = "/home/circleci/project/Code/tmpdir/Code/";
$path['server'] = "/tmpdir/Code/";

//2. General stuff

$time = date("D/d/m/Y H:i");

//Webmaster's email
$webmaster_mail = "test@test.com";

//3. Database info 
//Mysql Url
$db_server = "127.0.0.1";

//User and password
$db_user = "root";
$db_pass = "";

//DB Name
$db = "studentoa";

//Link to MySql

$link = new PDO("mysql:dbname=$db;host=$db_server", $db_user, $db_pass);
?>