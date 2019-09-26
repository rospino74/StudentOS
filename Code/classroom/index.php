<?php
if($_COOKIE['logged_in'] == true) {
		$name = isset($_COOKIE['name']) ? $_COOKIE['name'] : null;
		$username = isset($_COOKIE['username']) ? $_COOKIE['username'] : null;
} else {
header('Location: ../check.php');
};
$color="#33CC33";
$theme_color="#53e300"; //default: #53e300
?>

<!DOCTYPE html>
<html lang="it">
<head>
	<meta name="charset" value="utf-8">
	<meta name="theme-color" content="<?php echo $theme_color;?>">
	<meta name="Author" content="Marko">
	<meta name="Description" content="Last posts for <?php echo $_GET['class']; ?>" />
	<title><?php echo $_GET['class']; ?> | Student</title>
	<link rel="shortcut icon" href="../rsc/favicon.ico" type="image/x-icon">
	<link href="../rsc/icon-hires.png" rel="icon" sizes="192x192" />
	<link href="../rsc/icon.png" rel="icon" sizes="128x128" />
	<link href='https://fonts.googleapis.com/css?family=Architects%20Daughter' rel='stylesheet'>
	
	<link href='../style/style.css' rel='stylesheet'>
	<link href='../style/navbar.css' rel='stylesheet'>
	
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
		<a href="../" class="navbar-item navbar-icon" data-action="goto:home" rel="home"><img src="../rsc/icon-hires.png" alt="Student"/></a>
		<a href="#last" class="navbar-item">Ultimo Post</a>
		<a href="../check.php?action=logout" style="float:right;" class="navbar-item" data-action="action:quit">Esci</a>
	</div>
<span id="last"></span>
<?php
require '../db.config.php';

$classe = $_GET['class'];
$action = isset($_GET['action']) ? $_GET['action'] : null;

switch($action) {
//caso niente
default:
$sql = 'SELECT * FROM ' . $classe . "  ORDER BY `id` DESC";
$query = $link->query( $sql );
echo '<div align="center" style="margin-top: 10%;"><h1 style="color: '.$color.'; font-family: Architects Daughter;">Ultimi post per '.$classe.'</h1></div>';
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
case'write':
$invia = $_POST['invia'];
 if(!$invia) {
  echo <<<EOD
<div class="content" style="text-align: center;">
	<form action="" method="POST">
			<label for="titolo" style="color: $color; font-family: Architects Daughter;">Titolo</label><br />
            <input name="titolo" type="text" placeholder="Insert the title..."/><br /><br />
            <label for="testo" style="color: $color; font-family: Architects Daughter;">Testo</label><br />
            <textarea name="testo" placeholder="Insert the text..."></textarea><br />
            <input name="invia" type="submit" value="Invia" /><input name="reset" type="reset" value="Reset Campi" style="cursor: not-allowed;"/>
	</form>
</div>
EOD;
} else {
 $title = $_POST['titolo'];	
 $text = $_POST['testo'];
 $sql = "INSERT INTO `" . $classe . "` (`id`, `date`, `title`,`content`, `ip_host`, `author`) VALUES (NULL, '".$data."', '".$title."', '".$text."', '".$_SERVER['REMOTE_ADDR']."', '".$name."')";
 $query = $link->query($sql);
 header('HTTP/1.0 200 Ok');
};
break;
}; //fine switch
?>
</body>
</html>