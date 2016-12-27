<?php
// This page shows lastly added 5 news within a search of user by searching for typed label
session_start();
include_once 'dbconnect.php';
	$type = '';	
	$userID =$_SESSION['user'];
	
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
		echo"Article list for normal users";
		$type = 'normaluser';
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
			$res=mysql_query("SELECT * FROM user,author 
						WHERE user.userID = author.userID AND user.userID = '$userID' ");
			$userRow = mysql_fetch_array($res);
			if($userRow['userID'] == $_SESSION['user'] ){
				echo"Article list for author";
				$type = 'author';
			}
			else{
				header("Location: index.php");
				exit;
			}
			
		}		
	}
	
	if(isset($_POST['homebutton'])){
			?>
			<script>alert('home a bast�n ');</script>
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
		
		header("Location: generalNewsList.php");
		exit;
		
	}
	if(isset($_POST['videoListButton'])){
		
		header("Location: videoList.php");
		exit;
		
	}
	if(isset($_POST['categoryButton'])){
		
		header("Location: categoriesPage.php");
		exit;
		
	}
	if(isset($_POST['logoutButton'])){
		header("Location: logout.php?logout");
		exit;
	}

	if(isset($_SESSION['labelTextForArticle'])){
		$labelToSearch = $_SESSION['labelTextForArticle'];
		$articleList = mysql_query("SELECT publication.title, publication.pubID , publication.date
							 FROM article,publication,label,has_label
							 WHERE article.pubID = publication.pubID AND
									publication.pubID = has_label.pubID AND
									label.labelID = has_label.labelID  AND
									article.isVisible = 1 AND
									label.text LIKE '$labelToSearch'
							ORDER BY publication.date DESC
							LIMIT 6
							");
		var_dump($articleList);
		
		$articleArray = array();
		$index = 0;
		while($rows=mysql_fetch_array($articleList)){
			$articleArray[$index] = $rows;
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
	<form method="post">
  	<input type="submit" name="logoutButton" id="button" value="Sign Out" >
    <p><?php if($type == 'editor' ){ echo 'editorReiz';}
			  else if($type == 'author') {echo $userRow['username'];}
			  else if ($type == 'normaluser') {echo $userRow['username'];}
			
			?></p> 
</div>
  <div><img src="photo/logo.png" width="720" height="134" alt=""/></div>
<section class="sidebar"  align="right">
    <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
    <div class="row">
	
      <div class="col-md-2" align="center">
		 <!--not: butonlar�n baslar�na ve en sonuna bu form sat�r�n� koymay�nca l�stener cal�sm�yodu
		//ayr�ca type :submit -->
		<form method="post">
        <button type="submit" name="homebutton"  method= "post" class="btn btn-info">Home</button>
		
      </div>
      <div class="col-md-2" align="center">
        <button type="submit" name = "generalNewsButton" class="btn btn-info">News</button>
      </div>
      <div class="col-md-1">
        <button type="submit" name = "videoListButton" class="btn btn-info">Videos</button>
      </div>
      <div class="col-md-offset-0 col-md-3">
        <button type="submit" name ="categoryButton" class="btn btn-info">Categories</button>
      </div>
      <div class="col-md-offset-0 col-md-2">
        <button type="submit" class="btn btn-info">Authors</button>
		</form>
      </div>
      <div class="col-md-1"></div>
      <div class="col-md-1"></div>
      <div class="col-md-1"></div>
    </div>
    <div>
<div class="row">
		<form method="post">
       
	   </div>
   	  </div>
	  </form>
</div>
</section>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articleArray[0][0])) $title = $articleArray[0][0]; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[0][2])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articleArray[0][1],">$title </a>"; ?>
   <p ><font size="6"><p><?php if(isset($articleArray[0][1])&& $type =='editor') echo "<a href= viewArticleForEditor.php?pubID=",$articleArray[0][1],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articleArray[0][2]))  echo $articleArray[0][2]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articleArray[1][0])) $title = $articleArray[1][0]; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[1][1])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articleArray[1][1],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[1][1])&& $type =='editor') echo "<a href= viewArticleForEditor.php?pubID=",$articleArray[1][1],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articleArray[1][2]))  echo $articleArray[1][2]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articleArray[2][0])) $title = $articleArray[2][0]; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[2][1])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articleArray[2][1],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[2][1])&& $type =='editor') echo "<a href= viewArticleForEditor.php?pubID=",$articleArray[2][1],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articleArray[2][2]))  echo $articleArray[2][2]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articleArray[3][0])) $title = $articleArray[3][0]; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[3][1])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articleArray[3][1],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[3][1])&& $type =='editor') echo "<a href= viewArticleForEditor.php?pubID=",$articleArray[3][1],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articleArray[3][2]))  echo $articleArray[3][2]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php if(isset($articleArray[4][0])) $title = $articleArray[4][0]; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[4][1])&&($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articleArray[4][1],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[4][1])&& $type =='editor') echo "<a href= viewArticleForEditor.php?pubID=",$articleArray[4][1],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($articleArray[4][2]))  echo $articleArray[4][2]; ?> </p></font></p>
</div>
  </div>
  <div id="content"> </div>
</div>
</body>
</html>
