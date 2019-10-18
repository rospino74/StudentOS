<?php
session_start();
if($_COOKIE['logged_in'] == true && $_COOKIE['session'] == session_id()) {
	require_once("../db.config.php");
	require_once("../utils/getUserInfo.php");
	
	$name = getUserInfo("name", session_id(), $link);
	$role = getUserInfo("role", session_id(), $link);
} else {
	header('Location: ../check.php?ref=' . urlencode($_SERVER['REQUEST_URI']) . '&action=old-session');
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
	<meta name="Description" content="Last posts for <?php echo strtoupper($_GET['class']); ?>" />
	<title>Student | <?php echo $_GET['class']; ?></title>
	
	<link href="../rsc/icon.png" type="image/x-icon"  rel="shortcut icon">
	<link href="../rsc/icon-hires.png" rel="icon" sizes="192x192" />
	<link href="../rsc/icon.png" rel="icon" sizes="128x128" />
	
	<link href='../style/style.css'  rel='stylesheet'>
	<link href='../style/input.css'  rel='stylesheet'>
	<link href='../style/navbar.css' rel='stylesheet'>
	<link href='../style/font.css'   rel='stylesheet'>
	
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
		<a href="../" class="navbar-item navbar-icon" data-action="home" rel="home"><img src="../rsc/icon-hires.png" alt="Student"/></a>
		<a href="#last" class="navbar-item">Last post</a>
		<a class="navbar-item" data-action="back">Back</a>
		<a href="<?php echo $_GET['class']; ?>:write" class="navbar-item">Add new Post</a>
		<a style="float:right;" class="navbar-item" data-action="quit">Sign Out <i class="fas fa-sign-out-alt"></i></a>
	</div>
<span id="last"></span>
<?php
$classe = $_GET['class'];
$action = isset($_GET['action']) ? $_GET['action'] : null;

switch($action) {
//caso niente
default:
$sql = 'SELECT * FROM ' . $classe . "  ORDER BY `id` DESC";
$query = $link->query( $sql );
echo '<div align="center" style="margin-top: 10%;"><h1 style="color: '.$color.'; font-family: Architects Daughter;">Ultimi post per '.strtoupper($classe).'</h1></div>';
 while($data = $query->fetch_array()) {
	$tmp_date = explode("-", $data['date']);
	 
	$id = $data['id'];
	$date = $tmp_date[2] . '/' . $tmp_date[1] . '/' . $tmp_date[0];
	$title = $data['title'];
	$content = $data['content'];
	$author = $data['author'];
	
//ora inserisco la tabella
 echo <<<EOD
 <article class="content" id="post_$id">
	<header class="title">
		<h2>$title</h2>
	</header>
    <div class="text">
    	<p>$content</p>
    </div>
	<div class="info">
		$author	<i class="fas fa-user"></i><br />$date <i class="fas fa-clock"></i>
	</div>	
 </article>
EOD;
 };
break;
//se a è addnews
case'write':
$invia = isset($_POST['invia']) ? $_POST['invia'] : false;
 if(!$invia) {
  echo <<<EOD
<div class="content" style="text-align: center; margin-top: 5%;">
	<form action="" method="POST">
			<label for="titolo" style="color: $color; font-family: Architects Daughter;">Titolo</label><br />
            <input name="titolo" type="text" placeholder="Insert the title..."/><br />
            <label for="testo" style="color: $color; font-family: Architects Daughter;">Testo</label><br />
            <textarea name="testo" placeholder="Insert the text..." style="margin-bottom: 15px;" style="height: 50%; width: 50%;"></textarea><br />
            <input name="invia" type="submit" value="Invia" style="margin-right: 25px;"/><button data-action="back" class="btn-negative">Indietro</button>
	</form>
</div>
EOD;
} else {
	$title = $_POST['titolo'];	
	$text = $_POST['testo'];
	$sql = "INSERT INTO `" . $classe . "` (`id`, `date`, `title`,`content`, `ip_host`, `author`) VALUES (NULL, '".$time."', '".$title."', '".$text."', '".$_SERVER['REMOTE_ADDR']."', '".$name."')";
	$query = $link->query($sql);
	header('HTTP/1.0 200 Ok');
};
break;
}; //fine switch
?>
<script src="../js/navbar.js"></script>
</body>
</html>