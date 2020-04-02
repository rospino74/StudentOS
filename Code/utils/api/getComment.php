<?php

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

$posts = $link->prepare("SELECT * FROM `comments-$_POST[class]` ORDER BY `date` DESC");
if($posts->execute() == false) {
	header('HTTP/1.0 500 Database Error (Comment)');
	exit;
}

$return = array();

while($data = $posts->fetch(PDO::FETCH_ASSOC)) {
 
	$id = $data['id'];
	
	$tmp_date1 = explode(" ", $data['date']);
	$tmp_date = explode("-", $tmp_date1[0]);
	$date = $tmp_date[2] . '/' . $tmp_date[1] . '/' . $tmp_date[0] . " - " . $tmp_date1[1];
	
	$text = $data['content'];
	
	//author details
	$author['name'] = getUserInfo("name", $data['author_id'], $link, "id");
	//if the author doesn't exist, skip the comment
	if($author['name'] == null)
		continue;
	$author['id'] = $data['author_id'];
	
	$isOwner = (getUserInfo("id", $_POST['session'], $link) == $data['author_id'] || getUserInfo("role", $_POST['session'], $link) == "administrator" || (getUserInfo("role", $_POST['session'], $link) == "teacher" && getUserInfo("role", $data['author_id'], $link, "id") == "student") ) ? true : false;

	$return[] = ["id" => $id, "parent_id" => $data['parent_id'], "date" => $date, "text" => $text, "author" => $author, "isOwner" => $isOwner];
 
};

//OUTPUT
header('Content-Type: application/json');
echo json_encode($return);

?>