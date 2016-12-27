<?php
// This page shows lastly added 11 publication
//it either shows articles or news according to user's choice
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
		
		$res=mysql_query("SELECT * FROM editor");
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
			?>
			<script>alert('home a bastýn ');</script>
			<?php
			if($type == 'normaluser'){
				header("Location: registeredUserHomePage.php");
				exit;
			}
			else if($type == 'editor'){
				header("Location: uploadNews.php");
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
	if(isset($_POST['categoriesButton'])){
		
		header("Location: categoriesPage.php");
		exit;
		
	}
	if(isset($_POST['logoutButton'])){
		header("Location: logout.php?logout");
		exit;
	}
	
	
	$categoryType = $_SESSION['categoryTypeForArticle'];	
		if($categoryType == 'politics'){
			
			$articleList = mysql_query("	SELECT title,publication.date, publication.pubID
										FROM article,publication,category
										WHERE article.pubID = publication.pubID AND
										category.categoryID = publication.categoryID AND
										category.categoryName= 'politics' AND
										article.isVisible = 1
										ORDER BY publication.date DESC
										LIMIT 11
							");
			var_dump($articleList);
		
			$articlesArray = array();
			$index = 0;
			while($rows=mysql_fetch_array($articleList)){
				$articlesArray[$index] = $rows;
				$index++;
			}	
			
		}
		if($categoryType == 'health'){
			
			$articleList = mysql_query("	SELECT title,publication.date, publication.pubID
										FROM article,publication,category
										WHERE article.pubID = publication.pubID AND
										category.categoryID = publication.categoryID AND
										article.isVisible = 1 AND
										category.categoryName= 'health'
										ORDER BY publication.date DESC
										LIMIT 11
							");
			var_dump($articleList);
		
			$articlesArray = array();
			$index = 0;
			while($rows=mysql_fetch_array($articleList)){
				$articlesArray[$index] = $rows;
				$index++;
			}	
			
		}
		if($categoryType == 'fashion'){
			$articleList = mysql_query("	SELECT title,publication.date, publication.pubID
										FROM article,publication,category
										WHERE article.pubID = publication.pubID AND
										category.categoryID = publication.categoryID AND
										article.isVisible = 1 AND
										category.categoryName= 'fashion'
										ORDER BY publication.date DESC
										LIMIT 11
							");
			var_dump($articleList);
		
			$articlesArray = array();
			$index = 0;
			while($rows=mysql_fetch_array($articleList)){
				$articlesArray[$index] = $rows;
				$index++;
			}	
			
			
		}
		if($categoryType == 'technology'){
			$articleList = mysql_query("	SELECT title,publication.date, publication.pubID
										FROM article,publication,category
										WHERE article.pubID = publication.pubID AND
										category.categoryID = publication.categoryID AND
										article.isVisible = 1 AND
										category.categoryName= 'technology'
										ORDER BY publication.date DESC
										LIMIT 11
							");
			var_dump($articleList);
		
			$articlesArray = array();
			$index = 0;
			while($rows=mysql_fetch_array($articleList)){
				$articlesArray[$index] = $rows;
				$index++;
			}	
			
			
		}
		if($categoryType == 'business'){
			$articleList = mysql_query("	SELECT title,publication.date, publication.pubID
										FROM article,publication,category
										WHERE article.pubID = publication.pubID AND
										category.categoryID = publication.categoryID AND
										article.isVisible = 1 AND
										category.categoryName= 'business'
										ORDER BY publication.date DESC
										LIMIT 11
							");
			var_dump($articleList);
		
			$articlesArray = array();
			$index = 0;
			while($rows=mysql_fetch_array($articleList)){
				$articlesArray[$index] = $rows;
				$index++;
			}	
			
			
		}
		if($categoryType == 'sports'){
			$articleList = mysql_query("	SELECT title,publication.date, publication.pubID
										FROM article,publication,category
										WHERE article.pubID = publication.pubID AND
										category.categoryID = publication.categoryID AND
										article.isVisible = 1 AND
										category.categoryName= 'sports'
										ORDER BY publication.date DESC
										LIMIT 11
							");
			var_dump($articleList);
		
			$articlesArray = array();
			$index = 0;
			while($rows=mysql_fetch_array($articleList)){
				$articlesArray[$index] = $rows;
				$index++;
			}	
			
			
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
  	<input type="submit" name="button" id="button" value="Sign Out" >
    <p><?php echo $userRow['username']; ?></p> 
</div>
  <div><img src="photo/logo.png" width="720" height="134" alt=""/></div>
<section class="sidebar"  align="right">
    <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
    <div class="row">
	
      <div class="col-md-2" align="center">
		<!--//not: butonlarýn baslarýna ve en sonuna bu form satýrýný koymayýnca lýstener calýsmýyodu
		//ayrýca type :submit onemli-->
		<form method="post">
        <button type="submit" name="homeButton"  class="btn btn-info">Home</button>
		
      </div>
      <div class="col-md-2" align="center">
        <button type="submit" name= "generalNewsButton" class="btn btn-info">News</button>
      </div>
      <div class="col-md-1">
        <button type="submit" name= "videoListButton" class="btn btn-info">Videos</button>
      </div>
      <div class="col-md-offset-0 col-md-3">
        <button type="submit" name= "categoriesButton" class="btn btn-info">Categories</button>
      </div>
      <div class="col-md-offset-0 col-md-2">
        <button type="submit" name= "authorListButton" class="btn btn-info">Authors</button>
		</form>
      </div>
      <div class="col-md-1"></div>
      <div class="col-md-1"></div>
      <div class="col-md-1"></div>
    </div>
    <div>
<div class="row">
       
</div>
</section>
  <div>

<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articlesArray[0][0])) $title = $articlesArray[0][0]; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[0][2])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articlesArray[0][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[0][2])&&$type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articlesArray[0][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articlesArray[0][1]))  echo $articlesArray[0][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articlesArray[1][0])) $title = $articlesArray[1][0]; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[1][2])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articlesArray[1][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[1][2])&&$type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articlesArray[1][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articlesArray[1][1]))  echo $articlesArray[1][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articlesArray[2][0])) $title = $articlesArray[2][0]; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[2][2])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articlesArray[1][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[2][2])&&$type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articlesArray[2][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articlesArray[2][1]))  echo $articlesArray[1][1]; ?> </p></font></p>
</div>

