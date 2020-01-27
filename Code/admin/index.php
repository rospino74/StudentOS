<?php
session_start();
require_once("../db.config.php");
require_once("../utils/getUserInfo.php");

if($_COOKIE['logged_in'] == 1 && $_COOKIE['session'] == session_id() && getUserInfo("role", session_id(), $link) == 'administrator') {
	$name = getUserInfo("name", session_id(), $link);
	$username = getUserInfo("username", session_id(), $link);
} else {
	header('HTTP/1.1 403 Forbidden');
	header('Location: ../check.php?ref=admin/&action=not-permission');
	exit;
};

$class = "2g";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="theme-color" content="#53e300" />
  <meta name="Author" content="Marko" />
  <title>Student | Administrator settings</title>
  <link rel="shortcut icon" href="../rsc/icon.png" type="image/x-icon" />
  
  <link href='../style/style.css'  rel='stylesheet'/>
  <link href="../style/admin.css"  rel="stylesheet"/>
</head>
<body>
	<aside class="navbar">
		<a class="navbar-item navbar-icon" data-action="home" rel="home"><img src="../rsc/icon-hires.png" alt="Student"/></a>
		<a class="navbar-item" data-action="back">Back</a>
		<a style="float:right;" class="navbar-item" data-action="quit">Sign Out <i class="fas fa-sign-out-alt"></i></a>
	</aside>
	
	<div class="main">
		<aside class="action-list">
			<a href="">1g</a>
			<a href="" class="active">2g</a>
			<a href="">3g</a>
			<a href="">4g</a>
			<a href="">5g</a>
			<a href="">+ ADD</a>
		</aside>
		<section class="setting-panel">
			<div class="can-students-post">
				<p>Can students post on this class?</p>
				<?php
					require_once("../utils/getClassInfo.php");
					
					$can_post = getClassInfo("can_students_post", $class, $link);
					if($can_post == 1) {
						echo '<input type="checkbox" id="can" checked="true"/>';
					} else {
						echo '<input type="checkbox" id="can"/>';
					}
					?>
			</div>
			<div class="members-list">
				<p>Class members</p>
				<ul>
					<?php						
						//building the query to get members
						$members = json_decode( getClassInfo("members", $class, $link), true );
						
						//printing teachers
						foreach($members["teachers"] as $t) {
							//skip the user if he is an admin							
							if(getUserInfo("role", $t, $link, "username") == "administrator")
								continue;
							
							//else printing his name
							echo "<li class='teacher'>" . $t . "</li>";
						}
						//printing students
						foreach($members["students"] as $s) {							
							//printing his name
							echo "<li class='student'>" . $s . "</li>";
						}
					?>
				</ul>
			</div>
			<div class="bad-buttons">
				<button class="btn-negative">Mark <i>Readonly</i></button>
				<button class="btn-positive">Unmark <i>Readonly</i></button>
				<button class="btn-negative">Delete</button>
			</div>
		</section>
	</div>
	
<script src="../js/navbar.js"></script>
</body>
</html>