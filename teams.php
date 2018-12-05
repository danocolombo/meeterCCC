<?php
require_once('authenticate.php'); /* for security purposes */
include 'mtgRedirects.php';
include 'database.php';
/*
 * teams.php
 * ======================================================
 * this uses pageHead.txt, pageTop.txt & pageBottom.txt
 */

//require_once("classPage.php");
//
//$page = new Page();
//print $page->getTop();
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~`
// new header section
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
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
/*####################################################
 * START MAIN PROCESSING
 * ###################################################
 */

$Action = $_GET["Action"];
$Destination = $_GET["Destination"];
$Origin = $_GET["Origin"];
$TID = $_GET["TID"];

switch ("$Action"){     
    case "Edit":
        showTeamForm("Edit","","", $TID);
        break;
    
    case "New":
        /*============================================
         * Need to display blank form to add new team
         * for adding to system
         *============================================
         */
        //showForm("New", $_GET['Origin'], $_GET['Dest'], $_GET['$TID']);
        showTeamForm("New","","", $TID);
        break;
    case "adminDisplayTeams":
        /*============================================
         * this diplays the list of teams to manage
         =============================================*/
        showAdminDisplayTeams();
        break;
    default:
        showTeamList();
        break;
}


/* =============================
 * GENERIC HTML TO FOLLOW:
 * =============================
 */
/* print <<<EOF
<div id="mainContent">

<p>This is where content would go, should there be any.</p>
</div> <!-- end main content -->

EOF;
 * 
 */
//print ("</center>");
//print $page->getBottom();
?>
</article>
    <footer>
            &copy; 2013-2018 Rogue Intelligence
    </footer>
<?php

function showTeamList() {
   include 'database.php';
   echo "<center><h1>CR Ministry Teams</h1>";

   if($connection->errno > 0){
       printf("Mysql error number generated: %d", $connection->errno);
       exit();
   }
   
   $query = "SELECT t.ID as ID, t.Title as TeamTitle,";
   $query = $query . " p1.FName as CaptainFName,";
   $query = $query . " p1.LName as CaptainLastName,";
   $query = $query . " p2.FName as CoCaptainFName,";
   $query = $query . " p2.LName as CoCaptainLName,";
   $query = $query . " p3.FName as CoachFName,";
   $query = $query . " p3.LName as CoachLName";
   $query = $query . " FROM teams t";
   $query = $query . " INNER JOIN people p1 ON p1.ID = t.CaptainID";
   $query = $query . " INNER JOIN people p2 ON p2.ID = t.CoCaptainID";
   $query = $query . " INNER JOIN people p3 ON p3.ID = t.CoachID";
   $query = $query . " ORDER BY TeamTitle";
   
   $result = $connection->query($query, MYSQLI_STORE_RESULT);
   //echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=NewPeep'>NEW ENTRY</a></div>";
   //echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=ShowAll'><img src='images/btnShowAll.gif'/></a></div>";
   echo "<div style='text-align:right; padding-right: 20px;'><a href='teams.php?Action=New'><img src='images/plusbutton.gif'/></a></div>";
   echo "<table id='reportdata'>";
   $altCnt = 0;
   echo "<tr><th>Team Title</th><th>Captain</th><th>Co-Captain</th><th>Coach</th></tr>";
   while(list($ID, $TeamTitle, $CaptainFName, $CaptainLName, $CoCaptainFName, $CoCaptainLName, $CoachFName, $CoachLName) = $result->fetch_row()){
           echo "<tr";
           if ($altflag==0){
                echo " class='alt'";
                $altflag=1;
            }else{
                $altflag=0;
            }
           echo "><td align='center' sytle='padding=right:15px'>";
           echo "<a href='teams.php?Action=Edit&TID=" . $ID . "&TeamTitle=" . $TeamTitle . "'>" . $TeamTitle . "</a></td><td style='padding-left:15px; padding-right:15px;'>" . $CaptainFName . " " . $CaptainLName;
           echo "</td><td>" . $CoCaptainFName . " " . $CoCaptainLName . "</td><td>" . $CoachFName . " " . $CoachLName . "</tr>";
   }
   echo "</table>";
   
}

function showAdminDisplayTeams(){
    include 'mysql.connect.php';
   echo "<center><h1>CR Ministry Teams</h1>";

   if($mysqli->errno > 0){
       printf("Mysql error number generated: %d", $mysqli->errno);
       exit();
   }
   
   $query = "SELECT t.ID as ID, t.Title as TeamTitle,";
   $query = $query . " t.Enabled as TeamEnabled,";
   $query = $query . " t.Archived as TeamArchived,";
   $query = $query . " p1.FName as CaptainFName,";
   $query = $query . " p1.LName as CaptainLastName,";
   $query = $query . " p2.FName as CoCaptainFName,";
   $query = $query . " p2.LName as CoCaptainLName,";
   $query = $query . " p3.FName as CoachFName,";
   $query = $query . " p3.LName as CoachLName";
   $query = $query . " FROM teams t";
   $query = $query . " INNER JOIN people p1 ON p1.ID = t.CaptainID";
   $query = $query . " INNER JOIN people p2 ON p2.ID = t.CoCaptainID";
   $query = $query . " INNER JOIN people p3 ON p3.ID = t.CoachID";
   $query = $query . " ORDER BY TeamArchived, TeamTitle";
   
   $result = $mysqli->query($query, MYSQLI_STORE_RESULT);
   //echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=NewPeep'>NEW ENTRY</a></div>";
   //echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=ShowAll'><img src='images/btnShowAll.gif'/></a></div>";
   echo "<div style='text-align:right; padding-right: 20px;'><a href='teams.php?Action=New'><img src='images/plusbutton.gif'/></a></div>";
   echo "<table id='reportdata'>";
   $altCnt = 0;
   echo "<tr><th>Team Title</th><th>Captain</th><th>Co-Captain</th><th>Coach</th></tr>";
   while(list($ID, $TeamTitle, $CaptainFName, $CaptainLName, $CoCaptainFName, $CoCaptainLName, $CoachFName, $CoachLName) = $result->fetch_row()){
           echo "<tr";
           if ($altflag==0){
                echo " class='alt'";
                $altflag=1;
            }else{
                $altflag=0;
            }
           echo "><td align='center' sytle='padding=right:15px'>";
           echo "<a href='teams.php?Action=Edit&TID=" . $ID . "&TeamTitle=" . $TeamTitle . "'>" . $TeamTitle . "</a></td><td style='padding-left:15px; padding-right:15px;'>" . $CaptainFName . " " . $CaptainLName;
           echo "</td><td>" . $CoCaptainFName . " " . $CoCaptainLName . "</td><td>" . $CoachFName . " " . $CoachLName . "</tr>";
   }
   echo "</table>";
}

function showTeamForm($Action){
    /* 
     * this function displays the form to edit teams
     */
    $FormTitle = "";
    include 'database.php';
    if($connection->errno > 0){
       printf("Mysql error number generated: %d", $connection->errno);
       exit();
    }
    if($Action == "Edit"){
        /*
         * get the Team info from database
         */ 
        $TID = $_GET["TID"];
        $TeamTitle = $_GET['TeamTitle'];
        $FormTitle = $TeamTitle . " Team Info";
        $FormAction = "teamAction.php?Action=Update&TID=" . $TID;
        
        $query = "SELECT * FROM teams WHERE ID = " . $TID;
        $result = $connection->query($query, MYSQLI_STORE_RESULT);    
        list($ID, $Title, $Description, $CaptainID, $CoCaptainID, $CoachID) = $result->fetch_row();
    }
    if($Action == "New"){
        $FormTitle = "NEW Team Information";
        $FormAction = "teamAction.php?Action=New";
    }
    
    /* start the form */
    echo "<form id='tmForm' action='" . $FormAction . "' method='post'>";
    
    echo "<center><h2>" . $FormTitle . "</h2></center>";
    echo "<center>";
    echo "<table border='0'>";
    //if ($Action == "Edit") echo "<tr><td colspan='2' align='right' border='1'>" . $ID . "</td></tr>";
    echo "<tr><td align='right'>Team Name:</td><td>";
    echo "<input type='text' name='tTitle' size='20' value='". htmlspecialchars($Title) . "' /></td></tr>";
             
        
    /** GET PEOPLE */
    /*==========================================================
     * need to load array with people names to put in dropdown
     =========================================================*/
    if($connection->errno > 0){
        printf("Mysql error number generated: %d", $connection->errno);
        exit();
    }
    $query = "SELECT ID, FName, LName FROM people ORDER BY FName";
    $peeps = array();
    $result = $connection->query($query);
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
     * Captain
     * *******************
     */
    echo "<tr><td align='right'>Captain:</td><td align='left'><select name='tCaptain'>";
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        echo "<option value='" . $peep[$cnt][0] . "'";
        if($CaptainID == $peep[$cnt][0]){
            echo " selected = 'selected'";
        }
        echo ">" . $peep[$cnt][1] . "</option>";
    }
    echo "</select>&nbsp;&nbsp;<a href='people.asp?Action=New'><b>[ NEW ]</b></a></td></tr>";    
    /*********************
     * Co-Captain
     * *******************
     */
    echo "<tr><td align='right'>Co-Captain:</td><td align='left'><select name='tCoCaptain'>";
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        echo "<option value='" . $peep[$cnt][0] . "'";
        if($CoCaptainID == $peep[$cnt][0]){
            echo " selected = 'selected'";
        }
        echo ">" . $peep[$cnt][1] . "</option>";
    }
    echo "</select>&nbsp;&nbsp;<a href='people.asp?Action=New'><b>[ NEW ]</b></a></td></tr>";
    /*********************
     * Coach
     * *******************
     */
    echo "<tr><td align='right'>Coach:</td><td align='left'><select name='tCoach'>";
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        echo "<option value='" . $peep[$cnt][0] . "'";
        if($CoachID == $peep[$cnt][0]){
            echo " selected = 'selected'";
        }
        echo ">" . $peep[$cnt][1] . "</option>";
    }
    echo "</select>&nbsp;&nbsp;<a href='people.asp?Action=New'><b>[ NEW ]</b></a></td></tr>";
    
    echo "<tr><td align='right' valign='top'>Description:</td><td><textarea name='tDescription' rows='5' cols='40'>" . $Description . "</textarea></td></tr>";
    
    echo "<tr><td></td><td><input type='submit' value='Ok' size='10'/></td></tr>";
    echo "</table>";
    /* END FORM */
    //if we are doing Edit, get the current members
    If ($Action == "Edit"){
    
        echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=TeamCandidates&TID=" . $TID . "&TeamTitle=" . $TeamTitle . "'><img src='images/addpeepbutton.jpg' width='50px'></img></a></div>";
        /********************************************************
         * display a list of memobers of the team
         * ******************************************************
         */
        //$query = "SELECT people.ID, people.FName, people.LName FROM people INNER JOIN trainees ON trainees.PID
        //    = people.ID WHERE trainees.TID = '" . $TID . "' ORDER BY people.FName";

        $query = "SELECT p1.ID as PID,";
        $query = $query . " p1.FName as FName,";
        $query = $query . " p1.LName as LName";
        $query = $query . " FROM team_members as members";
        $query = $query . " INNER JOIN people p1 ON p1.ID = members.PID";
        $query = $query . " WHERE members.TID = " . $TID;
        $query = $query . " ORDER BY FName";


        if($connection->errno > 0){
           printf("Mysql error number generated: %d", $connection->errno);
           exit();
        }
        $team = array();
        $result = $connection->query($query);
        while ($row = $result->fetch_array(MYSQLI_ASSOC))
        {
            $team[] = array($row['PID'], $row['FName'], $row['LName'], );

        }
        echo "<table>";
        for($cnt=0;$cnt<$result->num_rows;$cnt++){
            echo "<tr><td><a href='people.php?Action=Edit&PID=" . $team[$cnt][0] . "'>";
            echo $team[$cnt][1] . " ";
            echo $team[$cnt][2] . "</a>&nbsp;</td>";
            echo "<td><a href='teamAction.php?Action=DropMember&TID=" . $TID . "&PID=" . $team[$cnt][0] . "&TeamTitle=" . $TeamTitle . "'><img src='images/minusbutton.gif'/></a></td></tr>";

        }

        echo "</table>";
    }
}



function testSQL($sql){
    /* 
     * this function executes the sql passed in 
     */
   echo "SQL: " . $sql;
}
function executeSQL($sql,$destination){
    /* 
     * this function executes the sql passed in 
     */
   
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    mysqli_query($con,$sql);

    mysqli_close($con);
    
    destination(307, $destination);
    
}
?>
