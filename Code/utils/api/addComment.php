<?php

	require_once("../../db.config.php");
	require_once("../getClassInfo.php");
	
	$class = $_POST['class'];
	$session = $_POST['session'];
	$parent_id = $_POST['parent_id'];
	$text = nl2br(str_replace("<", "&lt;", str_replace("script", "&#115;&#99;&#114;&#105;&#112;&#116;", str_replace(">", "&gt;", $_POST['text']))));
	
	$query = $link->prepare("SELECT COUNT(id) as 'count' FROM `users` WHERE `session` = :session");
			
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
	if(getClassInfo("is_readonly", $class, $link) == 1) {
		header('HTTP/1.1 409 Conflict');
		echo '{"Error":true, "Detail":"' . $class . ' is readonly"}';
		exit;
	}
	
	require_once("../manageComment.php");
	require_once("../getUserInfo.php");
	
	$author_id = getUserInfo("id", $session, $link);
	
	$result = addComment($class, ['author_id' => $author_id, 'parent_id' => $parent_id, 'text' => $text], $link);
	
	if($result) {
		header('HTTP/1.1 201 Created');
	} else {
		header('HTTP/1.1 500 Database Error');
		echo '{"Error":true, "Detail":"Inserting Error (Database)"}';
		exit;
	}

?>