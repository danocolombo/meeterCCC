<?php
require_once('authenticate.php'); /* for security purposes */
/*
 * reportlist.php
 * ======================================================
 * this uses pageHead.txt, pageTop.txt & pageBottom.txt
 */
/*****
require_once("classPage.php");

$page = new Page();
print $page->getTop();
print <<<EOF
**********/
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
				<a href="#">ADMIN</a>
				<a href="logout.php">[ LOGOUT ]</a>
			</nav>
			<article>

<div id="mainContent" style="padding:15px;"><center>
<h2>Report Listing</h2>
This is the listing of current reports, grouped in categories: To get specific 
information not provided in the reports below, contact Dano<br/><br/>
<hr/>
<h1>People's Interests</h1>
<table border='2'><tr><td>
<table id='reporttable'>
<tr>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=FellowshipInterest'>Fellowship</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=PrayerInterest'>Prayer</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=NewcomersInterest'>Newcomers (101)</td>
</tr>
<tr>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=GreetingInterest'>Greeting</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=SpecialEventsInterest'>Special Events</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=ResourceInterest'>Resources</td>
<tr>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=SmallGroupInterest'>Open Share</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=StepStudyInterest'>Step-Study</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=TransportationInterest'>Transportation</td>
<tr>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=WorshipInterest'>Worship</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=LandingInterest'>The Landing</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=CelebrationPlaceInterest'>Celebration Place</td>
</tr>
<tr>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=SolidRockInterest'>Crosstalk Cafe</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=MealInterest'>Meals</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=TeachingTeam'>Teaching</td>
    <td></td>
</tr>
</table>
</td></tr></table>
<hr/>
<h1>The Numbers...</h1>
<table border='2'><tr><td>
<table id='reporttable'>
<tr>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=MealCnt'>Meal</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=NurseryCnt'>Nursery</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=101Cnt'>Newcomers (101)</td>
</tr>
<tr>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=CSCnt'>Celebration Place</td>
    <td id='reportcell'><a style='text-decoration:none;' href='reports.php?Report=LandingCnt'>The Landing</td>
    <td id='reportcell'></td>
</tr>
</table>
</td></tr></table>
</center></div>
</article>
			<footer>
				&copy; 2013-2018 Rogue Intelligence
			</footer>
</div>
</body>
</html>