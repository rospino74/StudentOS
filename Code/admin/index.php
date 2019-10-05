<?php
if($_COOKIE['logged_in'] == true && $_COOKIE['role'] == 'administrator') {
		$name = isset($_COOKIE['name']) ? $_COOKIE['name'] : null;
		$username = isset($_COOKIE['username']) ? $_COOKIE['username'] : null;
} else {
	header('HTTP/1.1 403 Forbidden');
	header('Location: ../check.php');
};
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="theme-color" content="#53e300" />
  <meta name="Author" content="Marko" />
  <title>Student | Administrator settings</title>
  <link rel="shortcut icon" href="../rsc/icon.png" type="image/x-icon" />
  
  <link rel="stylesheet" href="../style/navbar.css" />
  <link rel="stylesheet" href="../style/admin.css" />
</head>
<body>
	<aside class="navbar">
		<a class="navbar-item navbar-icon" data-action="home" rel="home"><img src="../rsc/icon-hires.png" alt="Student"/></a>
		<a class="navbar-item" data-action="back">Back</a>
		<a style="float:right;" class="navbar-item" data-action="quit">Sign Out</a>
	</aside>
	
	<div class="main">
		<section class="action-list">
			<a href="">2g</a>
		</section>
	</div>
	
<script src="../js/navbar.js"></script>
</body>
</html>