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
$class = $_GET['class'];
$action = isset($_GET['action']) ? $_GET['action'] : null;

switch($action) {
//caso niente
default:
echo '<div align="center" style="margin-top: 10%;"><h1 style="color: '.$color.'; font-family: Architects Daughter;">Last post for '.strtoupper($class).'</h1></div>';


$query = $link->prepare("SELECT * FROM $class ORDER BY `date` DESC");

if($query->execute() == false)
	break;

while($data = $query->fetch(PDO::FETCH_ASSOC)) {
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
$invia = isset($_POST['send']) ? $_POST['send'] : false;
 if($invia) {
	$title = $_POST['title'];	
	$text = $_POST['text'];
	$sql = "INSERT INTO `$class` (`id`, `date`, `title`, `content`, `ip`, `author`) VALUES (". rand() .", CURRENT_DATE, :title, :text, '".$_SERVER['REMOTE_ADDR']."', :author)";
	
	$query = $link->prepare( $sql );
	
	try{
		if(!$query->execute([':title' => $title, ':text' => $text, ':author' => $name])) throw new PDOException("Database error: " . json_encode($query->errorInfo()));
	}
	catch (PDOException $e) {
		header("HTTP/1 500 Database Error");
		echo 'Execution failed: ' . $e->getMessage();
		
		break;
	}
	header('HTTP/1.0 200 Ok');
	header('Location: ' . $class);
};
echo <<<EOD
<div class="content" style="text-align: center; margin-top: 5%;">
	<form action="" method="POST">
			<label for="title" style="color: $color; font-family: Architects Daughter;">Title</label><br />
            <input name="title" type="text" placeholder="Insert the title..."/><br />
            <label for="text" style="color: $color; font-family: Architects Daughter;">Text</label><br />
            <textarea name="text" placeholder="Insert the text..." style="margin-bottom: 15px;" style="height: 50%; width: 50%;"></textarea><br />
            <input name="send" type="submit" value="Submit" style="margin-right: 25px;"/><button data-action="back" class="btn-negative">Indietro</button>
	</form>
</div>
EOD;
break;
}; //fine switch
?>
<script src="../js/navbar.js"></script>
</body>
</html>