<?php

	require_once("../../db.config.php");
	require_once("../getClassInfo.php");
	
	$class = $_POST['class'];
	$session = $_POST['session'];
	$title = str_replace("<", "&lt;", str_replace("script", "&#115;&#99;&#114;&#105;&#112;&#116;", str_replace(">", "&gt;", $_POST['title'])));	
	$text = str_replace("<", "&lt;", str_replace("script", "&#115;&#99;&#114;&#105;&#112;&#116;", str_replace(">", "&gt;", $_POST['text'])));
	
	$query = $link->prepare("SELECT role, COUNT(id) as 'count' FROM `users` WHERE `session` = :session");
			
	if($query->execute([":session" => $session]) != false){
		$result = $query->fetch(PDO::FETCH_ASSOC);
	}else{
		header('HTTP/1.0 500 Database Error');
		exit;
	}
	
	if($result['count'] != 1 || ($result['role'] == "student" && getClassInfo("can_students_post", $class, $link) == 0)) {
		header('HTTP/1.1 401 Unauthorized');
		exit;
	}
	
	require_once("../managePost.php");
	require_once("../getUserInfo.php");
	
	$author = getUserInfo("name", $session, $link);
	
	$result = addPost($class, ['author' => $author, 'title' => $title, 'text' => $text], $link);
	
	if($result) {
		header('HTTP/1.1 200 OK');
	} else {
		header('HTTP/1.1 500 Database Error');
		exit;
	}

?>