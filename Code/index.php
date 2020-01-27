<?php
session_start();
if($_COOKIE['logged_in'] == true && $_COOKIE['session'] == session_id()) {
	require_once("db.config.php");
	require_once("utils/getUserInfo.php");
	
	$name = getUserInfo("name", session_id(), $link);
	$username = getUserInfo("username", session_id(), $link);
	$role = getUserInfo("role", session_id(), $link);
} else {
	header('Location: check.php?action=old-session');
	exit;
};
$color="#33CC33";
$theme_color="#53e300"; //default: #53e300
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<meta name="theme-color" content="<?php echo $theme_color;?>">
	<meta name="Description" content="Student home page" />
	<meta name="MobileOptimized" content="176" />
	<meta name="viewport" content="width=50%, user-scalable=0, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<title>Student | Home</title>
	<link href="rsc/favicon.png"    rel="shortcut icon" type="image/x-icon">
	<link href="rsc/icon-hires.png" rel="icon" sizes="192x192" />
	<link href="rsc/icon.png"       rel="icon" sizes="128x128" />
	
	<link rel="stylesheet" href="style/style.css">
	
	<link rel="manifest" href="rsc/manifest.json">
	<style>
	body,h1 {font-family: "Prompt", sans-serif}
	body, html {margin: 0; padding: 0; margin-top: 10%;}

	.Student-font {
        font-family: 'Architects Daughter';
        color: black;
	}
	.text {
		background-color: <?php echo $color;?>;
		height: 20%;
		width: 40%;
		opacity: 1;
		z-index: +1;
	}

	footer {
		margin-top: 10%;
		margin-bottom: 5%;
		font-size: 10px;
		font-family: 'Prompt';
	}
	a {
		color: <?php echo $color;?>;
		font-variant: none;
	}

	a:hover {
        color: #33FF33;
		font-variant: underline;
	}
	.time {
		border: 2px <?php echo $color;?> solid;
		margin: 10%;
		margin-top: 2%;
	}
	.desc {
         text-align: center;
         margin: 10%;
	}
	select {
		padding: 20px;
		border: 2px solid <?php echo $color;?>;
		box-shadow: none;
		border-radius: 5px;
		background-color: white;
		color: <?php echo $color;?>;
	}
	select:focus,
	select:hover
	{
		box-shadow: 0 0 0 .2rem #55ee55;
	}
	</style>
</head>
<body>
	<div class="navbar">
		<a href="#" class="navbar-item navbar-icon" rel="home"><img src="rsc/icon-hires.png" alt="Student"/></a>
		
		<?php
			if($role=="administrator") echo '<a href="admin/" class="navbar-item">Settings <i class="fas fa-tools"></i></a>';
		?>
		
		<a style="float:right;" class="navbar-item" href="check.php?action=logout">Sign Out <i class="fas fa-sign-out-alt"></i></a>
	</div>
<div id="1" style="text-align: center;">
    <h2 style="color: <?php echo $color;?>;" class="Student-font">Welcome Back<?php echo isset($name) ? ", $name" : "";?>!</h2>
    <p>Select the classroom</p>
    <select name='pagina' id='pagina'>
        <option selected="selected" disabled="disabled" value="">Classroom --</option>
		
		<?php
		require_once("db.config.php");
		$query = $link->prepare("SELECT `name` FROM `classrooms` WHERE `members` LIKE '%\"$username\"%';");
		echo $query->execute() ? "" : $link->errorInfo;
		
		while($c = $query->fetch(PDO::FETCH_ASSOC))
		{
			echo "<option value=\"$c[name]\">Classroom " . strtoupper($c['name']) . "</option>";
		}
		
		?>
		
    </select>
</div>
<script src="js/navbar.js"></script>
<script>
    let spinner = document.querySelector("#pagina");
    spinner.addEventListener("change", (e) => {
		if(spinner.value == "") {
			e.stopPropagation();
			return;
		}
		
        window.location.href = "classes/" + spinner.value;
    });
</script>
</body>
</html>