<?php
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
			$query=mysql_query("SELECT * FROM user,editor 
						WHERE user.userID = editor.userID AND user.userID = '$userID' ");
			$userRow = mysql_fetch_array($query);
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
	if(isset($_POST['authorListButton'])){
		
		header("Location: authorList.php");
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
	

	
	$newsList = mysql_query("SELECT publication.title, news.subtitle, publication.date, publication.pubID
							 FROM news,publication
							 WHERE news.pubID = publication.pubID 
							ORDER BY publication.date DESC
							LIMIT 20
							");
	//var_dump($newsList);
		
	$newsArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($newsList)){
		$newsArray[$index] = $rows;
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
	
      <div class="col-md-2" align="center">
		 <!--not: butonlarýn baslarýna ve en sonuna bu form satýrýný koymayýnca lýstener calýsmýyodu
		//ayrýca type :submit -->
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
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <?php if(isset($newsArray[0][0])) $title = $newsArray[0][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[0][3]) && ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[0][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[0][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[0][3],">$title </a>"; ?>
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
  <p ><font size="6"><p><?php if(isset($newsArray[1][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[1][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[1][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[1][3],">$title </a>"; ?>
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
  <p ><font size="6"><p><?php if(isset($newsArray[2][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[2][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[2][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[2][3],">$title </a>"; ?>
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
  <p ><font size="6"><p><?php if(isset($newsArray[3][3])&& ($type =='normaluser' || $type =='author') ) echo "<a href= viewNews.php?pubID=",$newsArray[3][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[3][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[3][3],">$title </a>"; ?>
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
  <p ><font size="6"><p><?php if(isset($newsArray[4][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[4][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[4][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[4][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[4][1]))  echo $newsArray[4][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

  <?php if(isset($newsArray[5][0])) $title = $newsArray[5][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[5][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[5][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[5][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[5][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[5][1]))  echo $newsArray[5][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

   <?php if(isset($newsArray[6][0])) $title = $newsArray[6][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[6][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[6][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[6][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[6][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[6][1]))  echo $newsArray[6][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

   <?php if(isset($newsArray[7][0])) $title = $newsArray[7][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[7][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[7][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[7][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[7][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[7][1]))  echo $newsArray[7][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
   <?php if(isset($newsArray[8][0])) $title = $newsArray[8][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[8][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[8][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[8][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[8][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[8][1]))  echo $newsArray[8][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
   <?php if(isset($newsArray[9][0])) $title = $newsArray[9][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[9][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[9][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[9][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[9][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[9][1]))  echo $newsArray[9][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

   <?php if(isset($newsArray[10][0])) $title = $newsArray[10][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[10][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[10][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[10][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[10][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[10][1]))  echo $newsArray[10][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

  <?php if(isset($newsArray[11][0])) $title = $newsArray[11][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[11][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[11][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[11][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[11][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[11][1]))  echo $newsArray[11][1]; ?> </p></font></p>
</div><div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

  <?php if(isset($newsArray[12][0])) $title = $newsArray[12][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[12][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[12][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[12][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[12][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[12][1]))  echo $newsArray[12][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
 
   <?php if(isset($newsArray[13][0])) $title = $newsArray[13][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[13][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[13][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[13][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[13][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[13][1]))  echo $newsArray[13][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

   <?php if(isset($newsArray[14][0])) $title = $newsArray[14][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[14][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[14][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[14][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[14][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[14][1]))  echo $newsArray[14][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

   <?php if(isset($newsArray[15][0])) $title = $newsArray[15][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[15][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[15][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[15][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[15][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[15][1]))  echo $newsArray[15][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

   <?php if(isset($newsArray[16][0])) $title = $newsArray[16][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[16][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[16][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[16][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[16][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[16][1]))  echo $newsArray[16][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
  <?php if(isset($newsArray[17][0])) $title = $newsArray[17][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[17][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[17][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[17][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[17][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[17][1]))  echo $newsArray[17][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

  <?php if(isset($newsArray[18][0])) $title = $newsArray[18][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[18][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[18][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[18][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[18][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[18][1]))  echo $newsArray[18][1]; ?> </p></font></p>
</div>
<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
   <?php if(isset($newsArray[19][0])) $title = $newsArray[19][0]; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[19][3])&& ($type =='normaluser' || $type =='author')) echo "<a href= viewNews.php?pubID=",$newsArray[19][3],">$title </a>"; ?>
  <p ><font size="6"><p><?php if(isset($newsArray[19][3]) && $type == 'editor' ) echo "<a href= viewNewsForEditor.php?pubID=",$newsArray[19][3],">$title </a>"; ?>
  <p ><font size="4"><p> <?php  if(isset($newsArray[19][1]))  echo $newsArray[19][1]; ?> </p></font></p>
</div>
  </div>
  <div id="content"> </div>
</div>
</body>
</html>
