<?php
	function addPost($class, $data, $link) {
		
		$title = $data['title'];	
		$text = $data['text'];
		$author_id = $data['author_id'];
		
		$sql = "INSERT INTO `$class` (`id`, `date`, `title`, `content`, `ip`,`author_id`) VALUES (". rand() .", NOW(), :title, :text, '".$_SERVER['REMOTE_ADDR']."',:author_id)";
	
		$query = $link->prepare( $sql );
	
		try{
			if(!$query->execute([':title' => $title, ':text' => $text, ':author_id' => $author_id]))
				throw new PDOException("Database error: " . json_encode($query->errorInfo()));
		}
		catch (PDOException $e) {
			echo 'Execution failed: ' . $e->getMessage();
			return false;
		}
			return true;
	}
	
	function removePost($class, $id, $link) {
		
		$sql = "DELETE FROM `$class` WHERE `id` = :id;
				DELETE FROM `comments-$class` WHERE `parent_id` = :id;";
	
		$query = $link->prepare( $sql );
	
		try{
			if(!$query->execute([':id' => $id]))
				throw new PDOException("Database error: " . json_encode($query->errorInfo()));
		}
		catch (PDOException $e) {
			#echo 'Execution failed: ' . $e->getMessage();
			return false;
		}
			return true;
	}
?>