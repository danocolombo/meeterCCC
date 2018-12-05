<?php
include 'mtgRedirects.php';
include 'database.php';
/*
 * peepAction.php
 */

$Action = $_GET['Action'];
$OID = $_GET['PID'];
$NID = 0;
if ($Action != "DeletePeep" || strlen($OID)<1){
        echo "not sure what to do with " . $Action;
        exit;
}
/* see if we have Removed User in the people database */
$NID = getRemovedUserID();
if($NID<1){
    $NID = addRemovedUser();
}

/*********************************************
 * now replace all the entries in the tables.
 * this is implementation specific.
 ********************************************/
//replacePeepID($OID, $NID, "coaches", "PID");
// replacePeepID($OID, $NID, "CRIMmeetings", "MtgAssistant");
// replacePeepID($OID, $NID, "CRIMmeetings", "MtgPresenter");
// replacePeepID($OID, $NID, "CRIM_meetings", "MtgPresenter");
// replacePeepID($OID, $NID, "groups", "CoFacID");
// replacePeepID($OID, $NID, "groups", "FacID");
// replacePeepID($OID, $NID, "meetings", "MtgPresenter");
// replacePeepID($OID, $NID, "meetings", "MtgWorship");
replacePeepID($OID, $NID, "teams", "CaptainID");
replacePeepID($OID, $NID, "teams", "CoachID");
replacePeepID($OID, $NID, "teams", "CoCaptainID");
// replacePeepID($OID, $NID, "team_members", "PID");
// replacePeepID($OID, $NID, "trainees", "PID");
// replacePeepID($OID, $NID, "training", "tInstructor1");
// replacePeepID($OID, $NID, "training", "tInstructor2");

/* now we need to delete the OID */
deleteUser($OID);

$tmp = "people.php";
destination(307, $tmp);

function deleteUser($OID){
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
    OR die(mysql_error());
    $sql = "DELETE FROM people WHERE ID='" . $OID . "'";
    
    $tmp = "people.php";
    executeSQL($sql, $tmp);
    //testSQL($sql);
}
function getRemovedUserID(){
    //================================================
    // see if there is a "Removed User" in the users
    // table. If not create one. Return a id for
    // Removed User
    //================================================
    //data section start
//     $FName = "Removed";
//     $LName = "User";
//     $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//     $query = $conn->prepare("SELECT `ID` FROM `people` WHERE `FName` = ? and `LName` = ?");
//     $query->bind_param("ss", $FName, $LName);
//     $query->execute();
//     $query->bind_result($userid);
//     $query->fetch();
//     $query->close();
    
    $sql = "SELECT ID FROM people WHERE FName = 'Removed' AND LName='User'";
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $result = mysqli_query($con, $sql);
    $results = mysqli_fetch_assoc($result);
    $ruID = $results["ID"]; 
    
    mysqli_query($con,$sql);
    mysqli_close($con);
    
    if(empty($ruID)) {
        $ruID = -1;
    }
    return $ruID;
    
}
function addRemovedUser(){
    $newID = 0;
    $sql = "INSERT INTO people (FName, LName, Notes) VALUES (";
    $sql = $sql . "'Removed', 'User', 'System defined user, please do not delete')";
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    mysqli_query($con,$sql);
    //mysqli_close($con);
    
    /* now get the ID assigned */
    $sql = "Select ID from people WHERE FName = 'Removed' and LName='User'";
    $result = mysqli_query($con, $sql);
    if (!result){
        die("Database query failed.");
    }
    $results = mysqli_fetch_assoc($result);
    $newID = $results["ID"];
    
    mysqli_free_result($result); 
    mysqli_close($con);

    return $newID;
}

function replacePeepID($oldID, $newID, $table, $column){
    /******************************************************
     * this routine will take the input info and execute
     * a swap statement
     *****************************************************/
    //$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $sql = "UPDATE " . $table . " SET " . $column . " = '" . $newID . "' WHERE " . $column . " = " . $oldID;
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    mysqli_query($con,$sql);
    mysqli_close($con);
    //$query = $conn->prepare("UPDATE ? SET ? = ? WHERE ? = ?");
    //$query->bind_param("sssss", $table, $column, $newID, $column, $oldID);
    //$query->execute();
    //$query->close();
}


function executeSQL($sql,$destination){    /*
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
