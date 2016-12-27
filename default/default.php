<?php
include_once 'dbconnect.php';





?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>This is your business - Free Web Template</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<style type="text/css">
.auto-style1 {
	margin-top: 14px;
}
</style>
</head>
<body>
<div id="wrapper">
	<div id="header-wrapper">
		<div id="header">
			<div id="logo">
				<h1><img alt="" height="118" src="logo.png" width="988"></h1>
				<p>&nbsp;</p>
			</div>
		</div>
	</div>
	<!-- end #header -->
	<div id="menu-wrapper">
		<div id="menu">
			<ul>
				<li class="current_page_item"><a href="#">Home</a></li>
				<li><a href="#">NEWS</a><a href="#" style="width: 155px">CATEGORIES</a>I</li>
				<li><a href="#">AuTHORS</a></li>
				<li></li>
			</ul>
		</div>
	</div>
	<!-- end #menu -->
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="page-content">
					<div id="content">
						<div class="post">
							<h2 class="title">
							
							<?php		
							echo $res1['title']; 												
							?>
												
							</h2>
							<div class="entry">
						    <p>	
						    						
						    <?php		
							echo $res2['content']; 												
							?>	
							
							</p>
							</div>
						</div>
						<div class="post">
							<h2 class="title">
							
							<?php		
							echo $res3['title']; 												
							?>
												
							</h2>
							<div class="entry">
						    <p>	
						    						
						    <?php		
							echo $res4['content']; 												
							?>	
							
							</p>
						</div>
						<div class="post">
							<h2 class="title"><a href="#">Neque porro quisquam est</a></h2>
							<div class="entry">
							  <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,   adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et   dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum   exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi   consequatur? </p>
							</div>
						</div>
						<div style="clear: both;">&nbsp;</div>
					</div>
					<!-- end #content -->
				</div>
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
	<!-- end #page -->
</div>
<div id="footer">
	<p>Copyright &copy; 2012 YourSiteName.com. All rights reserved.</p>
</div>
<!-- end #footer -->
</body>
</html>
