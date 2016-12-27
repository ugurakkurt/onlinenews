<?php
//this page shows one specified news
	session_start();
	include_once 'dbconnect.php';
	$type = '';
	
	
	$userID =	$_SESSION['user'];
	//if session variable user is not set, then go to login page
	if(!isset($_SESSION['user'])){	
		?>
			<script>alert('not set ');</script>
			<?php
		header("Location: index.php");
		exit;
	}	
	

		$res=mysql_query("SELECT * FROM editor");
		$userRow = mysql_fetch_array($res);
		if($userRow['userID'] == $_SESSION['user'] ){// editor should not be able to see this page
		
			$type = 'editor';
			
		}
		else{
			?>
			<script>alert('only editor can see this page ');</script>
			<?php
			header("Location: index.php");
			exit;
			
			
			
		}
		
	
	
	if(isset($_POST['homeButton'])){	
			header("Location: editorHomePage.php");
			exit;
		}
		
		
	
	if(isset($_POST['generalNewsButton'])){
		
		header("Location: generalNewsList.php");
		exit;
		
	}
	if(isset($_POST['videoListButton'])){
		
		header("Location: generalnewsList.php");
		exit;
		
	}
	if(isset($_POST['categoriesButton'])){
		
		header("Location: categoriesPage.php");
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
		
	// retrive the news ID which was inserted as a parameter before
	$pubID = $_GET['pubID'];
	$article = mysql_query("	SELECT publication.title, publication.content , publication.readCount , publication.date, publication.likeCount, publication.dislikeCount
									FROM article,publication
									WHERE article.pubID = publication.pubID AND
										publication.pubID = '$pubID'										
									");
	$articleRow = mysql_fetch_array($article);
	echo "asddddd";
	//var_dump($pubID);
	
	$commentList = mysql_query("	SELECT comment.content, user.username ,comment.date, comment.commentID
										FROM comment,user
										WHERE comment.userID = user.userID AND
											comment.pubID = '$pubID'
										ORDER BY date DESC
										LIMIT 10
										");
	//var_dump($commentList);
		
	$commentsArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($commentList)){
		$commentsArray[$index] = $rows;
		$index++;
	}
	
	
	
	
	if(isset($_POST['commentSubmitButton'])){

		?>
		<script>alert('editor can not make comment! ');</script>
		<?php
		
	}

	$lastAddedArticlesList = mysql_query("SELECT publication.title,  publication.pubID, publication.date
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
	$authorNamee = mysql_query("SELECT user.username
				 FROM user,article
				 WHERE article.pubID = '$pubID' AND
						user.userID = article.userID
	");
	$authorName = mysql_fetch_array($authorNamee);
	
	
	$articleInfo= mysql_query("
						SELECT likeCount,dislikeCount	
						FROM article,publication
						WHERE article.pubID = $pubID AND
							article.pubID = publication.pubID
	");
	$articleCounts = mysql_fetch_array($articleInfo);
	//var_dump($articleCounts);
	
	$labelsList = mysql_query("SELECT text	
							FROM label, has_label
							WHERE label.labelID = has_label.labelID AND
								has_label.pubID = '$pubID'
	");	
	
		if(isset($_POST['deleteButton1'])){
		$commentIDToBeDeleted = $commentsArray[0][3];
		mysql_query(" DELETE FROM comment
					  WHERE commentID = '$commentIDToBeDeleted';
		
			"	);
				?>
				<script>alert('comment is deleted! ');</script>
				<?php
				header("Refresh:0");
				exit;
	}
	if(isset($_POST['deleteButton2'])){
		$commentIDToBeDeleted = $commentsArray[1][3];
		mysql_query(" DELETE FROM comment
					  WHERE commentID = '$commentIDToBeDeleted';
		
			"	);
				?>
				<script>alert('comment is deleted! ');</script>
				<?php
				header("Refresh:0");
				exit;
	}
	if(isset($_POST['deleteButton3'])){
		$commentIDToBeDeleted = $commentsArray[2][3];
		mysql_query(" DELETE FROM comment
					  WHERE commentID = '$commentIDToBeDeleted';
		
			"	);
				?>
				<script>alert('comment is deleted! ');</script>
				<?php
				header("Refresh:0");
				exit;
	}
	if(isset($_POST['deleteButton4'])){
		$commentIDToBeDeleted = $commentsArray[3][3];
		mysql_query(" DELETE FROM comment
					  WHERE commentID = '$commentIDToBeDeleted';
		
			"	);
				?>
				<script>alert('comment is deleted! ');</script>
				<?php
				header("Refresh:0");
				exit;
	}
	if(isset($_POST['deleteButton5'])){
		$commentIDToBeDeleted = $commentsArray[4][3];
		mysql_query(" DELETE FROM comment
					  WHERE commentID = '$commentIDToBeDeleted';
		
			"	);
				?>
				<script>alert('comment is deleted! ');</script>
				<?php
				header("Refresh:0");
				exit;
	}
	if(isset($_POST['deleteButton6'])){
		$commentIDToBeDeleted = $commentsArray[5][3];
		mysql_query(" DELETE FROM comment
					  WHERE commentID = '$commentIDToBeDeleted';
		
			"	);
				?>
				<script>alert('comment is deleted! ');</script>
				<?php
				header("Refresh:0");
				exit;
	}
	if(isset($_POST['deleteButton7'])){
		$commentIDToBeDeleted = $commentsArray[6][3];
		mysql_query(" DELETE FROM comment
					  WHERE commentID = '$commentIDToBeDeleted';
		
			"	);
				?>
				<script>alert('comment is deleted! ');</script>
				<?php
				header("Refresh:0");
				exit;
	}
	if(isset($_POST['deleteButton8'])){
		$commentIDToBeDeleted = $commentsArray[7][3];
		mysql_query(" DELETE FROM comment
					  WHERE commentID = '$commentIDToBeDeleted';
		
			"	);
				?>
				<script>alert('comment is deleted! ');</script>
				<?php
				header("Refresh:0");
				exit;
	}
	if(isset($_POST['deleteButton9'])){
		$commentIDToBeDeleted = $commentsArray[8][3];
		mysql_query(" DELETE FROM comment
					  WHERE commentID = '$commentIDToBeDeleted';
		
			"	);
				?>
				<script>alert('comment is deleted! ');</script>
				<?php
				header("Refresh:0");
				exit;
	}
	if(isset($_POST['deleteButton10'])){
		$commentIDToBeDeleted = $commentsArray[9][3];
		mysql_query(" DELETE FROM comment
					  WHERE commentID = '$commentIDToBeDeleted';
		
			"	);
				?>
				<script>alert('comment is deleted! ');</script>
				<?php
				header("Refresh:0");
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
  
  
 

  <div id="logout" align="right">
	<form method="post">
    <input type="submit" name="logoutButton" id="button" value="LOG OUT" >
    
  </div>
</div>
<div align="right"><p><?php if($type== 'normaluser' || $type == 'author' )echo $userRow['username']; else echo "editorReiz"; ?> </p> </div>
  <div><img src="photo/logo7.png" width="900" height="163" alt=""/></div>
<section class="sidebar"  align="right">
    <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
    <div class="row">
      <div class="col-md-1" align="center">
        <button type="submit" name="homeButton" class="btn btn-info">&nbsp;HOME</button>
      </div>
      <div class="col-md-1 col-md-offset-0" align="center">
        <button type="submit" name= "generalNewsButton" class="btn btn-info">NEWS</button>
      </div>
      <div class="col-md-offset-0 col-md-1">
        <button type="submit" name = "videoListButton" class="btn btn-info">VIDEOS</button>
      </div>
      <div class="col-md-offset-0 col-md-1">
        <button type="submit" name= "categoriesButton" class="btn btn-info">CATEGORIES</button>
      </div>
      <div class="col-md-offset-1 col-md-1">
        <button type="submit" name= "authorListButton" class="btn btn-info">AUTHORS</button>
      </div>
      
</form>
</section>



<div>
<div>&nbsp;</div>
<div>&nbsp;</div>

<div>
<div class="container">
	<div class="col-md-9" align="left">
    	<div class="col-md-9" align="left">
        		<p><?php echo $articleRow[3];//date ?> </p>
                <p><?php echo "Author: "; echo $authorName[0];//author name ?> </p>
                <h1><?php echo $articleRow[0];//title ?></h1>
                <p><?php echo $articleRow[1];//content ?> </p>
                
                <div>&nbsp;</div>
				<div>&nbsp;</div>
                         
            
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                
                <div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <p><?php echo 'number of reads: '; echo $articleRow[2]; ?></p>
    			</div>	
				
				 <form method="post">
				 
                 <div id="logout" align="right"> 			
  				 </div>
                 
                 <div align="left">
                 </div> 
                 <div class="row">
                     <div align="left">
						
                        <div class="col-md-4"> 
                            <p> Make Comment </p>
                            <div>&nbsp;</div>
							<div>&nbsp;</div>
							<div>&nbsp;</div>
							<div>&nbsp;</div>
                            <p><?php if(isset($commentsArray[0][1])) echo $commentsArray[0][1]; ?> </p>
                            <div>&nbsp;</div>

                            <p> <?php if(isset($commentsArray[1][1])) echo $commentsArray[1][1]; ?> </p>
                            <div>&nbsp;</div>

                            <p> <?php if(isset($commentsArray[2][1])) echo $commentsArray[2][1]; ?> </p>
                            <div>&nbsp;</div>

                            <p> <?php if(isset($commentsArray[3][1])) echo $commentsArray[3][1]; ?> </p>
                            <div>&nbsp;</div>

                            
                            <p> <?php if(isset($commentsArray[4][1])) echo $commentsArray[4][1]; ?> </p>
                            <div>&nbsp;</div>

                            
                            <p> <?php if(isset($commentsArray[5][1])) echo $commentsArray[5][1]; ?> </p>
                            <div>&nbsp;</div>

                            
                            <p> <?php if(isset($commentsArray[6][1])) echo $commentsArray[6][1]; ?> </p>
                            <div>&nbsp;</div>

                            
                            <p> <?php if(isset($commentsArray[7][1])) echo $commentsArray[7][1]; ?> </p>
                            <div>&nbsp;</div>

                            
                            <p> <?php if(isset($commentsArray[8][1])) echo $commentsArray[8][1]; ?> </p>
                            <div>&nbsp;</div>

                            
                            <p> <?php if(isset($commentsArray[9][1])) echo $commentsArray[9][1]; ?> </p>
                            
                        </div>
						<form method="post">
                        <div class="col-md-5">
							
							<div>&nbsp;</div>
							<div class="col-md-10">
                            <input type="text" name="commentText" id="textfield">
					</div>
						<div class="col-md-1" align="right">
						<input type="submit" name="commentSubmitButton" id="button" value="Done" >
						</div>
							<form method="post">
                            <div>&nbsp;</div>
							<div>&nbsp;</div>
							<div>&nbsp;</div>
							<div>&nbsp;</div>
							<div>&nbsp;</div>
                            <p><?php if(isset($commentsArray[0][0])) echo $commentsArray[0][0]; ?></p>
                            <div>&nbsp;</div>
                            
                            <p><?php if(isset($commentsArray[1][0])) echo $commentsArray[1][0]; ?></p>
                            <div>&nbsp;</div>
                            
                            <p><?php if(isset($commentsArray[2][0])) echo $commentsArray[2][0]; ?> </p>
                            <div>&nbsp;</div>
                            
                            <p><?php if(isset($commentsArray[3][0])) echo $commentsArray[3][0]; ?> </p>
                            <div>&nbsp;</div>
                            
                            <p><?php if(isset($commentsArray[4][0])) echo $commentsArray[4][0]; ?> </p>
                            <div>&nbsp;</div>
                            
                            <p><?php if(isset($commentsArray[5][0])) echo $commentsArray[5][0]; ?> </p>
                            <div>&nbsp;</div>
                            
                            <p><?php if(isset($commentsArray[6][0])) echo $commentsArray[6][0]; ?> </p>
                            <div>&nbsp;</div>
                            
                            <p><?php if(isset($commentsArray[7][0])) echo $commentsArray[7][0]; ?> </p>
                            <div>&nbsp;</div>
                            
                            <p><?php if(isset($commentsArray[8][0])) echo $commentsArray[8][0]; ?> </p>
                            <div>&nbsp;</div>
                            
                            <p><?php if(isset($commentsArray[9][0])) echo $commentsArray[9][0]; ?> </p>
                            </div
                     </div>
				<div class="col-md-2"> 
                            <div>&nbsp;</div>
							<div>&nbsp;</div>
							<div>&nbsp;</div>
							<div>&nbsp;</div>
							<div>&nbsp;</div>
							
                             <div>&nbsp;</div>
							 <form method="post">
                              <?php if(isset($commentsArray[0][1])){ ?> <input type="submit" name="deleteButton1" id="button" value="Delete" style="height:30px; width:50px"  ><?php }?>
                             <div>&nbsp;</div>
                              <?php if(isset($commentsArray[1][1])){ ?> <input type="submit" name="deleteButton2" id="button" value="Delete" style="height:30px; width:50px"  ><?php }?>
                             <div>&nbsp;</div>
                              <?php if(isset($commentsArray[2][1])){ ?> <input type="submit" name="deleteButton3" id="button" value="Delete" style="height:30px; width:50px"  ><?php }?>
                             <div>&nbsp;</div>
                              <?php if(isset($commentsArray[3][1])){ ?> <input type="submit" name="deleteButton4" id="button" value="Delete" style="height:30px; width:50px"  ><?php }?>
                             <div>&nbsp;</div>
                              <?php if(isset($commentsArray[4][1])){ ?> <input type="submit" name="deleteButton5" id="button" value="Delete" style="height:30px; width:50px"  ><?php }?>
                             <div>&nbsp;</div>
                              <?php if(isset($commentsArray[5][1])){ ?> <input type="submit" name="deleteButton6" id="button" value="Delete" style="height:30px; width:50px"  ><?php }?>
                             <div>&nbsp;</div>
                             <?php if(isset($commentsArray[6][1])){ ?> <input type="submit" name="deleteButton7" id="button" value="Delete" style="height:30px; width:50px"  ><?php }?>
                             <div>&nbsp;</div>
                              <?php if(isset($commentsArray[7][1])){ ?> <input type="submit" name="deleteButton8" id="button" value="Delete" style="height:30px; width:50px"  ><?php }?>
                             <div>&nbsp;</div>
                              <?php if(isset($commentsArray[8][1])){ ?> <input type="submit" name="deleteButton9" id="button" value="Delete" style="height:30px; width:50px"  ><?php }?>
                             <div>&nbsp;</div>
                              <?php if(isset($commentsArray[9][1])){ ?> <input type="submit" name="deleteButton10" id="button" value="Delete" style="height:30px; width:50px"  ><?php }?>
                             <div>&nbsp;</div>
							 </form>
                         </div>
                     <div class="col-md-3" >
											
						</form>
                        <div>&nbsp;</div>
						<div>&nbsp;</div><div>&nbsp;</div>
						<div>&nbsp;</div>
                        <p> <?php if(isset($commentsArray[0][2])) echo $commentsArray[0][2]; ?> </p>
                        <div>&nbsp;</div>
                        <p> <?php if(isset($commentsArray[1][2])) echo $commentsArray[1][2]; ?> </p>
                        <div>&nbsp;</div>
                        <p> <?php if(isset($commentsArray[2][2])) echo $commentsArray[2][2]; ?> </p>
                        <div>&nbsp;</div>
                        <p> <?php if(isset($commentsArray[3][2])) echo $commentsArray[3][2]; ?> </p>
                        <div>&nbsp;</div>
                        <p> <?php if(isset($commentsArray[4][2])) echo $commentsArray[4][2]; ?> </p>
                        <div>&nbsp;</div>
                        <p> <?php if(isset($commentsArray[5][2])) echo $commentsArray[5][2]; ?> </p>
                        <div>&nbsp;</div>
                        <p> <?php if(isset($commentsArray[6][2])) echo $commentsArray[6][2]; ?> </p>
                        <div>&nbsp;</div>
                        <p> <?php if(isset($commentsArray[7][2])) echo $commentsArray[7][2]; ?> </p>
                        <div>&nbsp;</div>
                        <p> <?php if(isset($commentsArray[8][2])) echo $commentsArray[8][2]; ?> </p>
                        <div>&nbsp;</div>
                        <p> <?php if(isset($commentsArray[9][2])) echo $commentsArray[9][2]; ?> </p>
                     </div>
    
                     
                    </div>
               </div>
   </div>
        
        
</div>
  <?php echo 'labels:'; 
		 while($rows=mysql_fetch_array($labelsList)){
			echo $rows[0];
			echo ',';
		 }?> 
    <div class="col-md-3" align="right">
        		<h1>LAST ADDED ARTICLES</h1>
                <?php if(isset($lastAddedArticlesArray[0][0])) $title = $lastAddedArticlesArray[0][0]; ?>
                <?php if(isset($lastAddedArticlesArray[0][1])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$lastAddedArticlesArray[0][1],">$title </a>"; ?>
				<?php if(isset($lastAddedArticlesArray[0][1])&& $type =='editor') echo "<a href= viewArticleForEditor.php?pubID=",$lastAddedArticlesArray[0][1],">$title </a>"; ?>
                <p><?php if(isset($lastAddedArticlesArray[0][2])) echo $lastAddedArticlesArray[0][2]; ?></p>
                
                <?php if(isset($lastAddedArticlesArray[1][0])) $title = $lastAddedArticlesArray[1][0]; ?>
                <?php if(isset($lastAddedArticlesArray[1][1])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$lastAddedArticlesArray[1][1],">$title </a>"; ?>
				<?php if(isset($lastAddedArticlesArray[1][1])&& $type =='editor') echo "<a href= viewArticleForEditor.php?pubID=",$lastAddedArticlesArray[1][1],">$title </a>"; ?>
                <p><?php if(isset($lastAddedArticlesArray[1][2])) echo $lastAddedArticlesArray[1][2]; ?></p>
                
                <?php if(isset($lastAddedArticlesArray[2][0])) $title = $lastAddedArticlesArray[2][0]; ?>
                <?php if(isset($lastAddedArticlesArray[2][1])&& ($type =='normaluser' || $type == 'author')) echo "<a href= viewArticle.php?pubID=",$lastAddedArticlesArray[2][1],">$title </a>"; ?>
				<?php if(isset($lastAddedArticlesArray[1][1])&& $type =='editor') echo "<a href= viewArticleForEditor.php?pubID=",$lastAddedArticlesArray[2][1],">$title </a>"; ?>
                 <p><?php if(isset($lastAddedArticlesArray[2][2])) echo $lastAddedArticlesArray[2][2]; ?></p>      		
    </div>    
    </div>    
 </div> 
</div>