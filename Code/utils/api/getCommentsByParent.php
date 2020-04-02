<?php

header("Access-Control-Allow-Origin: *");
header("Connection: close");
header('Content-Type: application/json');

require_once("../../db.config.php");
require_once("../getUserInfo.php");

//BEGIN AUTHENTICATION BLOCK
$query = $link->prepare("SELECT COUNT(id) as 'count' FROM `users` WHERE `session` = :session");
$username = getUserInfo("username", $_POST['session'], $link);
$classes = $link->prepare("SELECT `name` FROM `classrooms` WHERE `members` LIKE '%\"$username\"%';");

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

$posts = $link->prepare("SELECT id FROM `comments-$_POST[class]` WHERE `parent_id` = ?");
if($posts->execute([$_POST['id']]) == false) {
	header('HTTP/1.0 500 Database Error (Comment)');
	exit;
}
$return = array();

while($data = $posts->fetch(PDO::FETCH_ASSOC)) {
 
	$id = $data['id'];

	//if the id is null, skip the comment
	if($id == null)
		continue;

	$return["ids"][] = $id;
}

//OUTPUT
echo json_encode($return);
exit;

?>