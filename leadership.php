<?php
require_once('authenticate.php'); /* for security purposes */
include 'database.php';
require_once 'HTML/Table.php';
/*
 * training.php
 * ======================================================
 * this uses pageHead.txt, pageTop.txt & pageBottom.txt
 */

//require_once("classPage.php");
//
//$page = new Page();
//print $page->getTop();

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//new header start of page
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
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
<?php
echo "<center><h1>Leadership Meetings</h1>";

if($mysqli->errno > 0){
    printf("Mysql error number generated: %d", $mysqli->errno);
    exit();
}


$query = "SELECT training.ID, training.tDate, training.tTitle, training.tLocation, training.tInstructor1,
    training.tInstructor2, training.tNotes FROM training ORDER BY training.tDate";

$meetings = array();

$result = $mysqli->query($query);

while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
    $meetings[] = array($row['ID'], $row['tDate'], $row['tTitle'], $row['tLocation'], $row['tInstructor1'], $row['tInstructor2'], $row['tNotes']);
    
}

for($cnt=0;$cnt<$result->num_rows;$cnt++){
    $mtg[$cnt][0] = "&nbsp;<a href='ldrForm.php?ID=" . $meetings[$cnt][0] . "'>" . $meetings[$cnt][1] . "  </a>&nbsp;"; /* Date */
    $mtg[$cnt][1] = "&nbsp;&nbsp;" . $meetings[$cnt][2] . "&nbsp;&nbsp;"; /* Title */
    $mtg[$cnt][2] = "&nbsp;&nbsp;" . $meetings[$cnt][3] . "&nbsp;"; /* Location */
}

// create an array of table attributes
$attributes = array('border' => '1', 'id' => 'trainingdata', 'align' => 'center', 'text-align' => 'center');

//create the table object
$table = new HTML_Table($attributes);

//set the headers
$table->setHeaderContents(0,0, "Date");
$table->setHeaderContents(0,1, "Title");
$table->setHeaderContents(0,2, "Location");

//cycle through the array to produce the table data

for($rownum = 0; $rownum < count($mtg); $rownum++){
    for($colnum = 0; $colnum < 3; $colnum++){
        $table->setCellContents($rownum+1, $colnum, $mtg[$rownum][$colnum]);
    }
}
$table->altRowAttributes(1,null, array("class"=>"alt"));

/* add a link to enter a new meeting record */
echo "<div style='text-align:right; padding-right: 20px;'><a href='ldrForm.php?Action=New'>NEW ENTRY</a></div>";

//output the data
echo "<div>";
echo $table->toHTML();
/**** print the records returned  */
printf("There were %d meetings found", $result->num_rows);
echo "</div>";
/* display the bottom of the page */
//print $page->getBottom();
//
//$result->free();
?>
</article>
    <footer>
            &copy; 2013-2018 Rogue Intelligence
    </footer>
</div>
</body>
</html>
