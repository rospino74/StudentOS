<?php
	function getCommentInfo( $what, $class, $id, $link ) {
		
		$whitelist = array('author_id', 'content', 'date', 'parent_id');

		if(array_search($what, $whitelist) === false)
			return false;
		
		$query = $link->prepare("SELECT `$what` AS 'return' FROM `comments-$class` WHERE `id` = ? LIMIT 1;");
		
		if($query->execute([$id]) == false)
			return false;
		
		$result = $query->fetch(PDO::FETCH_ASSOC);
		
		return $result['return'];

	}
?>