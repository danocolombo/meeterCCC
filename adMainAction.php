<?php
include 'mtgRedirects.php';
include 'database.php';
/*
 * mtgAction.php
 */

$Action = $_GET['Action'];

switch ($Action){
    case "New":
        addMeetingToDB();
        exit;
    case "Update":
        updateMeetingInDB();
        exit;
    case "DeleteGroup":
        deleteGroup();
        exit;
    case "PreLoadGroups":
        $MID = $_GET['MID'];
        PreLoadGroups($MID);
        exit;
    default:
        echo "not sure what to do with " . $Action;
        
}

function addMeetingToDB(){
    /* 
     * this routine addes the form information to the database
     */
    /* need the following $link command to use the escape_string function */
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
     
    $mDate = $_POST['mtgDate'];
    $mType = $_POST['mtgType'];
    $mTitle = $_POST['mtgTitle'];
    $mPresenter = $_POST['mtgPresenter'];
    $mAttendance = $_POST['mtgAttendance'];
    $mDinnerCnt = $_POST['mtgDinnerCnt'];
    $mDonations = $_POST['mtgDonations'];
    $mNurseryCnt = $_POST['mtgNurseryCnt'];
    $mChildrenCnt = $_POST['mtgChildrenCnt'];
    $mYouthCnt = $_POST['mtgYouthCnt'];
    $mNotes = $_POST['mtgNotes'];
    
    $sql = "INSERT INTO meetings (MtgDate, MtgType, MtgTitle, MtgPresenter, MtgAttendance,
        Donations, DinnerCnt, NurseryCnt, ChildrenCnt, YouthCnt, MtgNotes) VALUES ('";
    $sql = $sql . $mDate . "', '" . $mType . "', '";
    $sql = $sql . mysql_real_escape_string($mTitle) . "', '"; 
    $sql = $sql . mysql_real_escape_string($mPresenter) . "', '"; 
    $sql = $sql . $mAttendance . "', '";
    $sql = $sql . $mDonations . "', '";
    $sql = $sql . $mDinnerCnt . "', '";
    $sql = $sql . $mNurseryCnt . "', '";
    $sql = $sql . $mChildrenCnt . "', '";
    $sql = $sql . $mYouthCnt . "', '";
    $sql = $sql . mysql_real_escape_string($mNotes) . "')";
    
    $tmp = "meetings.php";
    executeSQL($sql,$MID);
    /* testSQL($sql); */
}

function updateMeetingInDB(){
    /* 
     * this routine updates an existing record in the database
     */
    /* need the following $link command to use the escape_string function */
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
    
    
    $ID = $_GET['ID']; 
    $mDate = $_POST['mtgDate'];
    $mType = $_POST['mtgType'];
    $mTitle = $_POST['mtgTitle'];
    $mPresenter = $_POST['mtgPresenter'];
    $mAttendance = $_POST['mtgAttendance'];
    $mDonations = $_POST['mtgDonations'];
    $mDinnerCnt = $_POST['mtgDinnerCnt'];
    $mNurseryCnt = $_POST['mtgNurseryCnt'];
    $mChildrenCnt = $_POST['mtgChildrenCnt'];
    $mYouthCnt = $_POST['mtgYouthCnt'];
    $mNotes = $_POST['mtgNotes'];
    
    $sql = "UPDATE meetings SET MtgDate = '";
    $sql = $sql . $mDate . "', MtgType = '";
    $sql = $sql . $mType . "', MtgTitle = '";
    $sql = $sql . mysql_real_escape_string($mTitle) . "', MtgPresenter = '";
    $sql = $sql . mysql_real_escape_string($mPresenter) . "', MtgAttendance = '";
    $sql = $sql . $mAttendance . "', ";
    $sql = $sql . "Donations = ";
    $sql = $sql . $mDonations . ", ";
    $sql = $sql . "DinnerCnt = '" . $mDinnerCnt . "', ";
    $sql = $sql . "NurseryCnt = '" . $mNurseryCnt . "', ";
    $sql = $sql . "ChildrenCnt = '" . $mChildrenCnt . "', ";
    $sql = $sql . "YouthCnt = '" . $mYouthCnt . "', ";
    $sql = $sql . "MtgNotes = '" . mysql_real_escape_string($mNotes) . "'";
    $sql = $sql . " WHERE ID = '" . $ID . "'";
    
    executeSQL($sql);
    //testSQL($sql);
}

