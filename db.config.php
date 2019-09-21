<?php
//1. generic info
//domain url and path
$domain = "localhost";
$path = "";
$site = $domain . $path;
//2. info for connecting to DB 
$data = date("D/d/m/Y H:i");
//server of DB
$db_server = "localhost";
//user and password DataBase
$db_user = "root";
$db_pass = "";
//name of DataBase
$datab = "StudentOA";
//email webmaster
$webmaster_mail = "test@test.com";

//Mi connetto al DB

$connessione = mysqli_connect($db_server, $db_user, $db_pass, $datab);
?>