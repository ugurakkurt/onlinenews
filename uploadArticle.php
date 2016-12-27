<?php
	session_start();
	include_once 'dbconnect.php';

	// check if session variable user is set
	if(!isset($_SESSION['user'])){	
		header("Location: index.php");
		exit;
	}
	
	$userID =	$_SESSION['user'];
  	// check if it is really an author who is trying to upload news
    //if not, return to login page
	$res=mysql_query("SELECT * FROM user,author
				WHERE user.userID = author.userID AND user.userID = '$userID' ");
	$userRow = mysql_fetch_array($res);
	echo $userRow['username'];
	$authorName = $userRow['username'];
  

	if($userRow['userID'] == $_SESSION['user'] )
		echo " home page for author";
	else{
		header("Location: index.php");
		exit;
	}
	if(isset($_POST['homeButton'])){
		header("Location: authorHomePage.php");
		exit;
	}
	if(isset($_POST['authorListButton'])){
		header("Location:authorListForAuthorsButton.php");
		exit;
	}

	if(isset($_POST['categoriesButton'])){
		header("Location: categoriesPage.php");
		exit;
	}
	if(isset($_POST['generalNewsButton'])){		
		header("Location: generalnewsList.php");
		exit;
		
	}
	if(isset($_POST['logoutButton'])){
		header("Location: logout.php?logout.php");
		exit;
	}
	
	if(isset($_POST['uploadButton'])){			
			if($_POST['categoryName'] == "" ||  $authorName == "" || $_POST['title'] == "" ||	$_POST['content'] == "" ){
					?>
					<script>alert("missing required fields!");</script>
					<?php
					
			}else{
				$categoryName =  mysql_real_escape_string($_POST['categoryName']);
				$title =  mysql_real_escape_string($_POST['title']);
				$labels =  mysql_real_escape_string($_POST['labels']);
				$content =  mysql_real_escape_string($_POST['content']);
			
				//checking for category name value 
				$res=mysql_query("SELECT categoryID FROM category
									WHERE categoryName = '$categoryName' ");
				$row=mysql_fetch_array($res);
				if($row['categoryID'] != ''){
					$categoryID = $row['categoryID'];
				}else{
					?>
					<script>alert(" This category does not exist!");</script>
					<?php
				}
			
				//now checking for author
				$res=mysql_query("SELECT userID FROM author
								WHERE userID = '$userID' ");
				$row=mysql_fetch_array($res);
				if($row['userID'] != ''){// that means everything is ok, we can make insertion to publication and article
					$authorID = $row['userID'];
					if(mysql_query("INSERT INTO `publication`( `title`, `content`, `likeCount`, `readCount`, `categoryID`, `dislikeCount`)
														VALUES('$title','$content',0,0,'$categoryID',0 ) ") ){

						$pubID = mysql_insert_id();
						mysql_query("INSERT INTO `article`(`pubID`, `userID`, `isVisible`)   VALUES ('$pubID', '$authorID', 0 )");
						
						$editorUserID = $_SESSION['user'];
						mysql_query("INSERT INTO `approve`(`userID`, `pubID`) VALUES ( '$editorUserID'  ,'$pubID')");
						
						//now insert labels
						if($labels != ""){
							$labelList = explode(",", $labels);
							$size = count($labelList);
							for ($i = 0; $i < $size; $i++) {
								if('$labelList[$i]' != ''){
								
									if(mysql_query("INSERT INTO `label`( `text`) VALUES ('$labelList[$i]')")){
										// if label is inserted successfully	
										$labelID = mysql_insert_id();
										mysql_query("INSERT INTO `has_label`(`labelID`, `pubID`) VALUES ('$labelID','$pubID' )");
									}
									else {// if label already exist in the table
										//get the label id first using label name which is known
										$labelID = mysql_query("SELECT labelID FROM label WHERE text = '$labelList[$i]' ");
										$labellID = mysql_fetch_row($labelID);
										//insert into has_label
										mysql_query("INSERT INTO `has_label`(`labelID`, `pubID`) VALUES ('$labellID[0]','$pubID' )");
									}	
								}	
							}
						} ?>
						<script>alert(" article is added successfully ");</script>
						<?php
						mysql_query(" UPDATE author
									  SET publishCount = publishCount + 1
									  WHERE userID = '$userID'
									");
						
					}
					else{	?>	
						<script>alert("something is wrong when inserting to publication table");</script> <?php
					}
				}
				else{ ?>
					<script>alert("this author does not exist!");</script> <?php
				}
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
<link href="css/eCommerceStyle3.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap3.css" rel="stylesheet" type="text/css">
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
  	<input type="submit" name="logoutButton" id="button" value="Log Out" >
    <p><?php echo $userRow['username'];
			echo "# of publish: ";
			echo "<br/>";
			$publishCounttt = mysql_query("SELECT count(pubID)
								FROM article
								WHERE userID = '$userID'
					
								") ;
			$publishCountt = mysql_fetch_array($publishCounttt);
			echo $publishCountt[0];
	?></p> 
	</form>
</div>

		<div><img src="photo/logo4.png" width="720" height="134" alt=""/></div>
	<section class="sidebar"  align="right">
    <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
    <div class="row">
      <div class="col-md-2" align="center">
		<form method="post">
        <button type="submit" name="homeButton" class="btn btn-info">Home</button>
      </div>
      <div class="col-md-2" align="center">
        <button type="submit" name="generalNewsButton" class="btn btn-info">News</button>
      </div>
      <div class="col-md-1">
        <button type="submit" name="videoListButton" class="btn btn-info">Videos</button>
      </div>
      <div class="col-md-offset-0 col-md-3">
        <button type="submit" name="categoriesButton" class="btn btn-info">Categories</button>
      </div>
      <div class="col-md-offset-0 col-md-2">
        <button type="submit" name="authorListButton" class="btn btn-info">Authors</button>
		</form>
      </div>
      <div class="col-md-1"></div>
      <div class="col-md-1"></div>
      <div class="col-md-1"></div>
    </div>
    <div>

</section>
  <form method="post">
<div align="left">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p class="col-md-offset-0 col-md-9">
    <label for="textfield2">Category:</label>
    <input type="text" name="categoryName" id="textfield2">
        
</div>

<div align="left">
  <p class="col-md-offset-0 col-md-9">
    <label for="textfield2">Title:</label>
    <input type="text" name="title" id="textfield4">
        
</div>


<div align="left">
  <p class="col-md-offset-0 col-md-9">
    <label for="textarea">Content:</label>
  <textarea name="content" cols="70" rows="8"></textarea>
  </div>
  
<div align="left">
  <p class="col-md-offset-0 col-md-9">
    <label for="textfield2">labels(put "," between labels):</label>
    <input type="text" name="labels" id="textfield6">


  
  <div align="center">
  <p class="col-md-offset-0 col-md-9">
    <button type="submit" name="uploadButton" class="btn btn-lg btn-default">UPLOAD ARTICLE</button>
			</form>
    
        
</div>
</body>
</html>
