<?php
	function addComment($class, $data, $link) {
		
		$text = $data['text'];
		$parent_id = $data['parent_id'];
		$author_id = $data['author_id'];
		
		$sql = "INSERT INTO `comments-$class` (`id`, `parent_id`, `author_id`, `date`, `content`) VALUES (NULL, :parent_id, :author_id, current_timestamp(), :text);";
	
		$query = $link->prepare( $sql );
	
		try{
			if(!$query->execute([':text' => $text, ':parent_id' => $parent_id, ':author_id' => $author_id]))
				throw new PDOException("Database error: " . json_encode($query->errorInfo()));
		}
		catch (PDOException $e) {
			echo 'Execution failed: ' . $e->getMessage();
			return false;
		}
			return true;
	}
	
	function removeComment($class, $id, $link) {
		
		$sql = "DELETE FROM `comments-$class` WHERE `id` = :id;";
	
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