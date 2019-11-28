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
<html>
<head>
	<meta name="charset" value="utf-8">
	<meta name="theme-color" content="<?php echo $theme_color;?>">
	<meta name="Description" content="Last posts for <?php echo strtoupper($_GET['class']); ?>" />
	<title>Student | <?php echo $_GET['class']; ?></title>
	
	<link href="../rsc/icon.png" type="image/x-icon"  rel="shortcut icon">
	<link href="../rsc/icon-hires.png" rel="icon" sizes="192x192" />
	<link href="../rsc/icon.png" rel="icon" sizes="128x128" />
	
	<link href='../style/style.css'  rel='stylesheet'>
	<link href='../style/input.css'  rel='stylesheet'>
	<link href='../style/navbar.css' rel='stylesheet'>
	<link href='../style/font.css'   rel='stylesheet'>
	<link href='../style/write.css'  rel='stylesheet'>
	<!--link href='../style/alert.css'   rel='stylesheet'-->
	
	<style>
		.info {
			text-align: right;
		}
	</style>
</head>
<body>
	<nav class="navbar">
		<a href="../" class="navbar-item navbar-icon" data-action="home" rel="home"><img src="../rsc/icon-hires.png" alt="Student"/></a>
		<a href="#top" class="navbar-item">Last post</a>
		<a class="navbar-item" data-action="back">Back</a>
		<!--a href="<?php echo $_GET['class']; ?>:write" class="navbar-item">Add new Post</a-->
		<a href="javascript:openWriteWindow('<?php echo session_id(); ?>', '<?php echo $_GET['class']; ?>');" class="navbar-item">Write Post</a>
		<a href="javascript:showDeleteButtons('<?php echo session_id(); ?>', '<?php echo $_GET['class']; ?>');" class="navbar-item">Remove Post</a>
		<a style="float:right;" class="navbar-item" data-action="quit">Sign Out <i class="fas fa-sign-out-alt"></i></a>
	</nav>
	
	<h1 style="color: #33cc33; font-family: Architects Daughter; margin-top: 8.5%; text-align: center;">Last post for <?php echo strtoupper($_GET['class']); ?></h1>
	<span id="top"></span>
	<section class="posts"></section>
	
	<!--posts manager-->
	<script src="../js/getPost.js"></script>
	<script src="../js/deletePost.js" async></script>
	<!--script src="../js/alert.js"></script-->
	<script src="../js/writePost.js" async></script>
	<script src="../js/navbar.js"></script>
	
	<script>
		getPost("<?php echo $_GET['class']; ?>", "<?php echo session_id(); ?>");
		
		setInterval( () => {
			getPost("<?php echo $_GET['class']; ?>", "<?php echo session_id(); ?>");
		}, 60000)
	</script>
</body>
</html>