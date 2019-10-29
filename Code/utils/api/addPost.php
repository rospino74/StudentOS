<?php

	require_once("../../db.config.php");
	
	$title = $_POST['title'];	
	$text = $_POST['text'];
	$class = $_POST['class'];
	
	$session = $_POST['session'];
	
	$query = $link->prepare("SELECT COUNT(id) as 'count' FROM `users` WHERE `session` = :session");
			
	if($query->execute([":session" => $session]) != false){
		$result = $query->fetch(PDO::FETCH_ASSOC);
	}else{
		header('HTTP/1.0 500 Database Error');
	}
	
	if($result['count'] != 1) {
		header('HTTP/1.1 401 Unauthorized');
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