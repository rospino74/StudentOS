<?php
	function buildSession() {
		//destroying the old session and deleting the old cookies if the session exist
		if(session_status() == PHP_SESSION_ACTIVE) {
			session_destroy();
			setcookie("logged_in", 0, time() - 36000);
			setcookie("session", 0, time() - 36000);
		}
		
		//generatng a new session id
		$newSID = md5(strtotime("now") . "-" . rand());
		session_id($newSID);
		
		//then starting it
		session_start();
	}
?>