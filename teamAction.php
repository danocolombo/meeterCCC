<?php
include 'teamRedirects.php';
include 'database.php';
/*
 * teamAction.php
 */

$Action = $_GET['Action'];

switch ($Action){
    case "AddMember":
        /*********************************
         * add person to a team
         * *******************************
         */
        $TID = $_GET["TID"];  // Training ID
        $PID = $_GET["PID"];  // People ID
        $TeamTitle = $_GET["TeamTitle"];
        draftMember($TID, $PID, $TeamTitle);
        exit;
    case "DropMember":
        /*********************************
         * remove member from team
         * *******************************
         */
        $TID = $_GET["TID"];  // Team ID
        $PID = $_GET["PID"];  // People ID
        $TeamTitle = $_GET["TeamTitle"];
        dropMember($TID, $PID, $TeamTitle);
        exit;
    case "Update":
        /*
         * this call is to update the team info from the form submitted
         */
        $TID = $_GET["TID"];  // Team ID
        updateTeam($TID);
        break;
    
    case "New":
        /*
         * this is the routine called to add a new team to the dateabase
         */
        addTeamToDB();
        break;
        
    default:
        echo "not sure what to do with " . $Action;
        exit;
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


function testSQL($sql){
    /* 
     * this function executes the sql passed in 
     */
   echo "SQL: " . $sql;
}

function draftMember($TID, $PID, $TeamTitle){
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
     
    
    $sql = "INSERT INTO team_members (TID, PID) VALUES ('";
    $sql = $sql . $TID . "', '";
    $sql = $sql . $PID . "')";
    
    //$tmp = "trnForm.php?ID=" . $TID;
    $tmp = "teams.php?Action=Edit&TID=" . $TID . "&TeamTitle=". $TeamTitle;
    executeSQL($sql, $tmp);
    // testSQL($sql);
}

function dropMember($TID, $PID, $TeamTitle){
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
     
    
    $sql = "DELETE FROM team_members WHERE TID='" . $TID . "' AND PID='" . $PID . "'";
    $TeamTitle = $_GET["TeamTitle"];
    $tmp = "teams.php?Action=Edit&TID=" . $TID . "&TeamTitle=". $TeamTitle;
    executeSQL($sql, $tmp);
    //testSQL($sql);
}

function updateTeam($TID){
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
     
    $tTitle = $_POST['tTitle'];
    $tCaptainID = $_POST['tCaptain'];
    $tCoCaptainID = $_POST['tCoCaptain'];
    $tCoachID = $_POST['tCoach'];
    $tDescription = $_POST['tDescription'];
    $sql = "UPDATE teams SET Title = '";
    $sql = $sql . mysql_real_escape_string($tTitle) . "', CaptainID = '";
    $sql = $sql . $tCaptainID . "', CoCaptainID = '";
    $sql = $sql . $tCoCaptainID . "', CoachID = '";
    $sql = $sql . $tCoachID . "', Description = '";
    $sql = $sql . mysql_real_escape_string($tDescription) . "'";
    $sql = $sql . " WHERE ID = '" . $TID . "'";
    
    $dest = "teams.php";
    executeSQL($sql, $dest);
    //testSQL($sql);
}
function addTeamToDB(){
    /* 
     * this routine addes the form information to the database
     */
    /* need the following $link command to use the escape_string function */
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
     
    $tTitle = $_POST['tTitle'];
    $tCaptainID = $_POST['tCaptain'];
    $tCoCaptainID = $_POST['tCoCaptain'];
    $tCoachID = $_POST['tCoach'];
    $tDescription = $_POST['tDescription'];
    
    $sql = "INSERT INTO teams (Title, CaptainID, CoCaptainID, CoachID, Description) VALUES ('";
    $sql = $sql . mysql_real_escape_string($tTitle) . "', '";
    $sql = $sql . $tCaptainID . "', '";
    $sql = $sql . $tCoCaptainID . "', '";
    $sql = $sql . $tCoachID . "', '";
    $sql = $sql . mysql_real_escape_string($tDescription) . "')";
    
    $tmp = "teams.php";
    executeSQL($sql,$tmp);
    //testSQL($sql);
}
?>