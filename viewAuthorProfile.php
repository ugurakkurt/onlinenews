<?php
//this page shows one specified news
	session_start();
	include_once 'dbconnect.php';
	$type = '';
	
	$authorID = $_GET['userID'];
	var_dump($authorID);
	$ress=mysql_query("SELECT user.username, author.rate, author.publishCount
						FROM user,author
						WHERE user.userID = author.userID AND user.userID = '$authorID' ");
	$authorRow = mysql_fetch_array($ress);
	
	
	$userID =	$_SESSION['user'];
	//if session variable user is not set, then go to login page
	if(!isset($_SESSION['user'])){	
		header("Location: index.php");
		exit;
	}	
	
	// check if it is really registered user who is visiting the page
    //if not, return to login page
	$res=mysql_query("SELECT * FROM user,registered_user 
						WHERE user.userID = registered_user.userID AND user.userID = '$userID'");
	$userRow = mysql_fetch_array($res);
	
	$countLike = '';
	$dislikeCount = '';
	
	if($userRow['userID'] == $_SESSION['user'] ){
		//echo"news list for normal users";
		$type = 'normaluser';
	}
		
	else{
		
		$res=mysql_query("SELECT * FROM editor");
		$userRow = mysql_fetch_array($res);
		if($userRow['userID'] == $_SESSION['user'] ){
		
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
				?>
				<script>alert('There must be something wrong! I hope this will never be seen ');</script>
				<?php
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
		else if($type == 'author'){
			header("Location: authorHomePage.php");
			exit;
		}
		else if($type == 'editor'){
			header("Location: editorHomePage.php");
			exit;
		}
		
		else{?>
				<script>alert('oopss ');</script>
				<?php
			header("Location: index.php");
			exit;
		}
		
		
	}
	if(isset($_POST['newsButton'])){
		
		header("Location: generalnewsList.php");
		exit;
		
	}
	if(isset($_POST['videosButton'])){
		
		header("Location: videoList.php");
		exit;
		
	}
	if(isset($_POST['categoriesButton'])){
		
		header("Location: categoriesPage.php");
		exit;
		
	}
	if(isset($_POST['authorButton'])){
		
		header("Location: authorList.php");
		exit;
		
	}
	$followingStatus = "not following";
	mysql_query(" SELECT *
					 FROM follow
					WHERE authorID = '$authorID' AND	
						  userID = '$userID'") ;
	if(mysql_affected_rows()>0){
		$followingStatus = "following";					
	}		
	
	if(isset($_POST['followButton'])){
		
		if($type == 'editor' || $type == 'author'){
			?>
				<script>alert('you can not follow an author ');</script>
				<?php
		}
		else{// normal user can follow
			mysql_query(" INSERT INTO `follow`(`userID`, `authorID`) VALUES ('$userID' , '$authorID')  ");
			if(mysql_affected_rows()>0){	
				mysql_query(" UPDATE author
								SET rate = rate + 10
								WHERE author.userID = '$authorID' ");
				?>
				<script>alert('author is followed');</script>
				<?php				
				$followingStatus = "following";	
				header("Refresh:0");
				exit;
			 }
			 else{				
				?>
				<script>alert('you are already following the author');</script>
				<?php				
			 }
			
			
		}
		
	}

	if(isset($_POST['unfollowButton'])){
		
		if($type == 'editor' || $type == 'author'){
			?>
				<script>alert('you can not unfollow an author ');</script>
				<?php
		}
		else{// normal user can unfollow
			mysql_query(" DELETE FROM follow
							 WHERE userID = '$userID' AND
								authorID = '$authorID' ");
				if(mysql_affected_rows()>0){
					mysql_query(" UPDATE author
								SET rate = rate - 10
								WHERE author.userID = '$authorID' ");				 
					?>
					<script>alert('author is unfollowed');</script>
					<?php					
					$followingStatus = "not following";
					header("Refresh:0");
				exit;
				}
				else{				
					?>
					<script>alert('you were not following the author actually!');</script>
					<?php				
				}					
		}
	}
	
	if(isset($_POST['logoutButton'])){
		header("Location: logout.php?logout");
		exit;
	}
	

	
	$articleList = mysql_query("SELECT publication.title, publication.pubID, publication.date
							FROM article, publication,author
							WHERE publication.pubID = article.pubID 
								AND author.userID = article.userID 
								AND author.userID = '$authorID'
								AND article.isVisible = 1
							ORDER BY publication.date DESC
							LIMIT 4
							");		
	$articleArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($articleList)){
		$articleArray[$index] = $rows;
		$index++;
	}

	
	 $authorName ='';
	 $authorRate ='';
	 $authorPublishCount= '';
	 $numberOfFollowers = '';
	 $numberOfFollowerss = mysql_query("SELECT count(userID)
										FROM follow	
										WHERE authorID = '$authorID'
	 
	 ");
	 $numberOfFollowers = mysql_fetch_array($numberOfFollowerss);
	 
	if(isset($_POST['homebutton'])){
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
	if(isset($_POST['newsButton'])){
		
		header("Location: generalNewsList.php");
		exit;
		
	}
	if(isset($_POST['videosButton'])){
		
		header("Location: videoList.php");
		exit;
		
	}
	if(isset($_POST['categoryButton'])){
		
		header("Location: categoriesPage.php");
		exit;
		
	}
	if(isset($_POST['authorButton'])){
		
		header("Location: authorList.php");
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
    <p>user name</p> 
</div>
  <div><img src="photo/logo.png" width="720" height="134" alt=""/></div>
<section class="sidebar"  align="right">
    <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
    <div class="row">
      <div class="col-md-2" align="center">
        <button type="submit" name= "homeButton" class="btn btn-info">Home</button>
      </div>
      <div class="col-md-2" align="center">
        <button type="submit" name= "newsButton" class="btn btn-info">News</button>
      </div>
      <div class="col-md-1">
        <button type="submit" name= "videosButton" class="btn btn-info">Videos</button>
      </div>
      <div class="col-md-offset-0 col-md-3">
        <button type="submit" name= "categoriesButton" class="btn btn-info">Categories</button>
      </div>
      <div class="col-md-offset-0 col-md-2">
        <button type="submit" name= "authorButton" class="btn btn-info">Authors</button>
      </div>
	  </form>
      <div class="col-md-1"></div>
      <div class="col-md-1"></div>
      <div class="col-md-1"></div>
    </div>
  <div class="container">
<div class="row">
      <div class="col-lg-4" align="left">
      <p>&nbsp;</p>
	  
      <p style="font-size:20px">Author Name: </p> <?php if(isset($authorRow[0])) $authorName = $authorRow[0]; echo $authorName; ?>		
      <p style="font-size:20px">Rate: </p>	<p> <?php if(isset($authorRow[1])) $authorRate = $authorRow[1]; echo $authorRate; ?>	</p>	
      <p style="font-size:20px">Number of Followers: <?php echo $numberOfFollowers[0] ;?>	</p> 
      <p style="font-size:20px">Number of Published Articles:</p>	<p> <?php if(isset($authorRow[2])) $authorPublishCount = $authorRow[2]; ?> <?php echo $authorPublishCount; ?>	</p>	
	  
	  
	 <p style="font-size:20px"><h1>Last Published Articles:</h1> </p>
<div>
	
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <?php if(isset($articleArray[0][0])) $articleName = $articleArray[0][0]; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[0][1])&& ($type =='normaluser' || $type == 'author')){ echo "<a href= viewArticle.php?pubID=",$articleArray[0][1],">$articleName </a>";} ?>
  <p ><font size="6"><p><?php if(isset($articleArray[0][1]) &&  $type == 'editor'){ echo "<a href= viewArticleForEditor.php?pubID=",$articleArray[0][1],">$articleName </a>";} ?>
   <?php if(isset($articleArray[0][2])) echo $articleArray[0][2]; ?>
</div>

<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <?php if(isset($articleArray[1][0])) $articleName = $articleArray[1][0]; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[1][1])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articleArray[1][1],">$articleName </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[1][1]) &&  $type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articleArray[1][1],">$articleName </a>"; ?>
  <?php if(isset($articleArray[1][2])) echo $articleArray[1][2]; ?>
</div>

<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <?php if(isset($articleArray[2][0])) $articleName = $articleArray[2][0]; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[2][1])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$articleArray[2][1],">$articleName </a>"; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[2][1]) &&  $type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articleArray[2][1],">$articleName </a>"; ?>
  <?php if(isset($articleArray[2][2])) echo $articleArray[2][2]; ?>
</div>

<div>
  <p>&nbsp;</p>
  <p>&nbsp;</p> 
  <?php if(isset($articleArray[3][0])) $articleName = $articleArray[3][0]; ?>
  <p ><font size="6"><p><?php if(isset($articleArray[3][1]) && ($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pID=",$articleArray[3][1],">$articleName </a>"; ?>
<p ><font size="6"><p><?php if(isset($articleArray[3][1]) &&  $type == 'editor') echo "<a href= viewArticleForEditor.php?pubID=",$articleArray[3][1],">$articleName </a>"; ?>
  <?php if(isset($articleArray[3][2])) echo $articleArray[3][2]; ?>
</div>
	  
       <form method="post">
      </div>
      <div class="col-lg-4" align="left">
        <p>&nbsp;</p>
        <input type="submit" name="followButton" id="button3" value="Follow&nbsp;&nbsp;&nbsp;">
        <input type="submit" name="unfollowButton" id="button2" value="Unfollow&nbsp;&nbsp;">
    	<p>Follow Status:  <?php echo $followingStatus; ?></p>
       </form>
      </div>
     
    </div>
</div>
  

  
      
</section>
   
</body>
</html>
