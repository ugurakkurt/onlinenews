<?php
session_start();
include_once 'dbconnect.php';

// check if session variable user is set
if(!isset($_SESSION['user'])){	
		header("Location: index.php");
		exit;
}
	
 $userID =	$_SESSION['user'];
  	// check if it is really an editor who is visiting the editor home page
    //if not, return to login page
  $res=mysql_query("SELECT * 
					FROM user,editor 
				WHERE user.userID = editor.userID AND user.userID = '$userID' ");
  $userRow = mysql_fetch_array($res);
  echo $userRow['username'];
  

	if($userRow['userID'] == $_SESSION['user'] )
		echo"home page for editor";
	else{
		?>
			<script>alert('redirecting to login page ');</script>
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
	if(isset($_POST['categoryListButton'])){
		header("Location: categoriesPage.php");
		exit;
	}
	if(isset($_POST['videoListButton'])){
		?>
			<script>alert('pvideo ');</script>
			<?php
		header("Location: videoList.php");
		exit;	
	}	
	if(isset($_POST['authorListButton'])){
		header("Location: authorList.php");
		exit;	
	}	
	if(isset($_POST['uploadNewsButton'])){
		
		header("Location: uploadNews.php");
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
	$lastAddedNewsList = mysql_query("		SELECT publication.title, publication.date
											FROM news,publication
											WHERE news.pubID = publication.pubID
											ORDER BY publication.date DESC
											LIMIT 5
							");
	//var_dump($newsList);
		
	$lastAddedNewsArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($lastAddedNewsList)){
		$lastAddedNewsArray[$index] = $rows;
		$index++;
	}
	
	$waitingArticleList = mysql_query("SELECT publication.pubID, publication.title, publication.date
									FROM article,publication
									WHERE article.pubID = publication.pubID AND
									  article.isVisible = 0
									LIMIT 5
							");
	//var_dump($authorList);
		
	$waitingArticleArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($waitingArticleList)){
		$waitingArticleArray[$index] = $rows;
		$index++;
	}	
	
	
	
	//get the last added news list of editor
	$lastAddedNewsList = mysql_query("SELECT publication.title, news.subtitle, publication.pubID, publication.date
									FROM news,publication
									WHERE news.pubID = publication.pubID
									ORDER BY publication.date DESC
									LIMIT 5
						");	
	$lastAddedNewsArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($lastAddedNewsList)){
		$lastAddedNewsArray[$index] = $rows;
		$index++;
	}
	
	
	
	if(isset($_POST['acceptArticle1'])){
		
		$pubIDToBeAcceppted = $waitingArticleArray[0][0];
		//var_dump($pubIDToBeAcceppted);
		mysql_query(" UPDATE article
					  SET isVisible = 1
					  WHERE pubID = '$pubIDToBeAcceppted'
		");
		mysql_query(" UPDATE author
					  SET rate = rate + 25
					  WHERE userID  =( SELECT userID
									  FROM article
									  WHERE pubID ='$pubIDToBeAcceppted')
		");
			?>
			<script>alert('Article is approved');</script>
			<?php
		header("Refresh:0");
		exit;	
	}
	if(isset($_POST['acceptArticle2'])){
		
		$pubIDToBeAcceppted = $waitingArticleArray[1][0];
		//var_dump($pubIDToBeAcceppted);
		mysql_query(" UPDATE article
					  SET isVisible = 1
					  WHERE pubID = '$pubIDToBeAcceppted'
		");
		mysql_query(" UPDATE author
					  SET rate = rate + 25
					  WHERE userID  =( SELECT userID
									  FROM article
									  WHERE pubID ='$pubIDToBeAcceppted')
		");
			?>
			<script>alert('Article is approved');</script>
			<?php
		header("Refresh:0");
		exit;	
	}
	if(isset($_POST['acceptArticle3'])){
		
		$pubIDToBeAcceppted = $waitingArticleArray[2][0];
		//var_dump($pubIDToBeAcceppted);
		mysql_query(" UPDATE article
					  SET isVisible = 1
					  WHERE pubID = '$pubIDToBeAcceppted'
		");
		mysql_query(" UPDATE author
					  SET rate = rate + 25
					  WHERE userID  =( SELECT userID
									  FROM article
									  WHERE pubID ='$pubIDToBeAcceppted')
		");
			?>
			<script>alert('Article is approved');</script>
			<?php
		header("Refresh:0");
		exit;	
	}
	if(isset($_POST['acceptArticle4'])){
		
		$pubIDToBeAcceppted = $waitingArticleArray[3][0];
		//var_dump($pubIDToBeAcceppted);
		mysql_query(" UPDATE article
					  SET isVisible = 1
					  WHERE pubID = '$pubIDToBeAcceppted'
		");
		mysql_query(" UPDATE author
					  SET rate = rate + 25
					  WHERE userID  =( SELECT userID
									  FROM article
									  WHERE pubID ='$pubIDToBeAcceppted')
		");
			?>
			<script>alert('Article is approved');</script>
			<?php
		header("Refresh:0");
		exit;	
	}
	if(isset($_POST['acceptArticle5'])){
		
		$pubIDToBeAcceppted = $waitingArticleArray[4][0];
		//var_dump($pubIDToBeAcceppted);
		mysql_query(" UPDATE article
					  SET isVisible = 1
					  WHERE pubID = '$pubIDToBeAcceppted'
		");
		mysql_query(" UPDATE author
					  SET rate = rate + 25
					  WHERE userID  =( SELECT userID
									  FROM article
									  WHERE pubID ='$pubIDToBeAcceppted')
		");
			?>
			<script>alert('Article is approved');</script>
			<?php
		header("Refresh:0");
		exit;	
	}
	
	
	if(isset($_POST['disapproveArticle1'])){
		$pubIDToBeDeleted = $waitingArticleArray[0][0];
		mysql_query(" DELETE FROM has_label
					  WHERE pubID = '$pubIDToBeDeleted'
		");
		mysql_query(" UPDATE article
					  SET isVisible = -1
					  WHERE pubID = '$pubIDToBeDeleted'
		");
		mysql_query(" UPDATE author
					  SET rate = rate - 10
					  WHERE userID  =( SELECT userID
									  FROM article
									  WHERE pubID ='$pubIDToBeAcceppted')
		");
		?>
			<script>alert('Article is disapproved');</script>
			<?php
	}
	
	if(isset($_POST['disapproveArticle2'])){
		$pubIDToBeDeleted = $waitingArticleArray[1][0];
		mysql_query(" DELETE FROM has_label
					  WHERE pubID = '$pubIDToBeDeleted'
		");
		mysql_query(" UPDATE article
					  SET isVisible = -1
					  WHERE pubID = '$pubIDToBeDeleted'
		");
		mysql_query(" UPDATE author
					  SET rate = rate - 10
					  WHERE userID  =( SELECT userID
									  FROM article
									  WHERE pubID ='$pubIDToBeAcceppted')
		");
		?>
			<script>alert('Article is disapproved');</script>
			<?php
	}
	if(isset($_POST['disapproveArticle3'])){
		$pubIDToBeDeleted = $waitingArticleArray[2][0];
		mysql_query(" DELETE FROM has_label
					  WHERE pubID = '$pubIDToBeDeleted'
		");
		mysql_query(" UPDATE article
					  SET isVisible = -1
					  WHERE pubID = '$pubIDToBeDeleted'
		");
		mysql_query(" UPDATE author
					  SET rate = rate - 10
					  WHERE userID  =( SELECT userID
									  FROM article
									  WHERE pubID ='$pubIDToBeAcceppted')
		");
		?>
			<script>alert('Article is disapproved');</script>
			<?php
	}
	if(isset($_POST['disapproveArticle4'])){
		$pubIDToBeDeleted = $waitingArticleArray[3][0];
		mysql_query(" DELETE FROM has_label
					  WHERE pubID = '$pubIDToBeDeleted'
		");
		mysql_query(" UPDATE article
					  SET isVisible = -1
					  WHERE pubID = '$pubIDToBeDeleted'
		");
		mysql_query(" UPDATE author
					  SET rate = rate - 10
					  WHERE userID  =( SELECT userID
									  FROM article
									  WHERE pubID ='$pubIDToBeAcceppted')
		");
		?>
			<script>alert('Article is disapproved');</script>
			<?php
	}
	if(isset($_POST['disapproveArticle5'])){
		$pubIDToBeDeleted = $waitingArticleArray[4][0];
		mysql_query(" DELETE FROM has_label
					  WHERE pubID = '$pubIDToBeDeleted'
		");
		mysql_query(" UPDATE article
					  SET isVisible = -1
					  WHERE pubID = '$pubIDToBeDeleted'
		");
		mysql_query(" UPDATE author
					  SET rate = rate - 10
					  WHERE userID  =( SELECT userID
									  FROM article
									  WHERE pubID ='$pubIDToBeAcceppted')
		");
		?>
			<script>alert('Article is disapproved');</script>
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
  
  
 
<form method="post">
  <div id="logout" align="right">
    <input type="submit" name="logoutButton" id="button" value="LOG OUT" >
    </form>
  </div>
</div>
  <div><img src="photo/logo.png" width="900" height="163" alt=""/></div>
<section class="sidebar"  align="right">
    <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
    <div class="row">
	<form method="post">
      <div class="col-md-1" align="center">
        <button type="submit" name="homeButton"  class="btn btn-info">&nbsp;HOME</button>
      </div>
      <div class="col-md-1 col-md-offset-0" align="center">
        <button type="submit" name="generalNewsButton" class="btn btn-info">NEWS</button>
      </div>
      <div class="col-md-offset-0 col-md-1">
        <button type="submit" name="videoListButton" class="btn btn-info">VIDEOS</button>
      </div>
      <div class="col-md-offset-0 col-md-1">
        <button type="submit" name="categoryListButton" class="btn btn-info">CATEGORIES</button>
      </div>
      <div class="col-md-offset-1 col-md-1">
        <button type="submit" name="authorListButton" class="btn btn-info">AUTHORS</button>
      </div>
      <div class="col-md-offset-10 col-md-1">
        <input type="submit" name="uploadNewsButton" id="button" value="UPLOAD NEWS" >
      </div>
	  <form method="post">
      
	</div>
</section>
  <div class="row">
            <div class="col-md-11">
		
 	  </div>
 	<div class="row">
        <div class="col-md-10">
        <td>
		<form method="post">
        <form>
              <label for="textfield">Search News:</label>
              <input type="text" name="labelTextForNews" id="textfield">
       
              <input type="submit" name="searchNewsButton" id="button" value="search news" >
        </form>
		</form>
        </td>
        </div>
          
        <div class="col-md-10">
        <td>
		<form method="post">
        <form>
          	<label for="textfield">Search Articles:</label>
          	<input type="text" name="labelTextForArticle" id="textfield">
        
            <input type="submit" name="searchArticleButton" id="button" value="search article" >
        </form>
		</form>
        </td>
        </div>
                
      </div>
<div>&nbsp;</div>
<div align="right">
	<h1>Number of News published: <?php echo $userRow['reportCount']; ?> </h1>
</div>


<div>&nbsp;</div>



<div class="container">
<div class="row">
	<div class="col-md-6" align="left">
    	  <div class="col-md-5" align="left">
   		  		<p>LAST ADDED NEWS </p>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                
                <?php if(isset($lastAddedNewsArray[0][0])) $title = $lastAddedNewsArray[0][0]; ?>
				<?php if(isset($lastAddedNewsArray[0][2])) echo "<a href= viewNewsForEditor.php?pubID=",$lastAddedNewsArray[0][2],">$title </a>"; ?>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <?php if(isset($lastAddedNewsArray[1][0])) $title = $lastAddedNewsArray[1][0]; ?>
                <?php if(isset($lastAddedNewsArray[1][2])) echo "<a href= viewNewsForEditor.php?pubID=",$lastAddedNewsArray[1][2],">$title </a>"; ?>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <?php if(isset($lastAddedNewsArray[2][0])) $title = $lastAddedNewsArray[2][0]; ?>
                <?php if(isset($lastAddedNewsArray[2][2])) echo "<a href= viewNewsForEditor.php?pubID=",$lastAddedNewsArray[2][2],">$title </a>"; ?>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <?php if(isset($lastAddedNewsArray[3][0])) $title = $lastAddedNewsArray[3][0]; ?>
                <?php if(isset($lastAddedNewsArray[3][2])) echo "<a href= viewNewsForEditor.php?pubID=",$lastAddedNewsArray[3][2],">$title </a>"; ?>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <?php if(isset($lastAddedNewsArray[4][0])) $title = $lastAddedNewsArray[4][0]; ?>
                <?php if(isset($lastAddedNewsArray[4][2])) echo "<a href= viewNewsForEditor.php?pubID=",$lastAddedNewsArray[4][2],">$title </a>"; ?>
              </div>
         </div>   
     
     <div class="col-md-6" align="left">
     
        <p>REQUESTS FOR ARTICLES </p>
        <div>&nbsp;</div>
        <div>&nbsp;</div>
		<form method="post">
        <td>
        <form>
		<?php if(isset($waitingArticleArray[0][1])) $articleTitle = $waitingArticleArray[0][1]; ?>
		<p ><font size="6"><p><?php if(isset($waitingArticleArray[0][0])) echo "<a href= viewArticleForEditor.php?pubID=",$waitingArticleArray[0][0],">$articleTitle </a>"; ?>
        <?php if(isset($waitingArticleArray[0][1])){ ?> <input type="submit" name = "acceptArticle1" value="Add">  <input type="submit" name = "disapproveArticle1" value="No"></form><?php }?>
		</td>
        <div>&nbsp;</div>
        <div>&nbsp;</div>
        </form>
		<form method="post">
        <td>
        <form>
		
		<?php if(isset($waitingArticleArray[1][1])) $articleTitle = $waitingArticleArray[1][1]; ?>
		<p ><font size="6"><p><?php if(isset($waitingArticleArray[1][0])) echo "<a href= viewArticleForEditor.php?pubID=",$waitingArticleArray[1][0],">$articleTitle </a>"; ?>
        <?php if(isset($waitingArticleArray[1][1])){ ?> <input type="submit" name = "acceptArticle2" value="Add">  <input type="submit" name = "disapproveArticle2" value="No"></form><?php }?>
		</td>
        <div>&nbsp;</div>
        <div>&nbsp;</div>
		<form method="post">
        <td>
		
        <form>
		<?php if(isset($waitingArticleArray[2][1])) $articleTitle = $waitingArticleArray[2][1]; ?>
		<p ><font size="6"><p><?php if(isset($waitingArticleArray[2][0])) echo "<a href= viewArticleForEditor.php?pubID=",$waitingArticleArray[2][0],">$articleTitle </a>"; ?>
        <?php if(isset($waitingArticleArray[2][1])){ ?> <input type="submit" name = "acceptArticle3" value="Add">  <input type="submit" name = "disapproveArticle3" value="No"></form><?php }?>
		</td>
        <div>&nbsp;</div>
        <div>&nbsp;</div>
		</form>
        <td>
		<form method="post">
        <form>
		<?php if(isset($waitingArticleArray[3][1])) $articleTitle = $waitingArticleArray[3][1]; ?>
		<p ><font size="6"><p><?php if(isset($waitingArticleArray[3][0])) echo "<a href= viewArticleForEditor.php?pubID=",$waitingArticleArray[3][0],">$articleTitle </a>"; ?>
        <?php if(isset($waitingArticleArray[3][1])){ ?> <input type="submit" name = "acceptArticle4" value="Add">  <input type="submit" name = "disapproveArticle4" value="No"></form><?php }?>
		</td>
        <div>&nbsp;</div>
        <div>&nbsp;</div>
		</form>
        <td>
		<form method="post">
        <form>
		<?php if(isset($waitingArticleArray[4][1])) $articleTitle = $waitingArticleArray[4][1]; ?>
		<p ><font size="6"><p><?php if(isset($waitingArticleArray[4][0])) echo "<a href= viewArticleForEditor.php?pubID=",$waitingArticleArray[4][0],">$articleTitle </a>"; ?>
        <?php if(isset($waitingArticleArray[4][1])){ ?> <input type="submit" name = "acceptArticle5" value="Add">  <input type="submit" name = "disapproveArticle5" value="No"></form><?php }?>
		
		</td>
		</form>
        

      </div>
      </form>
                  
                      
    
             			
                    
                  
   </div>
             
</div>    
    
   
 



