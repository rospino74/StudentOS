<?php

	require_once("../../db.config.php");
	
	$id = $_POST['id'];
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
	require_once("../getPostInfo.php");
	
	$name = getUserInfo("name", $session, $link);
	$role = getUserInfo("role", $session, $link);
	$author = getPostInfo("author", $class, $id, $link);
	
	if($name != $author && $role != "administrator" && $role != "teacher") {
		header('HTTP/1.1 403 Forbidden');
		
		exit;
	}
	
	$result = removePost($class, $id, $link);
	
	if($result) {
		header('HTTP/1.1 200 OK');
	} else {
		header('HTTP/1.1 500 Database Error');
		exit;
	}

?>