
<?php
session_start();
include_once 'dbconnect.php';

	//if session variable user is not set, then go to login page
	if(!isset($_SESSION['user'])){	
		header("Location: index.php");
		exit;
	}	
	$userID =	$_SESSION['user'];
	// check if it is really registered user who is visiting the page
    //if not, return to login page
	$res=mysql_query("SELECT * FROM user,registered_user 
						WHERE user.userID = registered_user.userID AND user.userID = '$userID' ");
	$userRow = mysql_fetch_array($res);
	if($userRow['userID'] == $_SESSION['user'] )
		echo"home page for normal users";
	else{
		header("Location: index.php");
		exit;
	}
	
	//retrive last added news list
	$lastAddedNewsList = mysql_query("SELECT publication.title, news.subtitle, publication.pubID, publication.date
									FROM news,publication
									WHERE news.pubID = publication.pubID
									ORDER BY publication.date DESC
									LIMIT 3
						");	
	$lastAddedNewsArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($lastAddedNewsList)){
		$lastAddedNewsArray[$index] = $rows;
		$index++;
	}
	
	//retrive most popular 3 news ordering by number of reads
	$popularNewsList = mysql_query("SELECT publication.title, news.subtitle, publication.pubID , publication.date
									FROM news,publication
									WHERE news.pubID = publication.pubID
									ORDER BY publication.readCount DESC
									LIMIT 3
						");	
	$popularNewsArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($popularNewsList)){
		$popularNewsArray[$index] = $rows;
		$index++;
	}
	
	//retrive last added articles list
	$lastAddedArticlesList = mysql_query("SELECT publication.title, publication.date, publication.pubID
									FROM article,publication
									WHERE article.pubID = publication.pubID
									ORDER BY publication.date DESC
									LIMIT 3
						");	
	$lastAddedArticlesArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($lastAddedArticlesList)){
		$lastAddedArticlesArray[$index] = $rows;
		$index++;
	}
	
	
	//retrive most popular articles list ordering by number of reads
	$popularArticlesList = mysql_query("SELECT publication.title, publication.date, publication.pubID
										FROM article,publication
										WHERE article.pubID = publication.pubID
										ORDER BY publication.readCount DESC
										LIMIT 3
						");	
	$popularArticlesArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($popularArticlesList)){
		$popularArticlesArray[$index] = $rows;
		$index++;
	}
	
	$mostRatedAuthorsList = mysql_query("SELECT user.userID, user.username
										FROM user,author
										WHERE user.userID = author.userID
										ORDER BY author.rate DESC
										LIMIT 3
						");	
	$mostRatedAuthorsArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($mostRatedAuthorsList)){
		$mostRatedAuthorsArray[$index] = $rows;
		$index++;
	}
	
	
	
	
	
	if(isset($_POST['homeButton'])){
		
		header("Location: registeredUserHomePage.php");
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
	if(isset($_POST['authorListButton'])){
		
		header("Location: authorList.php");
		exit;
		
	}

	if(isset($_POST['viewFollowedAuthorsButton'])){
		
		$_SESSION['userIDForFollowedAuthors'] = $userID;
		header("Location: followedAuthorList.php");
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
<div></div>
<div id="mainWrapper">
  <header>
<!-- This is the header content. It contains Logo and links -->  </header>
  
  
 
<form method="post">
  <div id="logout" align="right">
    <input type="submit" name="logoutButton" id="button" value="LOG OUT" >
	<p><?php echo $userRow['username']; ?></p> 
    
  </div>
</div>
<div align="right"><p><?php $userRow['username'] ?> </p> </div>
  <div><img src="photo/logo6.png" width="900" height="163" alt=""/></div>
<section class="sidebar"  align="right">
    <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
    <div class="row">
	
          <div class="col-md-1" align="center">
		  <form method="post">
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
      <div class="row">
 	  </div>
 	<div class="row">
	<form method="post">
        <div class="col-md-10">
              <label for="textfield">Search News:</label>
              <input type="text" name="labelTextForNews" id="textfield">
        </div>
        <div class="col-md-1" align="center">
              <input type="submit" name="searchNewsButton" id="button" value="Go" >
        </div>
          
        <div class="col-md-10">
          <label for="textfield">Search Articles:</label>
          <input type="text" name="labelTextForArticle" id="textfield">
        </div>
        <div class="col-md-1" align="center">
            <input type="submit" name="searchArticleButton" id="button" value="Go" >
        </div>
        </form>        
      </div>
	  </form>
	  <form method="post">
	  <div class="col-md-1" align="center">
              <input type="submit" name="viewFollowedAuthorsButton" id="button" value="Followed Authors" >
        </div>
		</form>
</div>
      

</section>
<div>

<div>&nbsp;</div>
<div>&nbsp;</div>

<div class="container" >
	<div class="col-md-8" align="left">
    	<div class="col-md-9" align="left">
        	<h1>POPULAR NEWS</h1>
            <div class="row">
                <div class="col-md-4" align="center">
                            <?php if(isset($popularNewsArray[0][0])) $title = $popularNewsArray[0][0]; ?>
							<?php if(isset($popularNewsArray[0][2])) echo "<a href= viewNews.php?pubID=",$popularNewsArray[0][2],">$title </a>"; ?>
                            <p> <?php  if(isset($popularNewsArray[0][1]))  echo $popularNewsArray[0][1]; ?> </p>
                </div>
                <div class="col-md-4" align="center">
							<?php if(isset($popularNewsArray[1][0])) $title = $popularNewsArray[1][0]; ?>
                            <?php if(isset($popularNewsArray[1][2])) echo "<a href= viewNews.php?pubID=",$popularNewsArray[1][2],">$title </a>"; ?>
                            <p> <?php  if(isset($popularNewsArray[1][1]))  echo $popularNewsArray[1][1]; ?> </p>
                </div>
                <div class="col-md-4" align="center">
							<?php if(isset($popularNewsArray[2][0])) $title = $popularNewsArray[2][0]; ?>
                            <?php if(isset($popularNewsArray[2][2])) echo "<a href= viewNews.php?pubID=",$popularNewsArray[2][2],">$title </a>"; ?>
                            <p> <?php  if(isset($popularNewsArray[2][1]))  echo $popularNewsArray[2][1]; ?> </p>
                </div>
            </div>
            
            
            <h1>POPULAR ARTICLES</h1>
            <div class="row">
			<div>&nbsp;</div>
                <div class="col-md-4" align="center">
                            <?php if(isset($popularArticlesArray[0][0])) $title = $popularArticlesArray[0][0]; ?>
							<?php if(isset($popularArticlesArray[0][2])) echo "<a href= viewArticle.php?pubID=",$popularArticlesArray[0][2],">$title </a>"; ?>
                            <p> <?php  if(isset($popularArticlesArray[0][1]))  echo $popularArticlesArray[0][1]; ?> </p>
                </div>
                <div class="col-md-4" align="center">
							<?php if(isset($popularArticlesArray[1][0])) $title = $popularArticlesArray[1][0]; ?>
                            <?php if(isset($popularArticlesArray[1][2])) echo "<a href= viewArticle.php?pubID=",$popularArticlesArray[1][2],">$title </a>"; ?>
							<div>&nbsp;</div>
                            <p> <?php  if(isset($popularArticlesArray[1][1]))  echo $popularArticlesArray[1][1]; ?> </p>
                </div>
			
                <div class="col-md-4" align="center">
							<?php if(isset($popularArticlesArray[2][0])) $title = $popularArticlesArray[2][0]; ?>
                            <?php if(isset($popularArticlesArray[2][2])) echo "<a href= viewArticle.php?pubID=",$popularArticlesArray[2][2],">$title </a>"; ?>
                            <p> <?php  if(isset($popularArticlesArray[2][1]))  echo $popularArticlesArray[2][1]; ?> </p>
                </div>
            </div>
            
            
        
        </div>
        
        
    
    </div>
    
    <div class="col-md-4" align="right">
    
    	<h1>MOST RATED AUTHORS</h1>
		<form method="post">
        <div class="col-md-4" align="right" >
		      <div>&nbsp;</div> 
            <div class="col-md-1" align="right">
                 <?php if(isset($mostRatedAuthorsArray[0][1])) $username = $mostRatedAuthorsArray[0][1]; ?>
				<p ><font size="6"><p><?php if(isset($mostRatedAuthorsArray[0][1])) echo "<a href= viewAuthorProfile.php?userID=",$mostRatedAuthorsArray[0][0],">$username </a>"; ?>
            </div>
        </div>
        
        <div class="col-md-4" align="right" >
		<div>&nbsp;</div><div>&nbsp;</div>
        	<?php if(isset($mostRatedAuthorsArray[1][1])) $username = $mostRatedAuthorsArray[1][1]; ?>
				<p ><font size="6"><p><?php if(isset($mostRatedAuthorsArray[1][1])) echo "<a href= viewAuthorProfile.php?userID=",$mostRatedAuthorsArray[1][0],">$username </a>"; ?>
            <div class="col-md-12" align="right">
            </div>
        </div>
        
        <div class="col-md-4" align="right" >
        	<div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
            <div class="col-md-4" align="right" >
                <?php if(isset($mostRatedAuthorsArray[2][1])) $username = $mostRatedAuthorsArray[2][1]; ?>
				<p ><font size="6"><p><?php if(isset($mostRatedAuthorsArray[2][1])) echo "<a href= viewAuthorProfile.php?userID=",$mostRatedAuthorsArray[2][0],">$username </a>"; ?>
                <div class="col-md-12" align="right">
                </div>
        	</div>
         </form>  
       </div>
          
    
    </div>
    
</div>


<div class="container">
	<div class="col-md-12" align="left">
				<h1>LAST ADDED NEWS</h1>
                    <div class="row">
                         <div class="col-md-4" align="center">
                            <?php if(isset($lastAddedNewsArray[0][0])) $title = $lastAddedNewsArray[0][0]; ?>
							<?php if(isset($lastAddedNewsArray[0][2])) echo "<a href= viewNews.php?pubID=",$lastAddedNewsArray[0][2],">$title </a>"; ?>
                            <p> <?php  if(isset($lastAddedNewsArray[0][1]))  echo $lastAddedNewsArray[0][1]; ?> </p>
					</div>
					<div class="col-md-4" align="center">
							<?php if(isset($lastAddedNewsArray[1][0])) $title = $lastAddedNewsArray[1][0]; ?>
                            <?php if(isset($lastAddedNewsArray[1][2])) echo "<a href= viewNews.php?pubID=",$lastAddedNewsArray[1][2],">$title </a>"; ?>
                            <p> <?php  if(isset($lastAddedNewsArray[1][1]))  echo $lastAddedNewsArray[1][1]; ?> </p>
					</div>
					<div class="col-md-4" align="center">
							<?php if(isset($lastAddedNewsArray[2][0])) $title = $lastAddedNewsArray[2][0]; ?>
                            <?php if(isset($lastAddedNewsArray[2][2])) echo "<a href= viewNews.php?pubID=",$lastAddedNewsArray[2][2],">$title </a>"; ?>
                            <p> <?php  if(isset($lastAddedNewsArray[2][1]))  echo $lastAddedNewsArray[2][1]; ?> </p>
					</div>
                    </div>
                <h1>LAST ADDED ARTICLES</h1>
                    <div class="row">
                         <div class="col-md-4" align="center">
                            <?php if(isset($lastAddedArticlesArray[0][0])) $title = $lastAddedArticlesArray[0][0]; ?>
							<?php if(isset($lastAddedArticlesArray[0][2])) echo "<a href= viewArticle.php?pubID=",$lastAddedArticlesArray[0][2],">$title </a>"; ?>
                            <p> <?php  if(isset($lastAddedArticlesArray[0][1]))  echo $lastAddedArticlesArray[0][1]; ?> </p>
					</div>
					<div class="col-md-4" align="center">
							<?php if(isset($lastAddedArticlesArray[1][0])) $title = $lastAddedArticlesArray[1][0]; ?>
                            <?php if(isset($lastAddedArticlesArray[1][2])) echo "<a href= viewArticle.php?pubID=",$lastAddedArticlesArray[1][2],">$title </a>"; ?>
                            <p> <?php  if(isset($lastAddedArticlesArray[1][1]))  echo $lastAddedArticlesArray[1][1]; ?> </p>
					</div>
					<div class="col-md-4" align="center">
							<?php if(isset($lastAddedArticlesArray[2][0])) $title = $lastAddedArticlesArray[2][0]; ?>
                            <?php if(isset($lastAddedArticlesArray[2][2])) echo "<a href= viewArticle.php?pubID=",$lastAddedArticlesArray[2][2],">$title </a>"; ?>
                            <p> <?php  if(isset($lastAddedArticlesArray[2][1]))  echo $lastAddedArticlesArray[2][1]; ?> </p>
					</div>
                    </div>
                

	</div>

</div>