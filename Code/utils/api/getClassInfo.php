<?php

require_once("../../db.config.php");
require_once("../getUserInfo.php");

//BEGIN AUTHENTICATION BLOCK
$query = $link->prepare("SELECT role, COUNT(id) as 'count' FROM `users` WHERE `session` = :session");

if($classes->execute() == false || $query->execute([":session" => $_POST['session']]) == false) {
	header('HTTP/1.0 500 Database Error');
	exit;
}
$result = $query->fetch(PDO::FETCH_ASSOC);
if($result['count'] != 1) {
		header('HTTP/1.1 401 Unauthorized');
	}

$in_class = false;
foreach($classes->fetchAll(PDO::FETCH_ASSOC) as $c){
	if($_POST['class'] == $c['name'])
		$in_class = true;
}
if(!$in_class) {
	header('HTTP/1.1 403 Forbidden');
	exit;
}
//END AUTHENTICATION BLOCK


//OUTPUT
header('Content-Type: application/json');
echo json_encode($return);

?>