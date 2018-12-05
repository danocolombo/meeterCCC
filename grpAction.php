<?php
include 'mtgRedirects.php';
include 'database.php';
/*
 * grpAction.php
 */

$Action = $_GET['Action'];

switch ($Action){
    case "Add":
        addGroup();
        exit;
    case "Update":
        updateGroup();
        exit;
    default:
        echo "not sure what to do with " . $Action;
        exit;
}

function addGroup(){
    /* 
     * this routine addes the form information to the database
     */
    /* need the following $link command to use the escape_string function */
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
     
    $MID = $_GET['MID'];
    $gGender = $_POST['grpGender'];
    $gTitle = $_POST['grpTitle'];
    $gFacID = $_POST['grpFacID'];
    $gCoFacID = $_POST['grpCoFacID'];
    $gLocation = $_POST['grpLocation'];
    $gAttendance = $_POST['grpAttendance'];
    $gNotes = $_POST['grpNotes'];
    
    $sql = "INSERT INTO groups (MtgID, Gender, Title, FacID, CoFacID, Location, Attendance, Notes) VALUES ('";
    $sql = $sql . $MID . "', '";
    $sql = $sql . $gGender . "', '";
    $sql = $sql . mysql_real_escape_string($gTitle) . "', '";
    $sql = $sql . $gFacID . "', '";
    $sql = $sql . $gCoFacID . "', '";
    $sql = $sql . mysql_real_escape_string($gLocation) . "', '";
    $sql = $sql . $gAttendance . "', '";
    $sql = $sql . mysql_real_escape_string($gNotes) . "')";
    
    $tmp = "mtgForm.php?ID=" . $MID;
    executeSQL($sql, $tmp);
    //testSQL($sql);
    
}

function updateGroup(){
    /* 
     * this routine updates an existing record in the database
    */
    /* need the following $link command to use the escape_string function */
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error()); 
    
    $ID = $_GET['ID'];
    $MID = $_GET['MID'];
    $grpGender = $_POST['grpGender'];
    $grpTitle = $_POST['grpTitle'];
    $grpFacID = $_POST['grpFacID'];
    $grpCoFacID = $_POST['grpCoFacID'];
    $grpLocation = $_POST['grpLocation'];
    $grpAttendance = $_POST['grpAttendance'];
    $grpNotes = $_POST['grpNotes'];
    
    $sql = "UPDATE groups SET Gender = '" . $grpGender;
    $sql = $sql . "', Title = '" . mysql_real_escape_string($grpTitle);
    $sql = $sql . "', FacID = '" . $grpFacID . "'";
    
    if (sizeof($grpCoFacID) > '0'){
        $sql = $sql . ", CoFacID ='" . $grpCoFacID . "'";
    }
    if (sizeof($grpLocation) > 0){
        $sql = $sql . ", Location = '" . mysql_real_escape_string($grpLocation) . "'";
    }
    if ($grpAttendance>0){
        $sql = $sql . ", Attendance = '" . $grpAttendance . "'";
    }else{
        $sql = $sql . ", Attendance = '0'";
    }
    if (sizeof($grpNotes) > 0 ){
        $sql = $sql . ", Notes = '" . mysql_real_escape_string($grpNotes) . "'";
    }
    $sql = $sql . " WHERE ID = '" . $ID . "'";
    
    $tmp = "mtgForm.php?ID=" . $MID;
    executeSQL($sql,$tmp);
    
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
?>
