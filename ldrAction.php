<?php
include 'mtgRedirects.php';
include 'database.php';
/*
 * ldrAction.php
 */

$Action = $_GET['Action'];

switch ($Action){
    case "AddTrainee":
        /*********************************
         * add person to training list
         * *******************************
         */
        $TID = $_GET["TID"];  // Training ID
        $PID = $_GET["PID"];  // People ID
        bookTraineeInClass($TID, $PID);
        exit;
    case "RemoveTrainee":
        /*********************************
         * add person to training list
         * *******************************
         */
        $TID = $_GET["TID"];  // Training ID
        $PID = $_GET["PID"];  // People ID
        dropTraineeFromClass($TID, $PID);
        exit;
    case "Update":
        /*********************************
         * update training session with
         * form passed in
         * *******************************
         */
        $TID = $_GET['TID'];
        updateTrainingSession($TID);
        exit;
    case "AddNew":
        /*********************************
         * add new training entry
         * *******************************
         */
        addNewTrainingSession();
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
    
    $tmp = "ldrForm.php?ID=" . $MID;
    executeSQL($sql, $tmp);
    
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
    
    $tmp = "ldrForm.php?ID=" . $MID;
    executeSQL($sql,$tmp);
    
}
function addNewTrainingSession(){
    /********************************************
     * take form and add to database
     * ******************************************
     */
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error()); 
    $tDate = $_POST["tDate"];
    $tTitle = $_POST["tTitle"];
    $tLocation = $_POST["tLocation"];
    $tInstructor1 = $_POST["tInstructor1"];
    $tInstructor2 = $_POST["tInstructor2"];
    $tNotes = $_POST["tNotes"];
    
    $sql = "INSERT INTO training (tTitle, tDate, tLocation, tInstructor1, tInstructor2, tNotes) VALUES ('";
    $sql = $sql . mysql_real_escape_string($tTitle) . "', '";
    $sql = $sql . $tDate . "', '";
    $sql = $sql . mysql_real_escape_string($tLocation) . "', ";
    $sql = $sql . $tInstructor1 . ", ";
    $sql = $sql . $tInstructor2 . ", '";
    $sql = $sql . mysql_real_escape_string($tNotes) . "')";
    
    //testSQL($sql);
    $tmp = "leadership.php";
    executeSQL($sql,$tmp);
}
function updateTrainingSession($TID){
    /*********************************************
     * update the training session in database
     * *******************************************
     */
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error()); 
    
    $TID = $_GET["ID"];
    $tDate = $_POST["tDate"];
    $tTitle = $_POST["tTitle"];
    $tLocation = $_POST["tLocation"];
    $tInstructor1 = $_POST["tInstructor1"];
    $tInstructor2 = $_POST["tInstructor2"];
    $tNotes = $_POST["tNotes"];
    
    $sql = "UPDATE training SET tTitle = '" . mysql_real_escape_string($tTitle) . "',";
    $sql = $sql . " tDate ='" . $tDate . "',";
    $sql = $sql . " tLocation = '" . mysql_real_escape_string($tLocation) . "',";
    $sql = $sql . " tInstructor1='" . $tInstructor1 . "',";
    $sql = $sql . " tInstructor2='" . $tInstructor2 . "',";
    $sql = $sql . " tNotes ='" . mysql_real_escape_string($tNotes) . "' WHERE ID='" . $TID . "'";
    
    
    $tmp = "leadership.php";
    executeSQL($sql,$tmp);
    //testSQL($sql);
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

function bookTraineeInClass($TID, $PID){
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
     
    
    $sql = "INSERT INTO trainees (TID, PID) VALUES ('";
    $sql = $sql . $TID . "', '";
    $sql = $sql . $PID . "')";
    
    $tmp = "ldrForm.php?ID=" . $TID;
    executeSQL($sql, $tmp);
    // testSQL($sql);
}

function dropTraineeFromClass($TID, $PID){
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
     
    
    $sql = "DELETE FROM trainees WHERE TID='" . $TID . "' AND PID='" . $PID . "'";
    
    $tmp = "ldrForm.php?ID=" . $TID;
    executeSQL($sql, $tmp);
    // testSQL($sql);
}

?>
