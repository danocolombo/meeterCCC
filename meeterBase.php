<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include 'database.php';
// ---------------------------------------------------
// meeterBase.php
// ---------------------------------------------------
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport"
	content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
<title>Meeter Web Application</title>
<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
<link rel="stylesheet" type="text/css"
	href="css/screen_layout_large.css" />
<link rel="stylesheet" type="text/css"
	media="only screen and (min-width:50px) and (max-width:500px)"
	href="css/screen_layout_small.css" />
<link rel="stylesheet" type="text/css"
	media="only screen and (min-width:501px) and (max-width:800px)"
	href="css/screen_layout_medium.css" />

<!-- jquery styles -->
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
<link rel="stylesheet" type="text/css"
	href="css/jquery-ui.structure.css" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.css" />

<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
<script type="text/javascript" src="js/jquery/jquery-ui.js"></script>

</head>
</html>
<script type="text/javascript" src="js/farinspace/jquery.imgpreload.min.js"></script>
		<meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
                <meta http-equiv="pragma" content="no-cache" />
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="page">
			<header>
				<div id="hero"></div>
				<a class="logo" title="home" href="index.php"><span></span></a>
			</header>
			<nav>
				<a href="meetings.php">Meetings</a>
				<a href="people.php">People</a>
				<a href="teams.php">Teams</a>
				<a href="leadership.php">Leadership</a>
				<a href="reportlist.php">Reporting</a>
				<a href="#">ADMIN</a>
				<a href="logout.php">[ LOGOUT ]</a>
			</nav>
			<article>


			</article>
			<footer>
				&copy; 2013-2018 Rogue Intelligence
			</footer>
		</div>
		<script type="text/javascript">
			$(function(){
				/******************
				this is where we initialize the jquery components
				*****************/

				
			});
		</script>
	</body>
</html>
