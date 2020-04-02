<?php
session_start();
if($_COOKIE['logged_in'] == true && $_COOKIE['session'] == session_id()) {
	require_once("../db.config.php");
	require_once("../utils/getUserInfo.php");
	
	$name = getUserInfo("name", session_id(), $link);
	$role = getUserInfo("role", session_id(), $link);
} else {
	header('Location: ../check.php?ref=' . urlencode($_SERVER['REQUEST_URI']) . '&action=old-session');
	exit;
};

$class = $_GET['class'];
$color="#33CC33";
$theme_color="#53e300"; //default: #53e300

//can students post?
require_once("../utils/getClassInfo.php");
$can_write = getClassInfo("can_students_post", $class, $link) == 1 && getClassInfo("is_readonly", $class, $link) == 0; 
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="charset" value="utf-8">
	<meta name="theme-color" content="<?php echo $theme_color;?>">
	<meta name="Description" content="Last posts for <?php echo strtoupper($class); ?>" />
	<title>Student | <?php echo $class; ?></title>
	
	<link href="../rsc/icon.png" type="image/x-icon" rel="shortcut icon">
	<link href="../rsc/icon-hires.png" rel="icon" sizes="192x192" />
	<link href="../rsc/icon.png"       rel="icon" sizes="128x128" />
	
	<link href='../style/style.css'		 rel='stylesheet'>
	<link href='../style/SnackAlert.css' rel='stylesheet'>
	<link href='../style/custom.css'		 rel='stylesheet'>
	<?php if($can_write) echo "<link href='../style/writeWindow.css'  rel='stylesheet'>"; ?>
	<!--link href='../style/alert.css'   rel='stylesheet'-->
</head>
<body>
	<nav class="navbar">
		<a href="../" class="navbar-item navbar-icon" data-action="home" rel="home"><img src="../rsc/icon-hires.png" alt="Student"/></a>
		<a href="javascript:window.scrollTo(0,0);" class="navbar-item">Last post</a>
		<?php if($can_write) echo '<a href="javascript:openWriteWindow(settings.s_id, settings.c_id);" class="navbar-item">Write Post</a>'; ?>
		<a style="float:right;" class="navbar-item" data-action="quit">Sign Out <i class="fas fa-sign-out-alt"></i></a>
	</nav>
	<script src="../js/navbar.js"></script>
	
	<h1 style="color: #33cc33; font-family: Architects Daughter; margin-top: 8%; text-align: center;">Last post for <?php echo strtoupper($_GET['class']); ?></h1>
	<section class="posts"></section>
	
	<!-- alerts manager -->
	<script src="../js/SnackAlert.js"></script>
	<script>
		SnackAlert.init();
	</script>
	
	<!--posts and comments manager-->
	<script src="../js/menu.js" async></script>
	<script src="../js/getPost.js"></script>
	<script src="../js/getComment.js"></script>
	<?php if($can_write){?>
		<script src="../js/writePost.js" async></script>
		<script src="../js/writeComment.js" async></script>
		<script src="../js/deletePost.js" async></script>
		<script src="../js/deleteComment.js" async></script>
	<?php } ?>
	
	<script>
		window.settings = {
			can_write: <?php echo ($can_write) ? "true" : "false"; ?>,
			s_id: '<?php echo session_id(); ?>', /*session id*/
			c_id: '<?php echo $class; ?>' /*classroom*/
		};
		
		getPost(settings.c_id, settings.s_id);
		
		setInterval( () => {
			getPost(settings.c_id, settings.s_id);
		}, 60000);
	</script>
</body>
</html>