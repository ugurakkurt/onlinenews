<?php
session_start();
//delete all existing session data if any exists
session_unset();
include_once 'dbconnect.php';

if(isset($_POST['btn-login']))
{
	$uName = mysql_real_escape_string($_POST['uName']);
    $pass = mysql_real_escape_string($_POST['pass']);
 
    // check if it is normal user who is logging in
    $res=mysql_query("SELECT * FROM user,registered_user 
				  WHERE user.userID = registered_user.userID AND user.username ='$uName' ");
    $row=mysql_fetch_array($res);
    if($row['password']==md5($pass))
    {
        $_SESSION['user'] = $row['userID'];
		header("Location: registeredUserHomePage.php");
		exit;
    }
	
	
	else{
		//check if it is author
		$ress=mysql_query("SELECT * FROM user,author
				  WHERE user.userID = author.userID AND user.username ='$uName' ");
		$roww=mysql_fetch_array($ress);
		if($roww['password']==md5($pass))
		{
			$_SESSION['user'] = $roww['userID'];
			header("Location: authorHomePage.php");
			exit;
		}
		else{
 
			//check if it is editor
			$resss=mysql_query("SELECT * FROM user,editor
				  WHERE user.userID = editor.userID AND user.username ='$uName'");
			$rowww=mysql_fetch_array($resss);
 
 
			if($rowww['password']==($pass))
			{
				$_SESSION['user'] = $rowww['userID'];
				// uploadNews is home page for editor
				header("Location: editorHomePage.php");
				exit;
			}	
			else
			{
				?>
				<script>alert('wrong details');</script>
				<?php
			}
		}
	}
	
 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>cleartuts - Login & Registration System</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="uName" placeholder="Your username" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-login">Sign In</button></td>
</tr>
<tr>
<td><a href="register.php">Sign Up Here</a></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>