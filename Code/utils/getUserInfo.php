<?php
	function getUserInfo( $what, $session , $link ) {
		
		if(strpos($what, 'password') !== false || strpos($what, 'session') !== false)
			return false;
		
		$query = $link->query("SELECT `".$link->real_escape_string($what)."` AS 'return' FROM users WHERE `session` = '".$link->real_escape_string($session)."' LIMIT 1;")->fetch_assoc();
		
		if($query == false)
			return false;
		
		return $query['return'];
		
	}
?>