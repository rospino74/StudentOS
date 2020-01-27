<?php

	require_once("../../db.config.php");
	require_once("../getClassInfo.php");
	
	$class = $_POST['class'];
	$session = $_POST['session'];
	$title = nl2br(str_replace("<", "&lt;", str_replace("script", "&#115;&#99;&#114;&#105;&#112;&#116;", str_replace(">", "&gt;", $_POST['title']))));	
	$text = nl2br(str_replace("<", "&lt;", str_replace("script", "&#115;&#99;&#114;&#105;&#112;&#116;", str_replace(">", "&gt;", $_POST['text']))));
	
	$query = $link->prepare("SELECT role, COUNT(id) as 'count' FROM `users` WHERE `session` = :session");
			
	if($query->execute([":session" => $session]) != false){
		$result = $query->fetch(PDO::FETCH_ASSOC);
	}else{
		header('HTTP/1.0 500 Database Error');
		echo '{"Error":true, "Detail":"Login Error (Database)"}';
		exit;
	}
	
	if($result['count'] != 1) {
		header('HTTP/1.1 401 Unauthorized');
		echo '{"Error":true, "Detail":"Unauthorized"}';
		exit;
	}
	if($result['role'] == "student" && getClassInfo("can_students_post", $class, $link) == 0) {
		header('HTTP/1.1 403 Forbidden');
		echo '{"Error":true, "Detail":"Not enough permissions"}';
		exit;
	}
	if(getClassInfo("is_readonly", $class, $link) == 1) {
		header('HTTP/1.1 409 Conflict');
		echo '{"Error":true, "Detail":"' . $class . ' is readonly"}';
		exit;
	}
	
	require_once("../managePost.php");
	require_once("../getUserInfo.php");

	$author_id = getUserInfo("id", $session, $link);
	
	$result = addPost($class, ['author' => $author, 'author_id' => $author_id, 'title' => $title, 'text' => $text], $link);
	
	if($result) {
		header('HTTP/1.1 201 Created');
	} else {
		header('HTTP/1.1 500 Database Error');
		echo '{"Error":true, "Detail":"Inserting Error (Database)"}';
		exit;
	}

?>