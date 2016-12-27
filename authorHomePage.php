<?php
session_start();
include_once 'dbconnect.php';
	//echo $_SESSION['user'];
	//echo 'asd';
	if(!isset($_SESSION['user'])){	
		header("Location: index.php");
		exit;
	}

	$userID =	$_SESSION['user'];
  	// check if it is really an author who is visiting the page
    //if not, return to login page
	$res = mysql_query("SELECT * FROM user,author 
				WHERE user.userID = author.userID AND user.userID = '$userID' ");
	$userRow = mysql_fetch_array($res);
	echo $userRow['username']; 
	$authorID = $userRow['userID'];
	if($userRow['userID'] == $_SESSION['user'] ){
		//echo"home page for author";
	}
		
	else{
		header("Location: index.php");
		exit;
	}
	
	if(isset($_POST['homeButton'])){
		header("Location: authorHomePage.php");
		exit;
	}
	if(isset($_POST['generalNewsButton'])){
		header("Location: generalNewsList.php");
		exit;
	}
	if(isset($_POST['categoriesButton'])){
		header("Location: categoriesPage.php");
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

	if(isset($_POST['logoutButton'])){
		header("Location: logout.php?logout");
		exit;
	}
	
	$follower = mysql_query("SELECT count(userID)
							FROM follow
							WHERE authorID = '$userID'  ");
	$followerRow = mysql_fetch_array($follower);
	
	$rate = mysql_query("SELECT rate
							FROM author
							WHERE userID = '$authorID'  ");
	$rateRow = mysql_fetch_array($rate);
	
	$lastArticlesList = mysql_query("SELECT title, date, publication.pubID
								FROM article, publication
								WHERE article.pubID = publication.pubID AND
									  article.userID = '$userID'
								ORDER BY publication.date DESC
								LIMIT 3") ;

		
		$lastArticlesArray = array();
		$index = 0;
		while($rows=mysql_fetch_array($lastArticlesList)){
			$lastArticlesArray[$index] = $rows;
			$index++;
		}
	
	
	
	$publishCounttt = mysql_query("SELECT count(pubID)
								FROM article
								WHERE userID = '$userID'
					
								") ;
	$publishCountt = mysql_fetch_array($publishCounttt);
	if(isset($_POST['addButton'])){		
		header("Location: uploadArticle.php");
		exit;

	}
	if(isset($_POST['searchArticleButton'])){
		$getLabel = $_POST['labelTextForArticle'];
		if($getLabel!= ""){ // that means label is typed, do searching
			$_SESSION['labelTextForArticle'] = $getLabel;
			header("Location: viewArticleListByLabel.php");
			exit;
		}
		else{
			?>
			<script>alert('please first write text to search');</script>
			<?php
		}
	}
	if(isset($_POST['searchNewsButton'])){	
		$getLabel = $_POST['labelTextForNews'];
		if($getLabel!= ""){ // that means label is typed, do searching
			$_SESSION['labelForNews'] = $getLabel;
			header("Location: viewNewsListByLabel.php");
			exit;
		}
		else{
			?>
			<script>alert('please first write text to search');</script>
			<?php
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
<form method="post">
  <div id="logout" align="right">
    <input type="submit" name="logoutButton" id="button" value="LOG OUT" >
	</form>
    
  </div>
</div>
<div align="right"><p><?php $userRow['username'] ?> </p> </div>
  <div><img src="photo/logo6.png" width="900" height="163" alt=""/></div>
  
<section class="sidebar"  align="right">
    <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
    <div class="row">
	<form method="post">
          <div class="col-md-1" align="center">
            <button type="submit" name="homeButton" class="btn btn-info">&nbsp;HOME</button>
          </div>
          <div class="col-md-1 col-md-offset-0" align="center">
            <button type="submit" name="generalNewsButton" class="btn btn-info">NEWS</button>
          </div>
          <div class="col-md-offset-0 col-md-1">
            <button type="submit" name="videoListButton" class="btn btn-info">VIDEOS</button>
          </div>
          <div class="col-md-offset-0 col-md-1">
            <button type="submit"  name="categoriesButton" class="btn btn-info">CATEGORIES</button>
          </div>
          <div class="col-md-offset-1 col-md-1">
            <button type="submit" name="authorListButton" class="btn btn-info">AUTHORS</button>
          </div>
      </form>
     </div> 


  <div class="container">
	<div class="row">

      <div class="col-lg-4" align="left">
	  <form method="post">
      <p>&nbsp;</p>
      <p style="font-size:20px">Number Of Followers: </p>
	  <p><?php  echo $followerRow[0]; ?> </p>
	  <p style="font-size:20px">Rate:  </p>
	  <p><?php  echo $rateRow[0]; ?> </p>
	  </form>
      </div>
      <div class="col-lg-4" align="left">
	  <form method="post">
      <p>&nbsp;</p>
      <p style="font-size:20px">Number of Added Articles: </p>
	  <p><?php echo $publishCountt[0]; ?> </p>
	   </form>
      </div>
    </div>
</div>
   <form method="post">
   <div class="row">
	<form method="post">
        <div class="col-md-10">
              <label for="textfield">Search News:</label>
              <input type="text" name="labelTextForNews" id="textfield">
        </div>
        <div class="col-md-1" align="center">
              <input type="submit" name="searchNewsButton" id="button" value="Go" >
        </div>
          <form method="post">
        <div class="col-md-10">
          <label for="textfield">Search Articles:</label>
          <input type="text" name="labelTextForArticle" id="textfield">
        </div>
        <div class="col-md-1" align="center">
            <input type="submit" name="searchArticleButton" id="button" value="Go" >
			</form>
        </div>
		</form>
        </form>        
      </div>
    <div class="row">
    <div class="col-lg-6" align="left">
    <p>&nbsp;</p>
    </div>
	</div>

	
  <div align="center">
  <form method="post">
  <p class="col-md-offset-0 col-md-9">
    <button type="submit" name="addButton" class="btn btn-lg btn-default">ADD ARTICLE</button>
	</form>
    
  <div class="container">
	<div class="col-md-12" align="left">
				<h1>LAST ADDED ARTICLES</h1>
                    <div class="row">
                         <div class="col-md-4" align="center">
                            <?php if(isset($lastArticlesArray[0][0])) $title = $lastArticlesArray[0][0]; ?>
							<?php if(isset($lastArticlesArray[0][0])) echo "<a href=viewArticle.php?pubID=",$lastArticlesArray[0][2],">$title </a>"; ?>
                            <p> <?php  if(isset($lastArticlesArray[0][1]))  echo $lastArticlesArray[0][1]; ?> </p>
					</div>
					<div class="col-md-4" align="center">
							<?php if(isset($lastArticlesArray[1][0])) $title = $lastArticlesArray[1][0]; ?>
                            <?php if(isset($lastArticlesArray[1][0])) echo "<a href=viewArticle.php?pubID=",$lastArticlesArray[1][2],">$title </a>"; ?>
                            <p> <?php  if(isset($lastArticlesArray[1][1]))  echo $lastArticlesArray[1][1]; ?> </p>
					</div>
					<div class="col-md-4" align="center">
							<?php if(isset($lastArticlesArray[2][0])) $title = $lastArticlesArray[2][0]; ?>
                            <?php if(isset($lastArticlesArray[2][0])) echo "<a href=viewArticle.php?pubID=",$lastArticlesArray[2][2],">$title </a>"; ?>
                            <p> <?php  if(isset($lastArticlesArray[2][1]))  echo $lastArticlesArray[2][1]; ?> </p>
					</div>
                    </div>      
</div>  
</body>
</html>