<?php
	session_start();
	include_once 'dbconnect.php';

	// check if session variable user is set
	if(!isset($_SESSION['user'])){	
		header("Location: index.php");
		exit;
	}
	
	$userID =	$_SESSION['user'];
  	// check if it is really an editor who is trying to upload news
    //if not, return to login page
	$res=mysql_query("SELECT * FROM user,editor 
				WHERE user.userID = editor.userID AND user.userID = '$userID' ");
	$userRow = mysql_fetch_array($res);
	echo $userRow['username'];
  

	if($userRow['userID'] == $_SESSION['user'] )
		echo"home page for editor";
	else{
		header("Location: index.php");
		exit;
	}
	if(isset($_POST['homeButton'])){
			// go to same page (uploadNews page is home page for editor)
			header("Location: editorHomePage.php");
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
	if(isset($_POST['authorListButton'])){
		
		header("Location: authorList.php");
		exit;
		
	}
	if(isset($_POST['logoutButton'])){
		header("Location: logout.php?logout.php");
		exit;
	}
	
	if(isset($_POST['uploadButton'])){			
			if($_POST['categoryName'] == "" || $_POST['agentName'] == ""  ||   $_POST['title'] == "" 
											||  $_POST['subtitle'] == "" ||	$_POST['content'] == "" ){
					?>
					<script>alert("missing required fields!");</script>
					<?php
					
			}else{
				$categoryName =  mysql_real_escape_string($_POST['categoryName']);
				$agentName =  mysql_real_escape_string($_POST['agentName']);
				$title =  mysql_real_escape_string($_POST['title']);
				$subtitle =  mysql_real_escape_string($_POST['subtitle']);
				$labels =  mysql_real_escape_string($_POST['labels']);
				$content =  mysql_real_escape_string($_POST['content']);
				$videoLink =  mysql_real_escape_string($_POST['videoLink']);
				$photoLink = mysql_real_escape_string($_POST['photoLink']);
			
				//checking for category name value 
				$res=mysql_query("SELECT categoryID FROM category
									WHERE categoryName = '$categoryName' ");
				$row=mysql_fetch_array($res);
				if($row['categoryID'] != ''){
					$categoryID = $row['categoryID'];
				}else{
					?>
					<script>alert("this category does not exist!");</script>
					<?php
				}
			
				//now checking for agent
				$res=mysql_query("SELECT agentID FROM agent
								WHERE agentName = '$agentName' ");
				$row=mysql_fetch_array($res);
				if($row['agentID'] != ''){// that means everything is ok, we can make insertion to publication and news
					$agentID = $row['agentID'];
					//increase publish count of agent
					mysql_query(" UPDATE agent
								  SET publishCount = publishCount + 1
								  WHERE agentName = 'agentName'
					");
					if(mysql_query("INSERT INTO `publication`( `title`, `content`, `likeCount`, `readCount`, `categoryID`, `dislikeCount`) 
														VALUES('$title','$content',0,0,'$categoryID',0 ) ") ){
					
						$pubID = mysql_insert_id();
						mysql_query("INSERT INTO `news`(`pubID`, `agentID`, `subtitle`)   VALUES ('$pubID', '$agentID', '$subtitle' )");
						if($videoLink != "")
							mysql_query("INSERT INTO `video`( `pubID`, `link`) VALUES ('$pubID', '$videoLink')");
						if($photoLink != "")
							mysql_query("INSERT INTO `photo`( `pubID`, `photoLink`) VALUES ('$pubID', '$photoLink')");
						
						// insert into report table then
						$editorUserID = $_SESSION['user'];
						mysql_query("INSERT INTO `report`(`userID`, `agentID`, `pubID`) VALUES ( '$editorUserID'  ,'$agentID','$pubID')");
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
						}
				
					?>
					<script>alert("news is added successfully(aha dayýya sor)");</script>
					<?php
					}
					else{					
						?>
						<script>alert("something is wrong when inserting to publication table");</script>
						<?php					
					}
				}
				else{
					?>
					<script>alert("this agent does not exist!");</script>
					<?php
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
			echo "# of reports: ";
			echo "<br/>";
			echo $userRow['reportCount'];
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
<div class="row">
	
</div>
  </form>	 
</div>
</section>
  <div>
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
    <label for="textfield2">Agent:</label>
    <input type="text" name="agentName" id="textfield3">
        
</div>
<div align="left">
  <p class="col-md-offset-0 col-md-9">
    <label for="textfield2">Title:</label>
    <input type="text" name="title" id="textfield4">
        
</div>
<div align="left">
  <p class="col-md-offset-0 col-md-9">
    <label for="textfield2">Subtitle:</label>
    <input type="text" name="subtitle" id="textfield5">
        
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
        
</div>  
  <div align="left">
  <p class="col-md-offset-0 col-md-9">
    <label for="textfield2">Photo link:</label>
    <input type="text" name="photoLink" id="textfield6">	 
</div>
<div align="left">
  <p class="col-md-offset-0 col-md-9">
    <label for="textfield2">Video link:</label>
    <input type="text" name="videoLink" id="textfield6">
        
</div>

  
  <div align="center">
  <p class="col-md-offset-0 col-md-9">
    <button type="submit" name="uploadButton" class="btn btn-lg btn-default">UPLOAD</button>
			</form>
    
        
</div>
</body>
</html>
