<?php
require_once('authenticate.php'); /* for security purposes */
include 'database.php';
define('DEBUG','0');
/*
 * grpForm.php
 * ==============================================
 * displays for to enter and edit meetings
 */
// MEETER: require_once("classPage.php");

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
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:500px)"   href="css/screen_layout_small.css">
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width:800px)"  href="css/screen_layout_medium.css">
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
		<div class="page">
			<header>
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

$ID = $_GET["GID"];
$MID = $_GET["MID"];
$ACTION = $_GET["Action"];

if ($ACTION == "Edit"){
    /*------------------------------------------------
     * this section will get the group ID from the
     * url and display it for the user
     ===============================================*/
    
    //connect to the database
    //$mysqli = new mysqli("localhost","dcolombo_cruser","servant88","dcolombo_cr");

    if($mysqli->errno > 0){
        printf("Mysql error number generated: %d", $mysqli->errno);
        exit();
    }
    $query = "SELECT * FROM groups WHERE ID = " . $ID;

    $grp = array();

    $result = $mysqli->query($query);

    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        $grp[] = array($row['ID'], $row['Gender'], $row['Title'],
            $row['FacID'], $row['CoFacID'], $row['Attendance'], $row['Location'], $row['Notes']);

    }
    /* start the form */
    $destination = "grpAction.php?Action=Update&ID=" . $ID . "&MID=" . $MID;
    echo "<form id='grpForm' action='" . $destination . "' method='post'>";
    
    echo "<center><h2>EDIT GROUP</h2></center>";
    echo "<center>";
    echo "<table border='0'>";
    
    echo "<tr><td align='right'>Gender:</td><td>";
    switch ($grp[0][1]){
        case "0":
            echo "<input type='radio' name='grpGender' value='0' checked='checked'>Men</input>&nbsp;&nbsp;
                <input type='radio' name='grpGender' value='1'>Women</input>&nbsp;&nbsp;
                <input type='radio' name='grpGender' value='2'>Mixed</input></td></tr>";
            break;
        case "1":
            echo "<input type='radio' name='grpGender' value='0'>Men</input>&nbsp;&nbsp;
                <input type='radio' name='grpGender' value='1' checked='checked'>Women</input>&nbsp;&nbsp;
                <input type='radio' name='grpGender' value='2'>Mixed</input></td></tr>";
            break;
        case "2":
            echo "<input type='radio' name='grpGender' value='0'>Men</input>&nbsp;&nbsp;
                <input type='radio' name='grpGender' value='1'>Women</input>&nbsp;&nbsp;
                <input type='radio' name='grpGender' value='2' checked='checked'>Mixed</input></td></tr>";
            break;
    }
    
    echo "<tr><td align='right'>Title:</td><td><input type='text' name='grpTitle' size='20' value='" . $grp[0][2] . "'/></td></tr>";       
        
    /** GET PEOPLE */
    /*==========================================================
     * need to load array with people names to put in dropdown
     =========================================================*/
    if($mysqli->errno > 0){
        printf("Mysql error number generated: %d", $mysqli->errno);
        exit();
    }
    $query = "SELECT ID, FName, LName FROM people WHERE Active = 1 AND SmallGroupTeam = 1 ORDER BY FName";
    
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
     * FACILITATOR
     * *******************
     */
    echo "<tr><td align='right'>Facilitator:</td><td align='left'><select name='grpFacID'>";
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        echo "<option value='" . $peep[$cnt][0] . "'";
        if($grp[0][3] == $peep[$cnt][0]){
            echo " selected = 'selected'";
        }
        echo ">" . $peep[$cnt][1] . "</option>";
    }
    echo "</select>&nbsp;&nbsp;<a href='people.php?Action=New&Origin=grpForm&GID=" . $ID . "&MID=" . $MID . "'><img src='images/plusbutton.gif'></img></a></td></tr>"; 
    /*********************
     * CO-FACILITATOR
     * *******************
     */
    echo "<tr><td align='right'>Co-Facilitator:</td><td align='left'><select name='grpCoFacID'>";
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        echo "<option value='" . $peep[$cnt][0] . "'";
        if($grp[0][4] == $peep[$cnt][0]){
            echo " selected = 'selected'";
        }
        echo ">" . $peep[$cnt][1] . "</option>";
    }
    echo "</select>&nbsp;&nbsp;<a href='people.php?Action=New&Origin=grpForm&GID=" . $ID . "&MID=" . $MID . "'><img src='images/plusbutton.gif'></img></a></td></tr>";      
    
    echo "<tr><td align='right'>Location:</td><td><input type='text' name='grpLocation' size='20' value='" . htmlspecialchars($grp[0][6],ENT_QUOTES) . "'></td></tr>";
    /* echo "<tr><td align='right'>Attendance:</td>";
    echo "<td><input type='text' name='grpAttendance' size='3'/ value='" . $grp[0][5] . "'></td></tr>"; */
    
    echo "<tr><td align='right'>Attendance:</td>";
    echo "<td><select name='grpAttendance'>";
    for ($cnt=0; $cnt<21;$cnt++){
        echo "<option value='" . $cnt . "'";
        if ($cnt == $grp[0][5]){
            echo " selected = 'selected'";
        }
        echo ">" . $cnt . "</option>";
    }
    echo "</td></tr>";
    echo "<tr><td align='right' valign='top'>Notes:</td><td><textarea name='grpNotes' rows='5' cols='40'>" . htmlspecialchars($grp[0][7], ENT_QUOTES) . "</textarea></td></tr>";
    echo "<tr><td></td><td><input type='submit' value='Ok' size='10'/></td></tr>";
    echo "</table>";
    echo "<center><img src='images/CCC-room-map.gif'/></center>";
    
}else{
    /*------------------------------------------------
     * this section will display form for the user
     ===============================================*/
    
    /* start the form */
    printf ("<form id='grpForm' action='grpAction.php?Action=Add&MID=%s' method='post'>", $MID);
    
    echo "<center><h2>ADD A NEW GROUP</h2></center>";
    echo "<center>";
    echo "<table border='0'>";
    
    echo "<tr><td align='right'>Gender:</td><td>";
    echo "<input type='radio' name='grpGender' value='0' checked='checked'>Men</input>&nbsp;&nbsp;
                <input type='radio' name='grpGender' value='1'>Women</input>
                <input type='radio' name='grpGender' value='2'>Mixed</input></td></tr>";
    echo "<tr><td align='right'>Title:</td><td><input type='text' name='grpTitle' size='20' /></td></tr>";       
        
    /** GET PEOPLE */
    /*==========================================================
     * need to load array with people names to put in dropdown
     =========================================================*/
    if($mysqli->errno > 0){
        printf("Mysql error number generated: %d", $mysqli->errno);
        exit();
    }
    $query = "SELECT ID, FName, LName FROM people WHERE Active = 1 AND SmallGroupTeam = 1 ORDER BY FName";
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
     * FACILITATOR
     * *******************
     */
    echo "<tr><td align='right'>Facilitator:</td><td align='left'><select name='grpFacID'>";
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        echo "<option value='" . $peep[$cnt][0] . "'";
        if($grp[0][3] == $peep[$cnt][0]){
            echo " selected = 'selected'";
        }
        echo ">" . $peep[$cnt][1] . "</option>";
    }
    echo "</select>&nbsp;&nbsp;<a href='people.asp?Action=New'><b>[ NEW ]</b></a></td></tr>";    
    /*********************
     * CO-FACILITATOR
     * *******************
     */
    echo "<tr><td align='right'>Co-Facilitator:</td><td align='left'><select name='grpCoFacID'>";
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        echo "<option value='" . $peep[$cnt][0] . "'";
        if($grp[0][4] == $peep[$cnt][0]){
            echo " selected = 'selected'";
        }
        echo ">" . $peep[$cnt][1] . "</option>";
    }
    echo "</select>&nbsp;&nbsp;<a href='people.asp?Action=New'><b>[ NEW ]</b></a></td></tr>";     
    
    echo "<tr><td align='right'>Location:</td><td><input type='text' name='grpLocation' size='20'/ value='" . $grp[0][6] . "'></td></tr>";
    echo "<tr><td align='right'>Attendance:</td>";
    echo "<td><select name='grpAttendance'>";
    for ($cnt=0; $cnt<21;$cnt++){
        echo "<option value='" . $cnt . "'";
        if ($cnt == $grp[0][5]){
            echo " selected = 'selected'";
        }
        echo ">" . $cnt . "</option>";
    }
    echo "</td></tr>";
    echo "<tr><td align='right' valign='top'>Notes:</td><td><textarea name='grpNotes' rows='5' cols='40'></textarea></td></tr>";
    echo "<tr><td></td><td><input type='submit' value='Ok' size='10'/></td></tr>";
    echo "</table>";
    /*-------------------------------------------------------------------
     * the following line displays a map that might make it easier in 
     * identifying rooms when entering group info.
     * =================================================================*/
     //echo "<center><img src='images/CCC-room-map.gif'/></center>";
    
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