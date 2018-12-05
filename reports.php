<?php
require_once('authenticate.php'); /* for security purposes */
include 'database.php';
require_once 'HTML/Table.php';
/*
 * reports.php
 * ======================================================
 * this uses pageHead.txt, pageTop.txt & pageBottom.txt
 */
/*
require_once("classPage.php");
$outputType = "table";
$page = new Page();
print $page->getTop();
 */
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
$REPORT = $_GET["Report"];

$ReportTitle = "";
switch ($REPORT){
    case "FellowshipInterest":
        $ReportTitle = "Fellowship Team";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE FellowshipTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "PrayerInterest":
        $ReportTitle = "Prayer Team";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE PrayerTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "NewcomersInterest":
        $ReportTitle = "Newcomers (101) Team";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE NewcomersTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "GreetingInterest":
        $ReportTitle = "Greeting Team";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE GreetingTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "SpecialEventsInterest":
        $ReportTitle = "Special Events Team";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE SpecialEventsTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "ResourceInterest":
        $ReportTitle = "Resource Team";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE ResourceTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "SmallGroupInterest":
        $ReportTitle = "Open-share Team";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE SmallGroupTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "StepStudyInterest":
        $ReportTitle = "Step-Study Team";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE StepStudyTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "TransportationInterest":
        $ReportTitle = "Transportation Team";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE TransportationTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "WorshipInterest":
        $ReportTitle = "Worship Team";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE WorshipTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "LandingInterest":
        $ReportTitle = "The Landing Interest";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE LandingTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "CelebrationPlaceInterest":
        $ReportTitle = "Celebration Place Interest";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE CelebrationPlaceTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "SolidRockInterest":
        $ReportTitle = "Crosstalk Cafe Team";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE SolidRockTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "MealInterest":
        $ReportTitle = "Meal Team";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE MealTeam='1' AND Active='1' ORDER BY LName";       
        break;
    case "MealCnt":
        $ReportTitle = "Meals Served";   
        //SELECT *  FROM `meetings` WHERE `MtgDate` <= '2014-10-15' ORDER BY `MtgDate` DESC
        $query = "SELECT ID, MtgDate, DinnerCnt FROM meetings WHERE MtgDate <= '";
        $tmpToday = date("Y-m-d");
        $query = $query . $tmpToday . "' ORDER BY MtgDate DESC";  
        //printf("SQL:>>". $query . "<<");
        break;
    case "NurseryCnt":
        $ReportTitle = "Nursery Service";   
        $query = "SELECT ID, MtgDate, NurseryCnt FROM meetings WHERE MtgDate <= '";
        $tmpToday = date("Y-m-d");
        $query = $query . $tmpToday . "' ORDER BY MtgDate DESC";  
        //printf("SQL:>>". $query . "<<");
        break;
    case "101Cnt":
        $ReportTitle = "101 Visitors"; 
        // SELECT meetings.ID, meetings.MtgDate, groups.Attendance FROM groups 
        // INNER JOIN meetings ON groups.MtgID = meetings.ID WHERE 
        // meetings.MtgDate <= "2014-10-15" AND groups.Title = "101" ORDER BY meetings.MtgDate DESC
        $query = "SELECT meetings.ID, meetings.MtgDate, groups.Attendance FROM groups ";
        $query = $query . " INNER JOIN meetings ON groups.MtgID = meetings.ID WHERE MtgDate <= '";
        $tmpToday = date("Y-m-d");
        $query = $query . $tmpToday . "' AND groups.Title = '101' ORDER BY meetings.MtgDate DESC";  
        //printf("SQL:>>". $query . "<<");
        break;
    case "CSCnt":
        $ReportTitle = "Celebration Place"; 
        // SELECT meetings.ID, meetings.MtgDate, groups.Attendance FROM groups 
        // INNER JOIN meetings ON groups.MtgID = meetings.ID WHERE 
        // meetings.MtgDate <= "2014-10-15" AND groups.Title = "Celebration Place" ORDER BY meetings.MtgDate DESC
        $query = "SELECT meetings.ID, meetings.MtgDate, groups.Attendance FROM groups ";
        $query = $query . " INNER JOIN meetings ON groups.MtgID = meetings.ID WHERE MtgDate <= '";
        $tmpToday = date("Y-m-d");
        $query = $query . $tmpToday . "' AND groups.Title = 'Celebration Place' ORDER BY meetings.MtgDate DESC";  
        //printf("SQL:>>". $query . "<<");
        break;
    case "LandingCnt":
        $ReportTitle = "The Landings"; 
        // SELECT meetings.ID, meetings.MtgDate, groups.Attendance FROM groups 
        // INNER JOIN meetings ON groups.MtgID = meetings.ID WHERE 
        // meetings.MtgDate <= "2014-10-15" AND groups.Title = "The Landing" ORDER BY meetings.MtgDate DESC
        $query = "SELECT meetings.ID, meetings.MtgDate, groups.Attendance FROM groups ";
        $query = $query . " INNER JOIN meetings ON groups.MtgID = meetings.ID WHERE MtgDate <= '";
        $tmpToday = date("Y-m-d");
        $query = $query . $tmpToday . "' AND groups.Title = 'The Landing' ORDER BY meetings.MtgDate DESC";  
        //printf("SQL:>>". $query . "<<");
        break;
    case "TeachingTeam":
        $ReportTitle = "Teaching Interest";           
        $query = "SELECT ID, FName, LName, Phone1, Email1 ";
        $query = $query . " FROM people ";
        $query = $query . "WHERE TeachingTeam='1' AND Active='1' ORDER BY LName";       
        break;
    default:
        $ReportTitle = "Reports";
        exit;
    
}


