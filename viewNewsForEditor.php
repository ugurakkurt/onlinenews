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
	
	
	$countLike = '';
	$countDislike ='';
	

		
		$res=mysql_query("SELECT * FROM editor");
		$userRow = mysql_fetch_array($res);
		if($userRow['userID'] == $_SESSION['user'] ){//only editor can see this page
		
			$type = 'editor';
		}
		else{		
				?>
				<script>alert('Normal users or authors can not view this page! ');</script>
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
	
	$labelsList = mysql_query("SELECT text	
							FROM label, has_label
							WHERE label.labelID = has_label.labelID AND
								has_label.pubID = '$pubID'
	");	
	
	if(isset($_POST['commentSubmitButton'])){
		
		?>
				<script>alert('Editor can not make comment! ');</script>
				<?php
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
<div align="right"><p><?php echo "editorReiz"; ?> </p> </div>
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
					<div>&nbsp;</div>
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
						<div>&nbsp;</div>
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
	
   <?php echo 'labels:'; 
		 while($rows=mysql_fetch_array($labelsList)){
			echo $rows[0];
			echo ',';
		 }?> 
 </div>
 
</div>

	
