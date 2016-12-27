<?php
session_start();
include_once 'dbconnect.php';
	$type = '';
	$userID =	$_SESSION['user'];
	
	// check if it is really registered user who is visiting the page
    //if not, return to login page
	$res=mysql_query("SELECT * FROM user,author 
						WHERE user.userID = author.userID AND user.userID = '$userID' ");
	$userRow = mysql_fetch_array($res);	
	//if session variable user is not set, then go to login page
	if(!isset($_SESSION['user'])){	
		header("Location: index.php");
		exit;
	}
	
		
	else{		
		$res=mysql_query("SELECT * FROM editor");
		$userRow = mysql_fetch_array($res);
		if($userRow['userID'] == $_SESSION['user'] ){
			echo"home page for editor";
			$type = 'editor';
			$query=mysql_query("SELECT * FROM user,editor 
						WHERE user.userID = editor.userID AND user.userID = '$userID' ");
			$userRow = mysql_fetch_array($query);
		}
		else{	
			$res=mysql_query("SELECT * FROM user,registered_user 
						WHERE user.userID = registered_user.userID AND user.userID = '$userID' ");
				$userRow = mysql_fetch_array($res);
				
				if($userRow['userID'] == $_SESSION['user'] ){
					echo"home page for normal users";
					$type = "normaluser";
				}
	
				else{
					$res=mysql_query("SELECT * FROM user,author 
						WHERE user.userID = author.userID AND user.userID = '$userID' ");
					$userRow = mysql_fetch_array($res);
					if($userRow['userID'] == $_SESSION['user'] ){
						echo"author list for author";
						$type = 'author';
					}
					else{
						header("Location: index.php");
						exit;
					}
			}
		}		
	}
	
	if(isset($_POST['homeButton'])){
			?>
			<script>alert('home a bastın ');</script>
			<?php
			if($type == 'normaluser'){
				header("Location: registeredUserHomePage.php");
				exit;
			}
			else if($type == 'editor'){
				header("Location: editorHomePage.php");
				exit;
			}
			else if($type == 'author'){
				header("Location: authorHomePage.php");
				exit;
			}
			else{// that means something is wrong
				header("Location: index.php");
				exit;
			}		
	}
	if(isset($_POST['generalNewsButton'])){
		
		header("Location: generalnewsList.php");
		exit;
		
	}
	if(isset($_POST['videoListButton'])){
		
		header("Location: videoList.php");
		exit;
		
	}
	if(isset($_POST['categoriesButton'])){
		
		header("Location: categoriesPage.php");
		exit;
		
	}
	if(isset($_POST['logoutButton'])){
		header("Location: logout.php?logout");
		exit;
	}
		if(isset($_POST['authorListButton'])){
		header("Location: authorList.php");
		exit;
	}
	
	$authorList = mysql_query("SELECT user.username, user.userID
								FROM user,author
								WHERE author.userID = user.userID
								LIMIT 10
							");
	var_dump($authorList);
		
	$authorArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($authorList)){
		$authorArray[$index] = $rows;
		$index++;
	}	
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>eCommerce template By Adobe Dreamweaver CC</title>
<link href="eCommerceAssets/styles/eCommerceStyle.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/montserrat:n4:default;source-sans-pro:n2:default.js" type="text/javascript"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
<div id="mainWrapper">
  <header> 
    <!-- This is the header content. It contains Logo and links -->  </header>
  <div id="logout" align="right">
	<form method="post">
  	<input type="submit" name="logoutButton" id="button" value="Sign Out" >
    <p><?php if($type == 'editor' ){ echo $userRow['username'];}
			  else if($type == 'author') {echo $userRow['username'];}
			  else if ($type == 'normaluser') {echo $userRow['username'];}
			
			?></p> 
</div>
  <div><img src="photo/logo.png" width="720" height="134" alt=""/></div>
<section class="sidebar"  align="right">
    <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
    <div class="row">
	<form method="post">
      <div class="col-md-2" align="center">
		 <!--not: butonların baslarına ve en sonuna bu form satırını koymayınca lıstener calısmıyodu
		//ayrıca type :submit -->
		
        <button type="submit" name="homeButton"  class="btn btn-info">Home</button>
		
      </div>
      <div class="col-md-2" align="center">
        <button type="submit" name= "generalNewsbutton" class="btn btn-info">News</button>
      </div>
      <div class="col-md-1">
        <button type="submit" name= "videoListButton" class="btn btn-info">Videos</button>
      </div>
      <div class="col-md-offset-0 col-md-3">
        <button type="submit" name= "categoriesButton" class="btn btn-info">Categories</button>
      </div>
      <div class="col-md-offset-0 col-md-2">
        <button type="submit" name= "authorListButton" class="btn btn-info">Authors</button>
      </div>
      <div class="col-md-1"></div>
      <div class="col-md-1"></div>
      <div class="col-md-1"></div>
	  </form>
    </div>
    <div>
<div class="row">
		
</div>
</section>

<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <?php if(isset($authorArray[0][1])) $authorName = $authorArray[0][0]; ?>
  <p ><font size="6"><p><?php if(isset($authorArray[0][1])) echo "<a href= viewAuthorProfile.php?userID=",$authorArray[0][1],">$authorName </a>"; ?>
</div>

<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <?php if(isset($authorArray[1][1])) $authorName = $authorArray[1][0]; ?>
  <p ><font size="6"><p><?php if(isset($authorArray[1][1])) echo "<a href= viewAuthorProfile.php?userID=",$authorArray[1][1],">$authorName </a>"; ?>
</div>

<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <?php if(isset($authorArray[2][1])) $authorName = $authorArray[2][0]; ?>
  <p ><font size="6"><p><?php if(isset($authorArray[2][1])) echo "<a href= viewAuthorProfile.php?userID=",$authorArray[2][1],">$authorName </a>"; ?>
</div>

<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <?php if(isset($authorArray[3][1])) $authorName = $authorArray[3][0]; ?>
  <p ><font size="6"><p><?php if(isset($authorArray[3][1])) echo "<a href= viewAuthorProfile.php?userID=",$authorArray[3][1],">$authorName </a>"; ?>
</div>

<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <?php if(isset($authorArray[4][1])) $authorName = $authorArray[4][0]; ?>
  <p ><font size="6"><p><?php if(isset($authorArray[4][1])) echo "<a href= viewAuthorProfile.php?userID=",$authorArray[4][1],">$authorName </a>"; ?>
</div>

<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <?php if(isset($authorArray[5][1])) $authorName = $authorArray[5][0]; ?>
  <p ><font size="6"><p><?php if(isset($authorArray[5][1])) echo "<a href= viewAuthorProfile.php?userID=",$authorArray[5][1],">$authorName </a>"; ?>
</div>


<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  </div>
  <div id="content"> </div>
</div>
</body>
</html>
