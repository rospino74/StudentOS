<?php

	require_once("../../db.config.php");
	
	$id = $_POST['id'];
	$parent_id = $_POST['parent_id'];
	$class = $_POST['class'];
	
	$session = $_POST['session'];
	
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
	
	require_once("../manageComment.php");
	require_once("../getUserInfo.php");
	require_once("../getClassInfo.php");
	require_once("../getPostInfo.php");
	require_once("../getCommentInfo.php");
	
	$name = getUserInfo("id", $session, $link);
	$role = getUserInfo("role", $session, $link);
	$author = getPostInfo("author_id", $class, $parent_id, $link);
	$comment_author = getCommentInfo("author_id", $class, $id, $link);
	
	if($name != $author && $role != "administrator" && !($role == "teacher" && getUserInfo("role", $comment_author, $link, "id") == "student")) {
		header('HTTP/1.1 403 Forbidden');
		echo '{"Error":true, "Detail":"Not enough permissions"}';
		exit;
	}
	if(getClassInfo("is_readonly", $class, $link) == 1) {
		header('HTTP/1.1 409 Conflict');
		echo '{"Error":true, "Detail":"' . $class . ' is readonly"}';
		exit;
	}
	
	$result = removeComment($class, $id, $link);
	
	if($result) {
		header('HTTP/1.1 200 OK');
	} else {
		header('HTTP/1.1 500 Database Error');
		echo '{"Error":true, "Detail":"Deleting Error (Database)"}';
		
		exit;
	}

?>