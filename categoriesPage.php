<?php
// shows all the categories
session_start();
include_once 'dbconnect.php';
	$type = '';
	
	$userID =	$_SESSION['user'];
	//if session variable user is not set, then go to login page
	if(!isset($_SESSION['user'])){	
		header("Location: index.php");
		exit;
	}	
	
	// check if it is really registered user who is visiting the page
    //if not, return to login page
	$res=mysql_query("SELECT * FROM user,registered_user 
						WHERE user.userID = registered_user.userID AND user.userID = '$userID' ");
	$userRow = mysql_fetch_array($res);
	
	
	if($userRow['userID'] == $_SESSION['user'] ){
		echo"news list for normal users";
		$type = 'normaluser';
	}
		
	else{
		
		$res=mysql_query("SELECT * FROM editor,user
							WHERE editor.userID = user.userID");
		$userRow = mysql_fetch_array($res);
		if($userRow['userID'] == $_SESSION['user'] ){
			echo"home page for editor";
			$type = 'editor';
		}
		else{
			
			
			$res=mysql_query("SELECT * FROM user,author 
						WHERE user.userID = author.userID AND user.userID = '$userID' ");
			$userRow = mysql_fetch_array($res);
			if($userRow['userID'] == $_SESSION['user'] ){
				echo"news list for author";
				$type = 'author';
			}
			else{
				header("Location: index.php");
				exit;
			}
			
		}
		
	}
	if(isset($_POST['homeButton'])){
		
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
	if(isset($_POST['authorListButton'])){
		header("Location: authorList.php");
		exit;
	}
	
	if(isset($_POST['logoutButton'])){
		header("Location: logout.php?logout");
		exit;
	}
	if(isset($_POST['videoListButton'])){
		
		header("Location: videoList.php");
		exit;
	}
	
	//unset($_SESSION['categoryType']);
	
	//button listeners for news categories
	if(isset($_POST['newsForPoliticsButton'])){

		$_SESSION['categoryType'] = "politics";
		header("Location: viewNewsListByCategory.php");
		exit;
	}
	else if(isset($_POST['newsForHealthButton'])){
		$_SESSION['categoryType'] = "health";
		header("Location: viewNewsListByCategory.php");
		exit;
	}
	else if(isset($_POST['newsForFashionButton'])){
		$_SESSION['categoryType'] = "fashion";
		header("Location: viewNewsListByCategory.php");
		exit;
	}
	else if(isset($_POST['newsForTechnologyButton'])){
		$_SESSION['categoryType'] = "technology";
		header("Location: viewNewsListByCategory.php");
		exit;
	}
	else if(isset($_POST['newsForBusinessButton'])){
		
		$_SESSION['categoryType'] = "business";
		header("Location: viewNewsListByCategory.php");
		exit;
	}
	else if(isset($_POST['newsForSportsButton'])){
		
		$_SESSION['categoryType'] = "sports";
		header("Location: viewNewsListByCategory.php");
		exit;
	}
	
	
	//button listeners for article categories
	else if(isset($_POST['articlesForPoliticsButton'])){
		$_SESSION['categoryTypeForArticle'] = "politics";
		header("Location: viewArticleListByCategory.php");
		exit;
	}
	else if(isset($_POST['articlesForHealthButton'])){
		$_SESSION['categoryTypeForArticle'] = "health";
		header("Location: viewArticleListByCategory.php");
		exit;
	}
	else if(isset($_POST['articlesForFashionButton'])){
		$_SESSION['categoryTypeForArticle'] = "fashion";
		header("Location: viewArticleListByCategory.php");
		exit;
	}
	else if(isset($_POST['articlesForTechnologyButton'])){
		$_SESSION['categoryTypeForArticle'] = "technology";
		header("Location: viewArticleListByCategory.php");
		exit;
	}
	else if(isset($_POST['articlesForBusinessButton'])){
		$_SESSION['categoryTypeForArticle'] = "business";
		header("Location: viewArticleListByCategory.php");
		exit;
	}
	else if(isset($_POST['articlesForSportsButton'])){
		$_SESSION['categoryTypeForArticle'] = "sports";
		header("Location: viewArticleListByCategory.php");
		exit;
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
<link href="css/bootstrap5.css" rel="stylesheet" type="text/css">
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
<div></div>
<div id="mainWrapper">
  <header>
<!-- This is the header content. It contains Logo and links -->  </header>
  
  <form method="post">
  <div id="logout" align="right"> </div>

  <div id="logout" align="right">
    <input type="submit" name="logoutButton" id="button" value="LOG OUT" >
   </form>
  </div>
</div>
<div align="right"><p><?php echo $userRow['username']; ?> </p> </div>
  <div><img src="photo/logo5.png" width="900" height="163" alt=""/></div>
<section class="sidebar"  align="right">
    <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
    <div class="row">
	<form method="post">
      <div class="col-md-1" align="center">
        <button type="submit" name= "homeButton" class="btn btn-info">&nbsp;HOME</button>
      </div>
      <div class="col-md-1 col-md-offset-0" align="center">
        <button type="submit" name= "generalNewsButton" class="btn btn-info">NEWS</button>
      </div>
      <div class="col-md-offset-0 col-md-1">
        <button type="submit" name= "videoListButton" class="btn btn-info">VIDEOS</button>
      </div>
      <div class="col-md-offset-0 col-md-1">
        <button type="submit" name= "categoriesButton" class="btn btn-info">CATEGORIES</button>
      </div>
      <div class="col-md-offset-1 col-md-1">
        <button type="submit" name= "authorListButton" class="btn btn-info">AUTHORS</button>
      </div>
      </form>
</div>

</section>
</div>

<div>&nbsp;</div>

<div><h1>NEWS</h1></div>

<div class="row">
	<form method="post">
      <div class="col-md-2" align="center">
        <input type="submit" name="newsForPoliticsButton" id="button1" value="POLITICS" >
      </div>
      <div class="col-md-2" align="center">
        <input type="submit" name="newsForHealthButton" id="button2" value="HEALTH" >
      </div>
      <div class="col-md-2" align="center">
        <input type="submit" name="newsForFashionButton" id="button3" value="FASHION" >
      </div>
      <div class="col-md-2" align="center">
        <input type="submit" name="newsForTechnologyButton" id="button4" value="TECHNOLOGY" >
      </div>
      <div class="col-md-2" align="center">
        <input type="submit" name="newsForBusinessButton" id="button5" value="BUSINESS" >
      </div>
      <div class="col-md-2" align="center">
        <input type="submit" name="newsForSportsButton" id="button6" value="SPORTS" >
      </div>
	</form>
</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>

<div><h1>ARTICLES</h1></div>

<div class="row">
	<form method="post">
      <div class="col-md-2" align="center">
        <input type="submit" name="articlesForPoliticsButton" id="button7" value="POLITICS" >
      </div>
      <div class="col-md-2" align="center">
        <input type="submit" name="articlesForHealthButton" id="button8" value="HEALTH" >
      </div>
      <div class="col-md-2" align="center">
        <input type="submit" name="articlesForFashionButton" id="button9" value="FASHION" >
      </div>
      <div class="col-md-2" align="center">
        <input type="submit" name="articlesForTechnologyButton" id="button10" value="TECHNOLOGY" >
      </div>
      <div class="col-md-2" align="center">
        <input type="submit" name="articlesForBusinessButton" id="button11" value="BUSINESS" >
      </div>
      <div class="col-md-2" align="center">
        <input type="submit" name="articlesForSportsButton" id="button12" value="SPORTS" >
      </div>
	</form>
</div>

