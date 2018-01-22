<?
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
	.btn-color {
		background-color: <? echo $color;?>;
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
<?php
	if($_COOKIE['logged'] == true) {
		$user = $_COOKIE['username'];
		if(!isset($user)){ $user = $_GET['user'];};
		setcookie(username, $user, 86395);
		$classe = $_POST['pagina'];
		if(!isset($classe)) {
		echo <<<EOD
<div id="1" style="text-align: center;">
	<h2 color: $colore ;" class="Student-font">Welcome $user</h2>
	<p class="Student-font">Seclect the classroom:</p>
	<form action="" method="POST">
<select name='pagina'>
<option selected="selected" disabled="disabled" value="">Classroom --</option>
<optgroup label="Sezione E">
<option value="1e"><b>Classroom 1 E<b/></option>
<option value='2e'><b>Classroom 2 E</b></option>
<option name="3e" value="3e"><b>Classroom 3 E</b></option>
</optgroup>
<optgroup label="Sezione M">
<option value="1m">Classroom 1 M</option>
<option value="2m">Classroom 2 M</option>
<option value="3m">Classroom 3 M</option>
</optgroup>
<optgroup label="Sezione B">
<option value="1b">Classroom 1 B</option>
<option value="2b">Classroom 2 B</option>
<option value="3b">Classroom 3 B</option>
</optgroup>
<optgroup label="Sezione F">
<option value="1f">Classroom 1 F</option>
</optgroup>
</select>
<br>
<br>
<input name="invio" type="submit" value="Go"/>
</p>
</form>
</div>
EOD;
 } else {
 include 'db.config.php';
 mysql_close();
 $url = 'classroom/' .$classe . '.php' ;
 header('Location: ' . $url);
 };
} else {
header('Location: check.php');
};
	} else {
		?>
<div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
<div class="w3-display-topleft w3-padding-large w3-xlarge Student-font" style="color: <? echo $color;?>;"><img src="icon.png" title="StudentOS" alt="Gruppo" /> <b>StudentOS</b></div>
<div class="w3-display-middle">&nbsp; &nbsp;
<h1 class="w3-jumbo w3-animate-top" style="text-align: center;">Student</h1>
<h5 class="w3-animate-top Student-font" style="color:  black; text-align: center;"><strong>The Web doesn't connect only the machines<br />but also<br />the peapol</strong></h5>
<br />
<h6 class="w3-animate-top Student-font" style="color:  black; text-align: center;"><em>Tim Bernes Lee</em></h6>
<hr class="w3-border-grey" style="margin: auto; width: 40%;" />
<p class="w3-large w3-center" id="btn1"><button class="btn-color" onclick="window.location.replace('#explore'); ">Explore</button></p>
</div>
</div>
<div class="desc w3-center">
	<a id="explore"></a>
    <h3 class="Student-font" style="color:<? echo $color;?>;">What is Student?</h3>
    <p>Student is a mini Social Network for students</p>
</div>
<script>
  if ('serviceWorker' in navigator) {
    console.log("C'è un Service-Worker registrato?");
    navigator.serviceWorker.register('/service-worker.js')
      .then(function(reg){
        console.log("Si, c'è!");
      }).catch(function(err) {
        console.error("No, non c'è! Errore: ", err);
      });
  }
</script>
		<?
	}
?>