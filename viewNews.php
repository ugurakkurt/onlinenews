<?php
//this page shows one specified news
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
	
	$countLike = '';
	$countDislike ='';
	
	if($userRow['userID'] == $_SESSION['user'] ){
		//echo"news list for normal users";
		$type = 'normaluser';
	}
		
	else{
		
		$res=mysql_query("SELECT * FROM editor");
		$userRow = mysql_fetch_array($res);
		if($userRow['userID'] == $_SESSION['user'] ){// editor should not be able to see this page
		
			?>
			<script>alert('editor can not go to this page, redirecting to home for editor.. ');</script>
			<?php
			header("Location: uploadNews.php");
			exit;
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
		else{?>
				<script>alert('oopss ');</script>
				<?php
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
	//echo $pubID;
	
	
	if(isset($_POST['commentSubmitButton'])){
		var_dump($_POST['commentText']);
		$comment = mysql_real_escape_string($_POST['commentText']);
		if($comment == ''){
			?>
				<script>alert('first write a comment! ');</script>
				<?php
		}
		else{
			if($type== 'author'){
				?>
				<script>alert('authors can not make comments! ');</script>
				<?php
			}
			
			else{
				$userID = $userRow['userID'];
				mysql_query(" INSERT INTO `comment`( `userID`, `pubID`, `content`)  VALUES ('$userID','$pubID','$comment') ");
				unset($_POST['commentSubmitButton']);
				unset($_POST['commentText']);
			}
			
		}
	}
	$commentList = mysql_query("	SELECT comment.content, user.username ,comment.date
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
	
	//increase read count of the news
	mysql_query("	UPDATE publication
					SET readCount = readCount + 1
					WHERE pubID = '$pubID'
	");
	
	$news = mysql_query("	SELECT publication.title, news.subtitle , publication.content , publication.readCount , publication.date, agent.agentName, publication.likeCount, publication.dislikeCount
									FROM news,publication,agent
									WHERE news.pubID = publication.pubID AND
										news.agentID = agent.agentID AND
										publication.pubID = '$pubID'
										
									");
	$newsRow = mysql_fetch_array($news);
	//var_dump($newsRow[3]);
	
	//retrive video url
	$video = mysql_query("	SELECT link
							FROM video
							WHERE pubID = '$pubID'	
	");
	$videoUrl = mysql_fetch_array($video);
	
	//retrive photo link
	$photo = mysql_query("	SELECT photoLink
							FROM photo		
							WHERE pubID = '$pubID'	
	"	);
	$photoLin = mysql_fetch_array($photo);
	$photoLink = mysql_real_escape_string($photoLin[0]);
	
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
	
	if(isset($_POST['LikeButton'])){
		if($type == 'editor' || $type == 'author'){	
			?>
			<script>alert('you can not like the article!');</script>
			<?php
			header("Refresh:0");
		}
		else{
			mysql_query(" SELECT *
						 FROM likepub
						 WHERE likepub.userID = '$userID' AND 
						 likepub.pubID = '$pubID' ");
			if(mysql_affected_rows()>0){
					?>
				<script>alert('you can not like/dislike again!');</script>
				<?php	
			
			}
			else{
			
				mysql_query("	UPDATE publication
								SET likeCount = likeCount + 1
								WHERE pubID = '$pubID'
							");	
				mysql_query(" INSERT INTO `likepub`(`userID`, `pubID`, `likeOrDislike`) VALUES
												('$userID', '$pubID', 1	)
			
				");	
				?>
				<script>alert('You liked the article:)');</script>
				<?php	
				header("Refresh:0");
		}
		
			
		}
	}
	
	if(isset($_POST['DislikeButton'])){
		if($type == 'editor' || $type == 'author'){	
			?>
			<script>alert('you can not like the article!');</script>
			<?php
			header("Refresh:0");
		}
		else{
			mysql_query(" SELECT *
						 FROM likepub
						 WHERE likepub.userID = '$userID' AND
						 likepub.pubID = '$pubID'  ");
			if(mysql_affected_rows()>0){
					?>
				<script>alert('you can not like/dislike again!');</script>
				<?php	
			
			}
			else{
			
				mysql_query("	UPDATE publication
								SET dislikeCount = dislikeCount + 1
								WHERE pubID = '$pubID'
							");	
				mysql_query(" INSERT INTO `likepub`(`userID`, `pubID`, `likeOrDislike`) VALUES
												('$userID', '$pubID', 0	)
			
				");	
				?>
				<script>alert('You disliked the article');</script>
				<?php
				header("Refresh:0");
			
			}
		}
	}
	$labelsList = mysql_query("SELECT text	
							FROM label, has_label
							WHERE label.labelID = has_label.labelID AND
								has_label.pubID = '$pubID'
	");	
	
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
<div align="right"><p><?php echo $userRow['username']; ?> </p> </div>
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
        		<p><?php echo $newsRow[4];//date ?> </p>
                <p><?php echo "Agent: "; echo $newsRow[5];//agency name ?> </p>
                <h1><?php echo $newsRow[0];//title ?></h1>
                <p><?php echo $newsRow[1]; //subtitle?> </p>
                <p><?php echo $newsRow[2];//content ?> </p>
                
                <div>&nbsp;</div>
				<div>&nbsp;
					<div><img src="<?php echo $photoLink ?>" align ="middle" width="600" height="350" alt=""/></div>
					<!--<img src="<?php echo($photoLink); ?>" />--></div>
                
                
                
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                
                <div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <p><?php echo 'number of reads: '; echo $newsRow[3];//date ?></p>
    			</div>
     
				<form method="post">
                <div id="logout" align="right">
                <div class="col-md-9" align="right">
    				<input type="submit" name="LikeButton" id="button" value="LIKE" >
					<p> <?php echo 'Like Count: ' ;  echo $newsRow[6]; ?> </p>
                 </div>
                 <div class="col-md-" align="right">
    				<input type="submit" name="DislikeButton" id="button" value="UNLIKE" >
                 <p> <?php echo 'Dislike Count: '; echo $newsRow[7] ;  ?></p>  
                </form>
				
                 </div> 
                 <div id="logout" align="right">    
  				 </div>
                 
                 <div align="left">
					<a href =" " > <?php echo $videoUrl[0] ?> </a>
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
        <?php echo 'labels:'; 
		 while($rows=mysql_fetch_array($labelsList)){
			echo $rows[0];
			echo ',';
		 }?>  
        
</div>
 
  <div class="col-md-3" align="right">
        		<h1>LAST ADDED NEWS</h1>
                <?php if(isset($lastAddedNewsArray[0][0])) $title = $lastAddedNewsArray[0][0]; ?>
                <?php if(isset($lastAddedNewsArray[0][2])) echo "<a href= viewNews.php?pubID=",$lastAddedNewsArray[0][2],">$title </a>"; ?>
                <p><?php if(isset($lastAddedNewsArray[0][1])) echo $lastAddedNewsArray[0][1]; ?></p>
                
                <?php if(isset($lastAddedNewsArray[1][0])) $title = $lastAddedNewsArray[1][0]; ?>
                <?php if(isset($lastAddedNewsArray[1][2])) echo "<a href= viewNews.php?pubID=",$lastAddedNewsArray[1][2],">$title </a>"; ?>
                <p><?php if(isset($lastAddedNewsArray[1][1])) echo $lastAddedNewsArray[1][1]; ?></p>
                
                <?php if(isset($lastAddedNewsArray[2][0])) $title = $lastAddedNewsArray[2][0]; ?>
                <?php if(isset($lastAddedNewsArray[2][2])) echo "<a href= viewNews.php?pubID=",$lastAddedNewsArray[2][2],">$title </a>"; ?>
                 <p><?php if(isset($lastAddedNewsArray[2][1])) echo $lastAddedNewsArray[2][1]; ?></p>
        		
    </div>
    
    </div>

    
 </div>
 
</div>

	
