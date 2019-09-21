<?php
if($_COOKIE['logged_in'] == true) {
		$user = isset($_COOKIE['name']) ? $_COOKIE['name'] : null;
} else {
header('Location: check.php');
};
$color="#33CC33";
$theme_color="#53e300"; //default: #53e300
?>
<!DOCTYPE html>
<html>
<head>
    <meta  charset="utf-8">
	<meta name="theme-color" content="<? echo $theme_color;?>">
	<meta name="Author" content="Marko">
	<meta name="Description" content="Student Home" />
	<meta name="MobileOptimized" content="176" />
	<meta name="viewport" content="width=50%, user-scalable=0, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<title>Student | Home</title>
	<link rel="shortcut icon" href="rsc/favicon.ico" type="image/x-icon">
	<link href="rsc/icon-hires.png" rel="icon" sizes="192x192" />
	<link href="rsc/icon.png" rel="icon" sizes="128x128" />
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Architects%20Daughter'>
	<link rel="stylesheet" href="style/button.css">
	<link rel="manifest" href="rsc/manifest.json">
	<style>
	body,h1 {font-family: "Raleway", sans-serif}
	body, html {height: 100%}
	.bgimg {
		background-image: url('rsc/murales.jpg');
		min-height: 100%;
		background-position: center;
		background-size: cover;
		opacity: 1;
	}

	.Student-font {
        font-family: 'Architects Daughter';
        color: black;
	}
	.text {
		background-color: <? echo $color;?>;
		height: 20%;
		width: 40%;
		opacity: 1;
		z-index: +1;
	}

	footer {
		margin-top: 10%;
		margin-bottom: 5%;
		font-size: 10px;
		font-family: 'Raleway';
	}
	a {
		color: <? echo $color;?>;
		font-variant: none;
	}

	a:hover {
        color: #33FF33;
		font-variant: underline;
	}
	.time {
		border: 2px <? echo $color;?> solid;
		margin: 10%;
		margin-top: 2%;
	}
	.desc {
         text-align: center;
         margin: 10%;
	}
	select {
		padding: 16px 20px;
		border: none;
		border-radius: 7px;
		background-color: #33cc33;
		color: white;
	}
	</style>
</head>
<body>
<div id="1" style="text-align: center;">
    <h2 style="color: <?php echo $color;?>;" class="Student-font">Welcome Back<?php echo isset($user) ? ", ".$user : "";?>!</h2>
    <p class="Student-font">Seclect the classroom:</p>
    <select name='pagina' id='pagina'>
        <option selected="selected" disabled="disabled" value="">Classroom --</option>
        <optgroup label="Section E">
            <option value="1e"><b>Classroom 1 E</b></option>
			<option value='2e'><b>Classroom 2 E</b></option>
			<option name="3e" value="3e"><b>Classroom 3 E</b></option>
        </optgroup>
        <optgroup label="Section M">
            <option value="1m">Classroom 1 M</option>
            <option value="2m">Classroom 2 M</option>
            <option value="3m">Classroom 3 M</option>
        </optgroup>
        <optgroup label="Section B">
            <option value="1b">Classroom 1 B</option>
            <option value="2b">Classroom 2 B</option>
            <option value="3b">Classroom 3 B</option>
        </optgroup>
        <optgroup label="Section G">
            <option value="2g">Classroom 2 G</option>
        </optgroup>
    </select>
</div>
<script>
    var spinner = document.querySelector("#pagina");
    spinner.addEventListener("change", function() {
        window.location.href = "classroom/index.php?class=" + spinner.value;
    });
</script>
</body>
</html>