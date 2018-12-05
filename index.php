<?php 
require_once('authenticate.php'); /* this is used for security purposes */
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
		<title>Meeter Web Application</title>
		<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
		<link rel="stylesheet" type="text/css" href="css/screen_layout_large.css" />
		<link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:500px)"   href="css/screen_layout_small.css" />
		<link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width:800px)"  href="css/screen_layout_medium.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="js/farinspace/jquery.imgpreload.min.js"></script>
		<script type="text/javascript" src="js/design.js"></script>
		
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
				<a href="adminMeeter.php">ADMIN</a>
				<a href="logout.php">[ LOGOUT ]</a>
			</nav>
			<article>
    			<img src='images/cr_splash_590x250.jpg'></img><br/><br/>
    			This web application is designed explicitly for your<br/>
    			Celebrate Recovery ministry. For further information regarding<br/>
    			this site or its contents please contact <a href='mailto:dano@dcolombo.com'>Dano</a>
			</article>
			<footer>
				&copy; 2013-2018 Rogue Intelligence
			</footer>
</div>
</body>
</html>