<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articlesArray[3][0])) $title = $articlesArray[3][0]; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[3][2])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articlesArray[3][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[3][2])&&$type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articlesArray[3][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articlesArray[3][1]))  echo $articlesArray[3][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articlesArray[4][0])) $title = $articlesArray[4][0]; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[4][2])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articlesArray[4][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[4][2])&&$type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articlesArray[4][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articlesArray[4][1]))  echo $articlesArray[4][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articlesArray[0][0])) $title = $articlesArray[5][0]; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[5][2])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articlesArray[5][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[5][2])&&$type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articlesArray[5][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articlesArray[5][1]))  echo $articlesArray[5][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articlesArray[6][0])) $title = $articlesArray[6][0]; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[6][2])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articlesArray[6][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[6][2])&&$type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articlesArray[6][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articlesArray[6][1]))  echo $articlesArray[6][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articlesArray[7][0])) $title = $articlesArray[7][0]; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[7][2])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articlesArray[7][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[7][2])&&$type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articlesArray[7][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articlesArray[7][1]))  echo $articlesArray[7][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articlesArray[8][0])) $title = $articlesArray[8][0]; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[8][2])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articlesArray[8][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[8][2])&&$type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articlesArray[8][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articlesArray[8][1]))  echo $articlesArray[8][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articlesArray[9][0])) $title = $articlesArray[9][0]; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[9][2])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articlesArray[9][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[9][2])&&$type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articlesArray[9][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articlesArray[9][1]))  echo $articlesArray[9][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articlesArray[10][0])) $title = $articlesArray[10][0]; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[10][2])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articlesArray[10][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articlesArray[10][2])&&$type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articlesArray[10][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articlesArray[10][1]))  echo $articlesArray[10][1]; ?> </p></font></p>
</div>
  </div>
  <div id="content"> </div>
</div>
</body>
</html>