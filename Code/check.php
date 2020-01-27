<?php
session_start();
require_once ("db.config.php");
require_once ("utils/session.php");

$err = isset($_GET['action']) ? $_GET['action'] : null;

//build a new session if the user has done the log out
if ($err == "logout") buildSession();

//redirecting the user if he has already done the login and he don't want sign out  
if(isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true && isset($_COOKIE['session']) && $_COOKIE['session'] == session_id() && !isset($err)) {
	if (isset($_GET['ref']))
		header("Location: $_GET[ref]");
    else
		header('Location: index.php');
    exit;
}

if (isset($_POST['user']))
{
    $user = $_POST['user'];
    $pw = $_POST['pw'];
    $query = $link->prepare("SELECT COUNT(id) as 'count', id, session FROM users WHERE `username` = ? and `password` = PASSWORD(?)");

    if ($query->execute([$user, $pw]) != false):
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $num = $result['count'];
        else:
            $num = 0;
        endif;

        if ($num == 1)
        {
            $query = $link->prepare("UPDATE `users` SET `session` = ? WHERE `id` = ?");

            if ($query->execute([session_id() , $result['id']]) != false)
            {
                header('HTTP/1.1 200 OK');

                setcookie("session", session_id(), 0);
                setcookie("logged_in", 1, 0);

                if (isset($_GET['ref'])) header("Location: $_GET[ref]");
                else header('Location: index.php');
                exit;
            }
            else
            {
                $err = "error";
                return;
            }
        }
        else
        {
            header('HTTP/1.1 401 Unauthorized');
            $err = "wrong";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="theme-color" content="#53e300"/>
	<meta name="Description" content="Login into Student's system" />
	<title>Student | Sign in</title>
	
	<link rel="shortcut icon" href="rsc/icon.png" type="image/x-icon">
	<link href="rsc/icon-hires.png" rel="icon" sizes="192x192" />
	<link href="rsc/icon.png" rel="icon" sizes="128x128" />
	
	<link href="style/style.css" rel="stylesheet" />
	<link href="style/input.css" rel="stylesheet" />
	
    <meta name="MobileOptimized" content="176" />
  	<meta name="viewport" content="width=device-width, user-scalable=0, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
    <style>
    	.info-logout {
			padding: 2%;
    		color: white;
    		background-color: #0bf;
			border-radius: 5px;
    		text-align:center;
            margin: 2% auto;
			width: 180px;
            font-family: 'courier new', courier, monospace;
		}
		.info-error {
			padding: 2%;
    		color: white;
    		background-color: #f55;
			border-radius: 5px;
    		text-align:center;
            margin: 2% auto;
			width: 180px;
            font-family: 'courier new', courier, monospace;
		}
    </style>
</head>
<body>
<div class="login-container">
	<p style="text-align: center; font-size: 18pt; font-family: terminal, monaco, monospace; color: #3C3; font-weight: bold;">Accesso</p>
<?php
    if ($err == "logout")
    {
        echo '<div class="info-logout">Successfully logged out!</div>';
    }
    else if ($err == "error")
    {
        echo '<div class="info-error">Login failed!</div>';
        buildSession();
    }
    else if ($err == "wrong")
    {
        echo '<div class="info-error">Username/Password wrong!</div>';
        buildSession();
    }
    else if ($err == "old-session")
    {
        echo '<div class="info-error">Session expired!</div>';
        
    }
	else if ($err == "not-permission")
    {
        echo '<div class="info-error">You don\'t have enough permission!</div>';
        
    }
?>
    <form action="" method="POST">
		<p style="text-align: center;">
			<label for="user" style="font-size: 12pt; font-family: 'courier new', courier, monospace; color: #33cc33; font-weight: bold; ">username</label><br />
			<input name="user" type="text" required /><br />
			<label for="pw" style="font-size: 12pt; font-family: 'courier new', courier, monospace; color: #33cc33; font-weight: bold;">password</label><br />
    		<input name="pw" type="password" required />
			<br /><br />
    		<input name="ok" type="submit" value="Invia" />
    	</p>
	</form>
</div>
</body>
</html>