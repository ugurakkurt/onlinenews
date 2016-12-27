<?php
	session_start();
	include_once 'dbconnect.php';
    
	if(!isset($_SESSION['user'])){	
		?>
			<script>alert("hadi lann ");</script>
			<?php
		header("Location: index.php");
		exit;
	}
	$type = '';
	$userID = $_SESSION['user'];
	//if session variable user is not set, then go to login page
	
	
	// check if it is really registered user who is visiting the page
    //if not, return to login page
	$res=mysql_query("SELECT * FROM user,registered_user 
						WHERE user.userID = registered_user.userID AND user.userID = '$userID' ");
	$userRow = mysql_fetch_array($res);
	
	
	if($userRow['userID'] == $_SESSION['user'] ){
		echo"video list for normal users";
		$type = 'normaluser';
	}
		
	else{
		
		$res=mysql_query("SELECT * FROM editor,user
							WHERE editor.userID = user.userID");
		$userRow = mysql_fetch_array($res);
		if($userRow['userID'] == $_SESSION['user'] ){
			echo"video list for editor";
			$type = 'editor';
		}
		else{
			
			
			$res=mysql_query("SELECT * FROM user,author 
						WHERE user.userID = author.userID AND user.userID = '$userID' ");
			$userRow = mysql_fetch_array($res);
			if($userRow['userID'] == $_SESSION['user'] ){
				echo"video list for author";
				$type = 'author';
			}
			else{
				?>
				<script>alert('no hard feelings ');</script>
				<?php
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

	if(isset($_POST['categoriesButton'])){
		header("Location: categoriesPage.php");
		exit;
	}
	if(isset($_POST['generalNewsButton'])){
		
		header("Location: generalnewsList.php");
		exit;
		
	}
	if(isset($_POST['authorsButton'])){
		
		header("Location: authorList.php");
		exit;
		
	}	
	if(isset($_POST['videosButton'])){
		
		header("Location:videoList.php");
		exit;
		
	}	
	if(isset($_POST['logoutButton'])){
		header("Location: logout.php?logout.php");
		exit;
	}
	
	$videoList = mysql_query("SELECT video.videoID, news.subtitle, publication.date, video.link
							FROM video,publication,news 
							WHERE news.pubID = video.pubID AND publication.pubID = news.pubID
							ORDER BY publication.date DESC
							LIMIT 20
							");
	//var_dump($videoList);
		
	$videoArray = array();
	$index = 0;
	while($rows=mysql_fetch_array($videoList)){
		$videoArray[$index] = $rows;
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
  	<input type="submit" name="logoutButton" id="button" value="Sign Out" >
    <p><?php if($type == 'editor' ){ echo $userRow['username'];}
			  else if($type == 'author') {echo $userRow['username'];}
			  else if ($type == 'normaluser') {echo $userRow['username'];}
			
			?></p> 
</div>
  <div><img src="photo/logo7.png" width="720" height="134" alt=""/></div>
<section class="sidebar"  align="right">
    <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
    <div class="row">
		<form method="post">
      <div class="col-md-2" align="center">
       <button type="submit" name="homeButton"  class="btn btn-info">Home</button>
      </div>
      <div class="col-md-2" align="center">
        <button type="submit" name="generalNewsButton" class="btn btn-info">News</button>
      </div>
      <div class="col-md-offset-0 col-md-2">
        <button type="submit" name="videosButton"class="btn btn-info">Videos</button>
      </div>
      <div class="col-md-offset-0 col-md-3">
        <button type="submit" name="categoriesButton"class="btn btn-info">Categories</button>
      </div>
      <div class="col-md-offset-0 col-md-2">
        <button type="submit" name="authorsButton"class="btn btn-info">Authors</button>
      </div>
	  
      <div class="col-md-1"></div>
      <div class="col-md-1"></div>
      <div class="col-md-1"></div>
	  </form>
    </div>

	    <p>&nbsp;</p>
		    <p>&nbsp;</p>

    <div class="row">
    <div class="col-lg-6" align="left">
    <p>&nbsp;</p>
    <p align=center style="font-size:20px">Link&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
	  <?php if(isset($videoArray[0][0])) $videoLink = $videoArray[0][3]; ?>
    <p><font style="font-size:20px"> <?php if(isset($videoArray[0][3])) echo "<a href= ",$videoArray[0][3],">$videoLink </a>"; ?> </a></font></p>
    </div>
    <p>&nbsp;</p>
    <p align=left style="font-size:20px">Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date</p>
	<p align=left> <?php echo $videoArray[0][1]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $videoArray[0][2] ; ?></p> 
	</div>
    <p>&nbsp;</p>
    
    <div class="row">
    <div class="col-lg-6" align="left">
    <p>&nbsp;</p>
    <p align=center style="font-size:20px">Link&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
		  <?php if(isset($videoArray[1][0])) $videoLink = $videoArray[1][3]; ?>
    <p><font style="font-size:20px"> <?php if(isset($videoArray[1][3])) echo "<a href= ",$videoArray[1][3],">$videoLink </a>"; ?> </a></font></p>
    </div>
    <p>&nbsp;</p>
    <p align=left style="font-size:20px">Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date</p>
	<p align=left> <?php echo $videoArray[1][1]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $videoArray[1][2] ; ?></p> 
	</div>
    <p>&nbsp;</p>
    
	
    <div class="row">
    <div class="col-lg-6" align="left">
    <p>&nbsp;</p>
    <p align=center style="font-size:20px">Link&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	 
	<?php if(isset($videoArray[2][0])) $videoLink = $videoArray[2][3]; ?>
    <p><font style="font-size:20px"> <?php if(isset($videoArray[2][3])) echo "<a href= ",$videoArray[2][3],">$videoLink </a>"; ?> </a></font></p>
    </div>
    <p>&nbsp;</p>
    <p align=left style="font-size:20px">Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date</p>
	<p align=left> <?php echo $videoArray[2][1]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $videoArray[2][2] ; ?></p> 
	</div>
    <p>&nbsp;</p>
 
    <div class="row">
    <div class="col-lg-6" align="left">
    <p>&nbsp;</p>
    <p align=center style="font-size:20px">Link&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
		  <?php if(isset($videoArray[3][0])) $videoLink = $videoArray[3][3]; ?>
    <p><font style="font-size:20px"> <?php if(isset($videoArray[3][3])) echo "<a href= ",$videoArray[3][3],">$videoLink </a>"; ?> </a></font></p>
    </div>
    <p>&nbsp;</p>
    <p align=left style="font-size:20px">Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date</p>
	<p align=left> <?php echo $videoArray[3][1]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $videoArray[3][2] ; ?></p> 
	</div>
    <p>&nbsp;</p>
	
	
	    <div class="row">
    <div class="col-lg-6" align="left">
    <p>&nbsp;</p>
    <p align=center style="font-size:20px">Link&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
	<?php if(isset($videoArray[4][0])) $videoLink = $videoArray[4][3]; ?>
    <p><font style="font-size:20px"> <?php if(isset($videoArray[4][3])) echo "<a href= ",$videoArray[4][3],">$videoLink </a>"; ?> </a></font></p>
    </div>
    <p>&nbsp;</p>
    <p align=left style="font-size:20px">Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date</p>
	<p align=left> <?php echo $videoArray[4][1]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $videoArray[4][2] ; ?></p> 
	</div>
    <p>&nbsp;</p>
 

      
</section>
   
</body>
</html>
