<?php
// assegno admin a login
$login['1'] = $_POST['ok'];
$login['a'] = $_COOKIE['administrator'];
setcookie(administrator, 1, time() - 3800);
if(!isset($login['l'])) {
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="theme-color" content="#53e300">
  <meta name="Author" content="Marko"/>
  <title>Student Admin: Acesso</title>
  <style src="style/style.css" />
</head>
<body>
<div align="center">
<p style="text-align: center;"><span style="font-size: 18pt; font-family: terminal, monaco, monospace; color: #339966;"><em><strong>Accesso</strong></em></span></p>
<form action="" method="POST">
<p style="text-align: center;"><span style="color: #99cc00;"><strong><span style="font-family: 'courier new', courier, monospace; font-size: 12pt;">username</span></strong></span><br /><input name="user" type="text" require="true"/></p>
<p><span style="color: #99cc00;"><strong><span style="font-size: 12pt; font-family: 'courier new', courier, monospace;">password</span></strong></span><br /><input name="pw" type="password" require="true"/></p>
<p><input name="ok" type="submit" value="Invia" /></p>
</form></div>
</body>
</html>
<?
 $utente = 'studentoa';
 $chiave = 'adminpw';
} else {
if($_POST['user'] == $utente && $_POST['pw'] == $chiave) {
   setcookie(admin, 1, time() + 379);
   setcookie(administrator, 1, time() + 3790); 
   
   //add user setting
   
} else {
   errore();
};
};
?>