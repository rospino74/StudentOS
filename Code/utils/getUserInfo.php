<?php
	function getUserInfo( $what, $session , $link, $byIdUser = false) {
		
		$whitelist = array('name', 'username', 'icon', 'role', 'email', 'id');
		$idUserWhitelist = array('username', 'id');

		if(array_search($what, $whitelist) === false && array_search($byIdUser, $idUserWhitelist) === false)
			return false;
		
		if($byIdUser != false) {
			$query = $link->prepare("SELECT `$what` AS 'return' FROM `users` WHERE `$byIdUser` = ? LIMIT 1;");
		} else {	
			$query = $link->prepare("SELECT `$what` AS 'return' FROM `users` WHERE `session` = ? LIMIT 1;");
		}
		
		if($query->execute([$session]) == false)
			return false;
		
		$result = $query->fetch(PDO::FETCH_ASSOC);
		
		return $result['return'];

	}
?>