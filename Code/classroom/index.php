<!DOCTYPE html>
<html lang="it">
<head>
	<meta name="charset" value="utf-8">
	<meta name="theme-color" content="#53e300">
	<meta name="Author" content="Marko">
	<meta name="Description" content="Last posts for <?php echo $_GET['class']; ?>" />
	<title><?php echo $_GET['class']; ?> | Student</title>
	<link rel="shortcut icon" href="../rsc/favicon.ico" type="image/x-icon">
	<link href="../rsc/icon-hires.png" rel="icon" sizes="192x192" />
	<link href="../rsc/icon.png" rel="icon" sizes="128x128" />
	<link href='https://fonts.googleapis.com/css?family=Architects%20Daughter' rel='stylesheet'>
	<link href='../style/style.css' rel='stylesheet'>
    <!--link href='../style/media.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script>
    	$( "#btn-menu" ).click(function() {
				$(".menu-item").toggle();
		});
    </script-->
	<style>
		.info {
			text-align: right;
		}
	</style>
</head>
<body>
<div class="navbar">
  <a href="../" class="menu-item" id="home"><img style='display:none;' src="../rsc/icon_hires.png" />Student</a>
  <a href="#last">Ultimo Post</a>
  <a href="../check.php" style="float:right;">Esci</a>
</div>
<?php
include '../db.config.php';
$classe = $_GET['class'];
$action = isset($_GET['action']) ? $_GET['action'] : null;
switch($action) {
//caso niente
default:
$sql = 'SELECT * FROM ' . $classe;
$query = mysqli_query($connessione, $sql);
echo '<div align="center" style="margin-top: 10%;"><h1 style="color: #33cc33; font-family: Architects Daughter;">Ultimi post per '.$classe.'</h1></div>';
 while($data = mysqli_fetch_array($query)) {
 $id = $data['id'];
 $date = $data['date'];
 $title = $data['title'];
 $content = $data['content'];
 $author = $data['author'];
//ora inserisco la tabella
 echo <<<EOD
 <div class="content">
	<div class="title">
		<h3>$title</h3>
	</div>
    <div class="text">
    	<p>$content</p>
    </div>
	<div class="info">
		$author	- $date
	</div>	
 </div>
EOD;
 };
break;
//se a è addnews
case'addnews':
$invia = $_POST['invia'];
 if(!$invia) {
  echo <<<EOD
<div class="content" style="text-align: center;">
	<form action="" method="POST">
			<label for="titolo" style="color: #33cc33; font-family: Architects Daughter;">Titolo</label><br />
            <input name="titolo" type="text" placeholder="Insert the title..."/><br /><br />
            <label for="testo" style="color: #33cc33; font-family: Architects Daughter;">Testo</label><br />
            <textarea name="testo" placeholder="Insert the text..." style="margin: 5%; width: 10em; height: 5em"></textarea><br />
            <input name="invia" type="submit" value="Invia" />&nbsp;<input name="reset" type="reset" value="Reset Campi" style="cursor: not-allowed;"/>
	</form>
</div>
EOD;
} else {
 $title = $_POST['titolo'];	
 $text = $_POST['testo'];
 $sql = "INSERT INTO `".$dbname."`.`" . $classe . "` (`id`, `date`, `title`,`content`, `ip_host`, `author`) VALUES (NULL, '".$data."', '".$title."', '".$text."', '".$_SERVER['REMOTE_ADDR']."', '".$username."')";
 $query = mysqli_query($connessione, $sql);
 header('HTTP/1.0 200 Ok');
};
break;
}; //fine switch
?>
<span id="last"></span>
</body>
</html>