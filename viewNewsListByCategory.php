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
	//var_dump($_SESSION['categoryType']);
	
	
	if($_SESSION['categoryType'] == 'politics'){
			
			$newsList = mysql_query("	SELECT publication.title, news.subtitle, publication.pubID , publication.date
										FROM news,publication,category
										WHERE news.pubID = publication.pubID AND
										category.categoryID = publication.categoryID AND
										category.categoryName= 'politics'
										ORDER BY publication.date DESC
										LIMIT 11
							");
			var_dump($newsList);
		
			$newsArray = array();
			$index = 0;
			while($rows=mysql_fetch_array($newsList)){
				$newsArray[$index] = $rows;
				$index++;
			}
			
	}
	
	  if($_SESSION['categoryType'] == 'health'){
			
			$newsList = mysql_query("	SELECT publication.title, news.subtitle, publication.pubID , publication.date
										FROM news,publication,category
										WHERE news.pubID = publication.pubID AND
										category.categoryID = publication.categoryID AND
										category.categoryName= 'health'
										ORDER BY publication.date DESC
										LIMIT 11
							");
			var_dump($newsList);
		
			$newsArray = array();
			$index = 0;
			while($rows=mysql_fetch_array($newsList)){
				$newsArray[$index] = $rows;
				$index++;
			}
			
		}
	 else if($_SESSION['categoryType'] == 'fashion'){
			
			$newsList = mysql_query("	SELECT publication.title, news.subtitle, publication.pubID , publication.date
										FROM news,publication,category
										WHERE news.pubID = publication.pubID AND
										category.categoryID = publication.categoryID AND
										category.categoryName= 'fashion'
										ORDER BY publication.date DESC
										LIMIT 11
							");
			var_dump($newsList);
		
			$newsArray = array();
			$index = 0;
			while($rows=mysql_fetch_array($newsList)){
				$newsArray[$index] = $rows;
				$index++;
			}
			
		}
	 else if($_SESSION['categoryType'] == 'technology'){
			$newsList = mysql_query("	SELECT publication.title, news.subtitle, publication.pubID , publication.date
										FROM news,publication,category
										WHERE news.pubID = publication.pubID AND
										category.categoryID = publication.categoryID AND
										category.categoryName= 'technology'
										ORDER BY publication.date DESC
										LIMIT 11
							");
			var_dump($newsList);
		
			$newsArray = array();
			$index = 0;
			while($rows=mysql_fetch_array($newsList)){
				$newsArray[$index] = $rows;
				$index++;
			}
			
			
		}
	else if($_SESSION['categoryType'] == 'business'){
			
			$newsList = mysql_query("	SELECT publication.title, news.subtitle, publication.pubID , publication.date
										FROM news,publication,category
										WHERE news.pubID = publication.pubID AND
										category.categoryID = publication.categoryID AND
										category.categoryName= 'business'
										ORDER BY publication.date DESC
										LIMIT 11
							");
			var_dump($newsList);
		
			$newsArray = array();
			$index = 0;
			while($rows=mysql_fetch_array($newsList)){
				$newsArray[$index] = $rows;
				$index++;
			}
			
		}
	 else if($_SESSION['categoryType'] == 'sports'){
			
			$newsList = mysql_query("	SELECT publication.title, news.subtitle, publication.pubID , publication.date
										FROM news,publication,category
										WHERE news.pubID = publication.pubID AND
										category.categoryID = publication.categoryID AND
										category.categoryName= 'sports'
										ORDER BY date DESC
										LIMIT 10
										");
			var_dump($newsList);
		
			$newsArray = array();
			$index = 0;
			while($rows=mysql_fetch_array($newsList)){
				$newsArray[$index] = $rows;
				$index++;
			}		
		}
	if(isset($_POST['homeButton'])){
			?>
			<script>alert('home a bast�n ');</script>
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
    <p><?php echo $userRow['username']; ?></p> 
</div>
</form>
  <div><img src="photo/logo.png" width="720" height="134" alt=""/></div>
<section class="sidebar"  align="right">
    <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
    <div class="row">
	
      <div class="col-md-2" align="center">
		<!--//not: butonlar�n baslar�na ve en sonuna bu form sat�r�n� koymay�nca l�stener cal�sm�yodu
		//ayr�ca type :submit onemli-->
		<form method="post">
        <button type="submit" name="homeButton"   class="btn btn-info">Home</button>
		
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

</section>

  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($newsArray[0][0])) $title = $newsArray[0][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[0][2]) && ($type =='normaluser' || $type == 'author')) echo "<a href= viewNews.php?pubID=",$newsArray[0][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[0][2]) && $type =='editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[0][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[0][1]))  echo $newsArray[0][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($newsArray[1][0])) $title = $newsArray[1][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[1][2])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewNews.php?pubID=",$newsArray[1][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[1][2])&& $type == 'editor') echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[1][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[1][1]))  echo $newsArray[1][1]; ?> </p></font></p>
</div>

<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($newsArray[2][0])) $title = $newsArray[2][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[2][2])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewNews.php?pubID=",$newsArray[3][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[2][2])&& $type == 'editor') echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[2][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[2][1]))  echo $newsArray[2][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($newsArray[3][0])) $title = $newsArray[3][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[3][2])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewNews.php?pubID=",$newsArray[3][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[3][2])&& $type == 'editor') echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[3][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[3][1]))  echo $newsArray[3][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($newsArray[4][0])) $title = $newsArray[4][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[4][2])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewNews.php?pubID=",$newsArray[4][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[4][2])&& $type == 'editor') echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[4][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[4][1]))  echo $newsArray[4][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($newsArray[5][0])) $title = $newsArray[5][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[5][2])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewNews.php?pubID=",$newsArray[5][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[5][2])&& $type == 'editor') echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[5][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[5][1]))  echo $newsArray[5][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($newsArray[6][0])) $title = $newsArray[6][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[6][2])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewNews.php?pubID=",$newsArray[6][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[6][2])&& $type == 'editor') echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[6][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[6][1]))  echo $newsArray[6][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($newsArray[7][0])) $title = $newsArray[7][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[7][2])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewNews.php?pubID=",$newsArray[7][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[7][2])&& $type == 'editor') echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[7][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[7][1]))  echo $newsArray[7][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($newsArray[8][0])) $title = $newsArray[8][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[8][2])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewNews.php?pubID=",$newsArray[8][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[8][2])&& $type == 'editor') echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[8][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[8][1]))  echo $newsArray[8][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($newsArray[9][0])) $title = $newsArray[9][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[9][2])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewNews.php?pubID=",$newsArray[9][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[9][2])&& $type == 'editor') echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[9][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[9][1]))  echo $newsArray[9][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($newsArray[10][0])) $title = $newsArray[10][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[10][2])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewNews.php?pubID=",$newsArray[10][2],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[10][2])&& $type == 'editor') echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[10][2],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[10][1]))  echo $newsArray[10][1]; ?> </p></font></p>
</div>
  </div>
  <div id="content"> </div>
</div>
</body>
</html>