function deleteGroup(){
/*==========================================================
    this routine deletes the group from the ID passed in
==========================================================*/
    $id = $_GET['GID'];
    
    // need to ensure that we have a GID
    if ($id > 0){
        $sql = "DELETE FROM groups WHERE ID = " . $id;
        
        $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        // Check connection
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        mysqli_query($con,$sql);

        mysqli_close($con);
        $dest = "mtgForm.php?ID=" . $_GET['MID'];
        //testSQL($sql);
        destination(307, $dest);
    
        
    }
    
}
function PreLoadGroups($MID){
    /*======================================================================
     * this function copies the groups from the previous meeting to the 
     * meeting ID passed in.
     ======================================================================*/
    $dbcon=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if (mysqli_connect_errno()){    
        die("Database connection failed: " .
        mysqli_connect_error() .
        " (" . mysqli_connect_error() . ")");
    }
    /*#############################################
     * GET THE LAST MEETING ID TO GET GROUPS FROM
     *############################################*/
    $query = "SELECT ";
    $query .= "groups.MtgID ";
    $query .= "FROM groups ";
    $query .= "INNER JOIN ";
    $query .= "meetings ON groups.MtgID = meetings.ID ";
    $query .= "ORDER BY meetings.MtgDate DESC";
    // echo "<br />" . $query . "<br /><hr /";
    $result = mysqli_query($dbcon, $query);
    if (!result){
        die("Database query failed.");
    }
    $grpIDs = mysqli_fetch_assoc($result);
    $lastMtgID = $grpIDs["MtgID"];
    mysqli_free_result($result); 
    // echo "<br />lastMtgID=" . $lastMtgID . "<br/>";
    /*****************************************************
     * Now get the groups from that last meeting in array
     * ===================================================
     * we need:
     *      FacID
     *      CoFacID
     *      Gender
     *      Location
     *      Title
     * ===================================================
     *****************************************************/
    $query = "SELECT ";
    $query .= "groups.FacID, groups.CoFacID, groups.Gender, ";
    $query .= "groups.Location, groups.Title ";
    $query .= "FROM groups ";
    $query .= "WHERE groups.MtgID = " . $lastMtgID . " ";
    $query .= "ORDER BY groups.Gender, groups.Title";
    $result = mysqli_query($dbcon, $query);
    $group = array();
    $FacID = array();
    $CoFacID = array();
    $Gender = array();
    $Location = array();
    $Title = array();
    
    if (!result){
        die("Database query failed.");
    }
    $grpCnt = 0;
    while($groups = mysqli_fetch_assoc($result)){
        /*========================================/
         * now load array with groups retrieved
         *****************************************/
        $FacID[$grpCnt] = $groups["FacID"];
        $CoFacID[$grpCnt] = $groups["CoFacID"];
        $Gender[$grpCnt] = $groups["Gender"];
        $Location[$grpCnt] = $groups["Location"];
        $Title[$grpCnt] = $groups["Title"];
        ++$grpCnt;
    }
    mysqli_free_result($result); 
    $i = 0;
    while ($i < $grpCnt){
        /*****************************
         * print group
         *****************************/
        //echo $Gender[$i] . " " . $Title[$i] . " in " . $Location[$i] . "<br/>";
        ++$i;
    }
    /***********************************
     * insert data for new week
     ***********************************/
    $i = 0;
    while ($i < $grpCnt){
        $query = "INSERT INTO groups (FacID, CoFacID, Gender, Title, Location, MtgID)
            Values({$FacID[$i]}, {$CoFacID[$i]}, {$Gender[$i]}, '{$Title[$i]}',
                '{$Location[$i]}', {$MID})";
               
        //echo "query:" . $query . "<br/><hr />";        
        $result = mysqli_query($dbcon, $query);
        if (!$result){
            die("Database query INSERT failed");    
        }
        ++$i;
    }
    
    mysqli_close($dbcon);
    $dest = "mtgForm.php?ID=" . $MID;
    destination(307, $dest);
}

function executeSQL($sql){
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
    
    destination(307, "meetings.php");
    
}

function testSQL($sql){
    /* 
     * this function executes the sql passed in 
     */
   echo "SQL: " . $sql;
}
?>
