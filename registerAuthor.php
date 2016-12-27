<?php

session_start();
if(isset($_SESSION['user']))
{
	unset($_SESSION['user']);
	//header("Location: index.php");
}
include_once 'dbconnect.php';
echo "<br/>";
echo "			Register as Author in this page\n";
echo "<br/>";


echo "<br/>";
if(isset($_POST['btn-signup']))
{
 $uname = mysql_real_escape_string($_POST['uname']);
 $upass = md5(mysql_real_escape_string($_POST['pass']));
 
 if(mysql_query(" 	INSERT INTO user(username,password) VALUES('$uname', '$upass');  ") )
 {
  ?>
        <script>alert('successfully registered ');</script>
        <?php
		$lastID = mysql_insert_id();
		mysql_query("INSERT INTO author(userID,publishCount,rate) VALUES ( $lastID, 0, 0);");	
		header("Location: index.php");
		exit;
 }
 else
 {
  ?>
        <script>alert('error while registering you...');</script>
        <?php
 }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login & Registration System</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />

</head>
<body>
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="uname" placeholder="User Name" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-signup">Register As Author</button></td>
</tr>
<tr>
<td><a href="index.php">Sign In Here</a></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>