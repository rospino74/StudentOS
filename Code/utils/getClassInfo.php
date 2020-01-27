<?php
	function getClassInfo( $what, $name, $link ) {
		
		$whitelist = array('id', 'members', 'can_students_post', 'is_readonly');

		if(array_search($what, $whitelist) === false)
			return false;
		
		$query = $link->prepare("SELECT `$what` AS 'return' FROM `classrooms` WHERE `name` = ? LIMIT 1;");
		
		if($query->execute([$name]) == false)
			return false;
		
		$result = $query->fetch(PDO::FETCH_ASSOC);
		
		return $result['return'];

	}
?>