<?php
require_once('authenticate.php'); /* for security purposes */
include 'database.php';
define('DEBUG','0');
/*
 * trnForm.php
 * ==============================================
 * displays for to enter and edit training sessions
 */
// - MEETER: require_once("classPage.php");

/*-----------------------------------------------
 * display the top of the form
 *---------------------------------------------*/
//$page = new Page();
//print $page->getTop();
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
		<script src="php_calendar/scripts.js" type="text/javascript"></script>
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
$TID = $_GET["ID"];
if ($TID > 0){
    /*------------------------------------------------
     * this section will get the training ID from the
     * url and display it for the user
     ===============================================*/
   //include 'mysql.connect.php';
   if($mysqli->errno > 0){
       printf("Mysql error number generated: %d", $mysqli->errno);
       exit();
   }
    $query = "SELECT * FROM training WHERE ID = " . $TID;
    // new list
    $result = $mysqli->query($query, MYSQLI_STORE_RESULT);
    
    list($ID, $tTitle, $tDate, $tLocation, $tInstructor1, $tInstructor2, $tNotes) = $result->fetch_row();
  
    
    /* start the form */
    echo "<form id='ldrForm' action='ldrAction.php?Action=Update&ID=" . $ID . "' method='post'>";
    
    echo "<center><h2>EDIT LEADERSHIP SESSION</h2></center>";
    echo "<center>";
    echo "<table border='0'>";
    echo "<tr><td colspan='2' align='right' border='1'>" . $ID . "</td></tr>";
    echo "<tr><td align='right'>Date:</td><td><input type='text' name='tDate' size='15' 
        value='" . $tDate . "' /></td></tr>";
    echo "<tr><td align='right'>Title:</td><td>";
    echo "<input type='text' name='tTitle' size='20' value='". htmlspecialchars($tTitle) . "' /></td></tr>";
             
        
    echo "<tr><td align='right'>Location:</td><td><input type='text' name='tLocation' size='40' value='" . htmlspecialchars($tLocation) . "'/></td></tr>";
    /** GET PEOPLE */
    /*==========================================================
     * need to load array with people names to put in dropdown
     =========================================================*/
    if($mysqli->errno > 0){
        printf("Mysql error number generated: %d", $mysqli->errno);
        exit();
    }
    $query = "SELECT ID, FName, LName FROM people ORDER BY FName";
    $peeps = array();
    $result = $mysqli->query($query);
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        $peeps[] = array($row['ID'], $row['FName'], $row['LName'], );

    }
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        $peep[$cnt][0] = $peeps[$cnt][0]; /* ID */
        if (sizeof($peeps[$cnt][2] >0)){
            $peep[$cnt][1] = $peeps[$cnt][1] . " " . $peeps[$cnt][2]; /* name */
        }else{
            $peep[$cnt][1] = $peeps[$cnt][1]; /* first name */
        }
    }    
    
    /*********************
     * Instructor 1
     * *******************
     */
    echo "<tr><td align='right'>Instructor1:</td><td align='left'><select name='tInstructor1'>";
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        echo "<option value='" . $peep[$cnt][0] . "'";
        if($tInstructor1 == $peep[$cnt][0]){
            echo " selected = 'selected'";
        }
        echo ">" . $peep[$cnt][1] . "</option>";
    }
    echo "</select>&nbsp;&nbsp;<a href='people.asp?Action=New'><b>[ NEW ]</b></a></td></tr>";    
    /*********************
     * Instructor 2
     * *******************
     */
    echo "<tr><td align='right'>Instructor 2:</td><td align='left'><select name='tInstructor2'>";
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        echo "<option value='" . $peep[$cnt][0] . "'";
        if($tInstructor2 == $peep[$cnt][0]){
            echo " selected = 'selected'";
        }
        echo ">" . $peep[$cnt][1] . "</option>";
    }
    echo "</select>&nbsp;&nbsp;<a href='people.asp?Action=New'><b>[ NEW ]</b></a></td></tr>";
    echo "<tr><td align='right' valign='top'>Notes:</td><td><textarea name='tNotes' rows='5' cols='40'>" . $tNotes . "</textarea></td></tr>";
    
    echo "<tr><td></td><td><input type='submit' value='Ok' size='10'/></td></tr>";
    echo "</table>";
    
    echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=TraineeList&TID=" . $TID . "'><img src='images/addpeepbutton.jpg' width='50px'></img></a></div>";
    /********************************************************
     * display a list of trainees for training session
     * ******************************************************
     */
    $query = "SELECT people.ID, people.FName, people.LName FROM people INNER JOIN trainees ON trainees.PID
        = people.ID WHERE trainees.TID = '" . $TID . "' ORDER BY people.FName";
    
    if($mysqli->errno > 0){
       printf("Mysql error number generated: %d", $mysqli->errno);
       exit();
    }
    $result = $mysqli->query($query, MYSQLI_STORE_RESULT);
    
    echo "<table>";
    while(list($ID, $FName, $LName) = $result->fetch_row()){
           echo "<tr><td>";
           echo "<a href='ldrAction.php?Action=RemoveTrainee&TID=" . $TID . "&PID=". $ID . "'><img src='images/minusbutton.gif'></img></a></td>";
           echo "<td>&nbsp;&nbsp;" . $FName . " " . $LName . "</td></tr>";
    }
    echo "</table>";
   
    
    
    
    
    
    
    
    
}else{
    include 'database.php';
    /* start the form */
    echo "<form id='ldrForm' action='ldrAction.php?Action=AddNew' method='post'>";
    
    echo "<center><h2>NEW LEADERSHIP MEETING</h2></center>";
    echo "<center>";
    echo "<table border='0'>";
    echo "<tr><td align='right'>Date:</td><td><input type='text' name='tDate' id='date' size='15' />
            <a href='javascript:viewcalendar()' style='text-decoration:none'>
        <img src='images/cal-icon.gif' vspace='0' align='ABSBOTTOM'/></a></td></tr>";
    echo "<tr><td align='right'>Title:</td><td>";
    echo "<input type='text' name='tTitle' size='20' /></td></tr>";
             
        
    echo "<tr><td align='right'>Location:</td><td><input type='text' name='tLocation' size='40' /></td></tr>";
    /** GET PEOPLE */
    /*==========================================================
     * need to load array with people names to put in dropdown
     =========================================================*/
    if($mysqli->errno > 0){
        printf("Mysql error number generated: %d", $mysqli->errno);
        exit();
    }
    $query = "SELECT ID, FName, LName FROM people ORDER BY FName";
    $peeps = array();
    $result = $mysqli->query($query);
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        $peeps[] = array($row['ID'], $row['FName'], $row['LName'], );

    }
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        $peep[$cnt][0] = $peeps[$cnt][0]; /* ID */
        if (sizeof($peeps[$cnt][2] >0)){
            $peep[$cnt][1] = $peeps[$cnt][1] . " " . $peeps[$cnt][2]; /* name */
        }else{
            $peep[$cnt][1] = $peeps[$cnt][1]; /* first name */
        }
    }    
    
    /*********************
     * Instructor 1
     * *******************
     */
    echo "<tr><td align='right'>Instructor1:</td><td align='left'><select name='tInstructor1'>";
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        echo "<option value='" . $peep[$cnt][0] . "'";
        if($tInstructor1 == $peep[$cnt][0]){
            echo " selected = 'selected'";
        }
        echo ">" . $peep[$cnt][1] . "</option>";
    }
    echo "</select>&nbsp;&nbsp;<a href='people.asp?Action=New'><b>[ NEW ]</b></a></td></tr>";    
    /*********************
     * Instructor 2
     * *******************
     */
    echo "<tr><td align='right'>Instructor 2:</td><td align='left'><select name='tInstructor2'>";
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        echo "<option value='" . $peep[$cnt][0] . "'";
        if($tInstructor2 == $peep[$cnt][0]){
            echo " selected = 'selected'";
        }
        echo ">" . $peep[$cnt][1] . "</option>";
    }
    echo "</select>&nbsp;&nbsp;<a href='people.asp?Action=New'><b>[ NEW ]</b></a></td></tr>";
    echo "<tr><td align='right' valign='top'>Notes:</td><td><textarea name='tNotes' rows='5' cols='40'></textarea></td></tr>";
    
    echo "<tr><td></td><td><input type='submit' value='Ok' size='10'/></td></tr>";
    echo "</table>";
    
}


echo "</form>";
/*-----------------------------------------------
 * display the bottom of the form
 *---------------------------------------------*/
//print $page->getBottom();

?>
</article>
<footer>
				&copy; 2013-2018 Rogue Intelligence
			</footer>
</div>
</body>
</html>