if($mysqli->errno > 0){
    printf("Mysql error number generated: %d", $mysqli->errno);
    exit();
}

    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if($mysqli->errno > 0){
        printf("Mysql error number generated: %d", $mysqli->errno);
        exit();
    }
    $interaction = array();

    $result = $mysqli->query($query);
//echo "SQL:" . $query;
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        switch ($REPORT){
            case "FellowshipInterest":
            case "PrayerInterest":
            case "NewcomersInterest":
            case "GreetingInterest":
            case "SpecialEventsInterest":
            case "ResourceInterest":
            case "SmallGroupInterest":
            case "StepStudyInterest":
            case "TransportationInterest":
            case "WorshipInterest":
            case "LandingInterest":
            case "CelebrationPlaceInterest":
            case "SolidRockInterest":
            case "TeachingTeam":
            case "MealInterest":
                // load the array for members
                $interaction[] = array($row['ID'], $row['FName'], $row['LName'], $row['Phone1'], $row['Email1']);
                break;
            case "MealCnt":
                // load the array for counts
                $interaction[] = array($row['ID'], $row['MtgDate'], $row['DinnerCnt']);
                break;
            case "NurseryCnt":
                // load the array for counts
                $interaction[] = array($row['ID'], $row['MtgDate'], $row['NurseryCnt']);
                break;
            case "101Cnt":
            case "CSCnt":
            case "LandingCnt":
                // load the array for counts
                $interaction[] = array($row['ID'], $row['MtgDate'], $row['Attendance']);
                break;
            default:
                echo "WARNING: REPORT NOT DEFINED TO DISPLAY";
                exit;  //should never be here without REPORT defined
        }
    }
    if (sizeof($interaction) > 0) {
        switch($REPORT){
            case "FellowshipInterest":
            case "PrayerInterest":
            case "NewcomersInterest":
            case "GreetingInterest":
            case "SpecialEventsInterest":
            case "ResourceInterest":
            case "SmallGroupInterest":
            case "StepStudyInterest":
            case "TransportationInterest":
            case "WorshipInterest":
            case "LandingInterest":
            case "CelebrationPlaceInterest":
            case "SolidRockInterest":
            case "TeachingTeam":
            case "MealInterest":
                echo "<center>";
                echo "<h2>" . $ReportTitle . "</h2>";
                echo "<table id='reportdata'>";
                $altflag = 0;
                for($cnt=0;$cnt<sizeof($interaction);$cnt++){                  
                    echo "<tr";
                    if ($altflag==0){
                        echo " class='alt'";
                        $altflag=1;
                    }else{
                        $altflag=0;
                    }
                    echo "><td>" . $interaction[$cnt][1] . " " . $interaction[$cnt][2] . "</td>"; //
                    echo "<td>" . $interaction[$cnt][3] . "</td>"; //phone
                    echo "<td>" . $interaction[$cnt][4] . "</td>"; //email             
                    echo "<td><a href='people.php?Action=Edit&PID=" . $interaction[$cnt][0] . "'>DETAILS</a></td></tr>"; //link to person
                }
                echo "</table>";
                /* ==========================================================
                 * NOW display the email addresses and indicate if any people
                 * do not have an email address
                 */
                echo "<br/><h3>" . $ReportTitle . " Email List</h3>";
                $emailCnt = 0;
                echo "<table><tr><td width='400'>";
                for($cnt=0;$cnt<sizeof($interaction);$cnt++){ 
                    if (strlen($interaction[$cnt][4])>0){
                        $emailCnt = $emailCnt + 1;
                        if ($emailCnt > 1){
                            echo ", ";
                        }
                        echo $interaction[$cnt][4];     
                    }
                }
                echo "</table>";
                if ($emailCnt < sizeof($interaction)){
                        echo "<h3>NOTE: some members do not have email listed!</h3>";
                }
                echo "</center>";
                break;
                
                /* ##################################################
                 *  MealCnt
                 ##################################################*/
            case "MealCnt":
            case "NurseryCnt":
            case "101Cnt":
            case "CSCnt":
            case "LandingCnt":
                echo "<center>";
                echo "<h2>" . $ReportTitle . "</h2>";
                echo "<table id='reportdata'>";
                $altflag = 0;
                for($cnt=0;$cnt<sizeof($interaction);$cnt++){                  
                    echo "<tr";
                    if ($altflag==0){
                        echo " class='alt'";
                        $altflag=1;
                    }else{
                        $altflag=0;
                    }
                    echo "><td><a href='";
                    echo "mtgForm.php?ID=" . $interaction[$cnt][0] . "'>";
                    echo $interaction[$cnt][1] . "</a></td>"; //date
                    echo "<td>" . $interaction[$cnt][2] . "</td></tr>"; //cnt
                
                }
                echo "</table>";
                echo "</center>";
                break;
            case "NurseryCnt1":
                echo "<center>";
                echo "<h2>" . $ReportTitle . "</h2>";
                echo "<table id='reportdata'>";
                $altflag = 0;
                for($cnt=0;$cnt<sizeof($interaction);$cnt++){                  
                    echo "<tr";
                    if ($altflag==0){
                        echo " class='alt'";
                        $altflag=1;
                    }else{
                        $altflag=0;
                    }
                    echo "><td><a href='";
                    echo "mtgForm.php?ID=" . $interaction[$cnt][0] . "'>";
                    echo $interaction[$cnt][1] . "</a></td>"; //date
                    echo "<td>" . $interaction[$cnt][2] . "</td></tr>"; //cnt
                
                }
                echo "</table>";
                echo "</center>";
                break;
            default:
                echo "WARNING: NO FORMATTING OF REPORT DATA SPECIFIED";
                exit; //should never be here without REPORT defined
                    
        }
        
    }

/**** print the records returned  */
printf("Records reported: %d", $result->num_rows);
?>
</div>";
</article>
			<footer>
				&copy; 2013-2018 Rogue Intelligence
			</footer>
</div>
</body>
</html>