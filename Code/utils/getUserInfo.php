<?php
	function getUserInfo( $what, $session , $link ) {
		
		$whitelist = array('name', 'username', 'icon', 'role', 'email');

		if(array_search($what, $whitelist) === false)
			return false;
		
		$query = $link->prepare("SELECT `$what` AS 'return' FROM `users` WHERE `session` = ? LIMIT 1;");
		
		if($query->execute([$session]) == false)
			return false;
		
		$result = $query->fetch(PDO::FETCH_ASSOC);
		
		return $result['return'];

	}
?>