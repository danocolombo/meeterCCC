<?php
include 'mtgRedirects.php';
require 'meeter.php';
require 'includes/database.inc.php';
require 'includes/meeting.inc.php';
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

    //since the add sql statement might be quite large dependind on the application
    // configuration, we will do it in parts.
    //-----------------------------------------------------------------------------------------------------
    // start with required fields, we know we check for mtgDate, mtgType and mtgTitle
    //-----------------------------------------------------------------------------------------------------
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
    OR die(mysql_error());
    
    //we are going to check our values:
    $fDate = $_POST['mtgDate'];
    $time = strtotime($fDate);
    $mtgDate = date('Y-m-d',$time);
    
    $mtgType = $_POST['rdoMtgType'];
    $mtgTitle = $_POST['mtgTitle'];
    
    $mtgFac = $_POST['mtgCoordinator'];
    $mtgAttendance = $_POST['mtgAttendance'];
    $mtgDonations = $_POST['mtgDonations'];
    $mtgWorshipFac = $_POST['mtgWorship'];
    $mtgAudioVisualFac = $_POST['mtgAV'];
    $mtgSetupFac = $_POST['mtgSetup'];
    $mtgTransportationFac = $_POST['mtgTransportation'];
    $mtgGreeter1Fac = $_POST['mtgGreeter1'];
    $mtgGreeter2Fac = $_POST['mtgGreeter2'];    
    $mtgResourcesFac = $_POST['mtgResources'];
    
    $mtgMenu = $_POST['mtgMenu'];
    $mtgMealCnt = $_POST['mtgMealCnt'];
    $mtgMealFac = $_POST['mtgMealFac'];
    
    $mtgReader1Fac = $_POST['mtgReader1'];
    $mtgReader2Fac = $_POST['mtgReader2'];
    $mtgAnnouncementsFac = $_POST['mtgAnnouncements'];
    $mtgTeachingFac = $_POST['mtgTeaching'];
    $mtgChips1Fac = $_POST['mtgChips1'];
    $mtgChips2Fac = $_POST['mtgChips2'];
    $mtgNewcomers1Fac = $_POST['mtgNewcomers1'];
    $mtgNewcomers2Fac = $_POST['mtgNewcomers2'];
    $mtgSerenityFac = $_POST['mtgSerenity'];
    
    $mtgNurseryCnt = $_POST['mtgNursery'];
    $mtgNurseryFac = $_POST['mtgNurseryFac'];
    $mtgChildrenCnt = $_POST['mtgChildren'];
    $mtgChildrenFac = $_POST['mtgChildrenFac'];
    $mtgYouthCnt = $_POST['mtgYouth'];
    $mtgYouthFac = $_POST['mtgYouthFac'];
    
    $mtgCafeFac = $_POST['mtgCafe'];
    $mtgTearDownFac = $_POST['mtgTearDown'];
    $mtgSecurityFac = $_POST['mtgSecurity'];
    
    $mtgNotes = $_POST['mtgNotes'];
    

    
    
    
    // ????????????????????????????????????????????????????
    // need to check if a similar meeting is already loaded
    // ????????????????????????????????????????????????????
//     define('DB_HOST', 'localhost');
//     define('DB_USER', 'dcolombo_muat');
//     define('DB_PASSWORD', 'MR0mans1212!');
//     define('DB_NAME', 'dcolombo_muat');
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $dbID = 0;
    $stmt = $connection->prepare("Select ID, MtgDate, MtgType, MtgTitle FROM meetings WHERE MtgDate = ? AND MtgType = ? AND MtgTitle = ?");
    $stmt->bind_param("sss", $mtgDate, $mtgType, $mtgTitle);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0){
        //echo "already entered";
        $stmt->bind_result($ID, $dbDate, $dbType, $dbTitle);
        while($stmt->fetch()){
            $mtgID = $ID;
        }
        $stmt->free_result();
        $stmt->close();
        $connection->close();
        destination(307, "error.php?ErrorCode=3001&ErrorMsg=\"That%20meeting%20already%20exists\"&ID=$mtgID");
    }

//     // get the basic values from the form, theses are not required... these are all dropdowns
//         echo "mtgID:" . $mtg->getMtgID() . "<br/>";
//         echo "mtgDate:" . $mtg->getMtgDate() . "<br/>";
//         echo "mtgTitle:" . $mtg->getMtgTitle() . "<br/>";
//         echo "mtgFac:" . $mtg->getMtgFac() . "<br/>";
//         echo "mtgAttendance:" . $mtg->getMtgAttendance() . "<br/>";
//         echo "Donations:" . $mtg->getDonations() . "<br/>";
//         echo "WorshipFac:" . $mtg->getWorshipFac() . "<br/>";
//         echo "AudioVisualFac:" . $mtg->getAudioVisualFac() . "<br/>";
//         echo "SetupFac:" . $mtg->getSetupFac() . "<br/>";
//         echo "TransportationFac:" . $mtg->getTransportationFac() . "<br/>";
//         echo "Greeter1Fac:" . $mtg->getGreeter1Fac() . "<br/>";
//         echo "Greeter2Fac:" . $mtg->getGreeter2Fac() . "<br/>";
//         echo "ResourcesFac:" . $mtg->getResourcesFac() . "<br/>";
//         echo "Menu:" . $mtg->getTransportationFac() . "<br/>";
//         echo "MealCnt:" . $mtg->getMealCnt() . "<br/>";
//         echo "MealFac:" . $mtg->getMealFac() . "<br/>";
//         echo "Reader1Fac:" . $mtg->getReader1Fac() . "<br/>";
//         echo "Reader2Fac:" . $mtg->getReader2Fac() . "<br/>";
//         echo "AnnouncementsFac:" . $mtg->getAnnouncementsFac() . "<br/>";
//         echo "TeachingFac:" . $mtg->getTeachingFac() . "<br/>";
//         echo "Chips1Fac:" . $mtg->getChips1Fac() . "<br/>";
//         echo "Chips2Fac:" . $mtg->getChips2Fac() . "<br/>";
//         echo "Newcomers1Fac:" . $mtg->getNewcomers1Fac() . "<br/>";
//         echo "Newcomers2Fac:" . $mtg->getNewcomers2Fac() . "<br/>";
//         echo "SerenityFac:" . $mtg->getSerenityFac() . "<br/>";
//         echo "NurseryCnt:" . $mtg->getNurseryCnt() . "<br/>";
//         echo "NurseryFac:" . $mtg->getNurseryFac() . "<br/>";
//         echo "ChildrenCnt:" . $mtg->getChildrenFac() . "<br/>";
//         echo "ChildrenFac:" . $mtg->getChildrenFac() . "<br/>";
//         echo "YouthCnt:" . $mtg->getYouthCnt() . "<br/>";
//         echo "YouthFac:" . $mtg->getYouthFac() . "<br/>";
//         echo "CafeFac:" . $mtg->getCafeFac() . "<br/>";
//         echo "TearDownFac:" . $mtg->getTearDownFac() . "<br/>";
//         echo "SecurityFac:" . $mtg->getSecurityFac() . "<br/>";
//         echo "Notes:" . $mtg->getNotes() . "<br/>";
    
//         exit();
    //--------------------------------------------------------------
    // no record found, proceed to add the entry
    //--------------------------------------------------------------
    $stmt->close();

//     $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $stmt = $connection->prepare("INSERT INTO `meetings` ( `MtgDate`, `MtgType`, `MtgTitle`) VALUES ( ?, ?, ?)");
    $stmt->bind_param("sss", $mtgDate, $mtgType, $mtgTitle );
    $stmt->execute();
    $stmt->close();
    //--------------------------------------------------------------
    // get the ID just created with the insert
    //--------------------------------------------------------------
//     $stmt = $connection->prepare("Select ID FROM meetings WHERE MtgDate = ? AND MtgType = ? AND MtgTitle = ?");
//     $stmt->bind_param("sss", $mtgDate, $mtgType, $mtgTitle);
//     $stmt->execute();
//     $stmt->bind_result($ID);
    $sql = "SELECT ID FROM meetings WHERE MtgDate = '";
    $sql .= $mtgDate . "' AND MtgType = '";
    $sql .= $mtgType . "' AND  MtgTitle = '";
    $sql .= $mtgTitle . "'";
//     echo "sql: $sql<br/>";
    $result = $connection->query($sql, MYSQLI_STORE_RESULT);
    list($returnedID) = $result->fetch_row();
    $mtgID = $returnedID;
    $result->close();
//     $stmt->fetch();
//     $stmt->close();
    //----------------------------------------------------------
    //now add (update) in sections 
    //----------------------------------------------------------

//     $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $sql = "UPDATE meetings SET MtgFac = ?, MtgAttendance = ?, Donations = ?, MtgWorship = ?, AudioVisualFac = ?, ";
    $sql .= "SetupFac = ?, TransportationFac = ?, Greeter1Fac = ?, Greeter2Fac = ?, ResourcesFac = ? WHERE ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iidiiiiiiii",
        $mtgFac,
        $mtgAttendance,
        $mtgDonations,
        $mtgWorshipFac,
        $mtgAudioVisualFac,
        $mtgSetupFac,
        $mtgTransportationFac,
        $mtgGreeter1Fac,
        $mtgGreeter2Fac,
        $mtgResourcesFac,
        $mtgID);
    $stmt->execute();
    $stmt->close();
    
//     echo "MealCnt = $mtgMealCnt<br/>";
//     echo "MealFac = $mtgMealFac<br/>";
//     echo "Reader1Fac = $mtgReader1Fac<br/>";
//     echo "Reader2Fac = $mtgReader2Fac<br/>";
//     echo "AnnouncementsFac = $mtgAnnouncementsFac<br/>";
//     echo "TeachingFac = $mtgTeachingFac<br/>";
//     echo "Chips1Fac = $mtgChips1Fac<br/>";
//     echo "Chips2Fac = $mtgChips2Fac<br/>";
//     echo "SerenityFac = $mtgSerenityFac<br/>";
//     echo "ID = $mtgID<br/>";
//     exit();
    $sql = "UPDATE meetings SET MealCnt = ?, MealFac = ?, Reader1Fac = ?, Reader2Fac = ?, AnnouncementsFac = ?, ";
    $sql .= "TeachingFac = ?, Chips1Fac = ?, Chips2Fac = ?, SerenityFac = ? WHERE ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iiiiiiiiii",
        $mtgMealCnt,
        $mtgMealFac,
        $mtgReader1Fac,
        $mtgReader2Fac,
        $mtgAnnouncementsFac,
        $mtgTeachingFac,
        $mtgChips1Fac,
        $mtgChips2Fac,
        $mtgSerenityFac,
        $mtgID);
    $stmt->execute();
    $stmt->close();
    
    $sql = "UPDATE meetings SET Newcomers1Fac = ?, Newcomers2Fac = ?, NurseryCnt = ?, NurseryFac = ?, ";
    $sql .= "ChildrenCnt = ?, ChildrenFac = ?, YouthCnt = ?, YouthFac = ? WHERE ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iiiiiiiii",
        $mtgNewcomers1Fac,
        $mtgNewcomers2Fac,
        $mtgNurseryCnt,
        $mtgNurseryFac,
        $mtgChildrenCnt,
        $mtgChildrenFac,
        $mtgYouthCnt,
        $mtgYouthFac,
        $mtgID);
    $stmt->execute();
    $stmt->close();
    
    $sql = "UPDATE meetings SET CafeFac = ?, TearDownFac = ?, SecurityFac = ?, Menu = ?, ";
    $sql .= "MtgNotes = ? WHERE ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iiissi",
        $mtgCafeFac,
        $mtgTearDownFac,
        $mtgSecurityFac,
        mysql_real_escape_string($mtgMenu),
        mysql_real_escape_string($mtgNotes),
        $mtgID);
    $stmt->execute();
    $stmt->close();
    $connection->close();
      
    destination(307, "meetings.php");

}
function updateMeetingInDB(){
    /*
     * this routine updates an existing record in the database
     */
    /* need the following $link command to use the escape_string function */
    /*
     * this routine addes the form information to the database
     */
    /* need the following $link command to use the escape_string function */
    
    //since the add sql statement might be quite large dependind on the application
    // configuration, we will do it in parts.
    //-----------------------------------------------------------------------------------------------------
    // start with required fields, we know we check for mtgDate, mtgType and mtgTitle
    //-----------------------------------------------------------------------------------------------------
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
    OR die(mysql_error());
    
    //we are going to check our values:
    $mtgID = $_GET['MID'];
    $fDate = $_POST['mtgDate'];
    $time = strtotime($fDate);
    $mtgDate = date('Y-m-d',$time);
    $mtgType = $_POST['rdoMtgType'];
    $mtgTitle = $_POST['mtgTitle'];
    
    $mtgFac = $_POST['mtgCoordinator'];
    $mtgAttendance = $_POST['mtgAttendance'];
    $mtgDonations = $_POST['mtgDonations'];
    $mtgWorshipFac = $_POST['mtgWorship'];
    $mtgAudioVisualFac = $_POST['mtgAV'];
    $mtgSetupFac = $_POST['mtgSetup'];
    $mtgTransportationFac = $_POST['mtgTransportation'];
    $mtgGreeter1Fac = $_POST['mtgGreeter1'];
    $mtgGreeter2Fac = $_POST['mtgGreeter2'];
    $mtgResourcesFac = $_POST['mtgResources'];
    
    $mtgMenu = $_POST['mtgMenu'];
    $mtgMealCnt = $_POST['mtgMealCnt'];
    $mtgMealFac = $_POST['mtgMealFac'];
    
    $mtgReader1Fac = $_POST['mtgReader1'];
    $mtgReader2Fac = $_POST['mtgReader2'];
    $mtgAnnouncementsFac = $_POST['mtgAnnouncements'];
    $mtgTeachingFac = $_POST['mtgTeaching'];
    $mtgChips1Fac = $_POST['mtgChips1'];
    $mtgChips2Fac = $_POST['mtgChips2'];
    $mtgNewcomers1Fac = $_POST['mtgNewcomers1'];
    $mtgNewcomers2Fac = $_POST['mtgNewcomers2'];
    $mtgSerenityFac = $_POST['mtgSerenity'];
    
    $mtgNurseryCnt = $_POST['mtgNursery'];
    $mtgNurseryFac = $_POST['mtgNurseryFac'];
    $mtgChildrenCnt = $_POST['mtgChildren'];
    $mtgChildrenFac = $_POST['mtgChildrenFac'];
    $mtgYouthCnt = $_POST['mtgYouth'];
    $mtgYouthFac = $_POST['mtgYouthFac'];
    
    $mtgCafeFac = $_POST['mtgCafe'];
    $mtgTearDownFac = $_POST['mtgTearDown'];
    $mtgSecurityFac = $_POST['mtgSecurity'];
    
    $mtgNotes = $_POST['mtgNotes'];
    
    //DEBUG
//     echo "Greeter1: $mtgGreeter1Fac<br/>";
//     echo "Greeter2: $mtgGreeter2Fac<br/>";
//     echo "Reader1: $mtgReader1Fac<br/>";
//     echo "Reader2: $mtgReader2Fac<br/>";
//     echo "Chip1: $mtgChips1Fac<br/>";
//     echo "Chip2: $mtgChips2Fac<br/>";
//     echo "Newcomer1: $mtgNewcomers1Fac<br/>";
//     echo "Newcomer2: $mtgNewcomers2Fac<br/>";
//     echo "Menu: >>$mtgMenu<<<br/>";
//     exit();
    //----------------------------------------------------------
    //now add (update) in sections
    //----------------------------------------------------------
    $sql = "UPDATE meetings SET MtgDate = ?, MtgType = ?, MtgTitle = ? WHERE ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssi",
        $mtgDate,
        $mtgType,
        $mtgTitle,
        $mtgID);
    $stmt->execute();
    $stmt->close();
    
    
    $sql = "UPDATE meetings SET MtgFac = ?, MtgAttendance = ?, Donations = ?, MtgWorship = ?, AudioVisualFac = ?, ";
    $sql .= "SetupFac = ?, TransportationFac = ?, Greeter1Fac = ?, Greeter2Fac = ?, ResourcesFac = ? WHERE ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iidiiiiiiii",
        $mtgFac,
        $mtgAttendance,
        $mtgDonations,
        $mtgWorshipFac,
        $mtgAudioVisualFac,
        $mtgSetupFac,
        $mtgTransportationFac,
        $mtgGreeter1Fac,
        $mtgGreeter2Fac,
        $mtgResourcesFac,
        $mtgID);
    $stmt->execute();
    $stmt->close();
    
    $sql = "UPDATE meetings SET MealCnt = ?, MealFac = ?, Reader1Fac = ?, Reader2Fac = ?, AnnouncementsFac = ?, ";
    $sql .= "TeachingFac = ?, Chips1Fac = ?, Chips2Fac = ?, SerenityFac = ? WHERE ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iiiiiiiiii",
        $mtgMealCnt,
        $mtgMealFac,
        $mtgReader1Fac,
        $mtgReader2Fac,
        $mtgAnnouncementsFac,
        $mtgTeachingFac,
        $mtgChips1Fac,
        $mtgChips2Fac,
        $mtgSerenityFac,
        $mtgID);
    $stmt->execute();
    $stmt->close();
    
    $sql = "UPDATE meetings SET Newcomers1Fac = ?, Newcomers2Fac = ?, NurseryCnt = ?, NurseryFac = ?, ";
    $sql .= "ChildrenCnt = ?, ChildrenFac = ?, YouthCnt = ?, YouthFac = ? WHERE ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iiiiiiiii",
        $mtgNewcomers1Fac,
        $mtgNewcomers2Fac,
        $mtgNurseryCnt,
        $mtgNurseryFac,
        $mtgChildrenCnt,
        $mtgChildrenFac,
        $mtgYouthCnt,
        $mtgYouthFac,
        $mtgID);
    $stmt->execute();
    $stmt->close();
    
    $sql = "UPDATE meetings SET CafeFac = ?, TearDownFac = ?, SecurityFac = ?, Menu = ?, ";
    $sql .= "MtgNotes = ? WHERE ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iiissi",
        $mtgCafeFac,
        $mtgTearDownFac,
        $mtgSecurityFac,
        $mtgMenu,
        $mtgNotes,
//         mysql_real_escape_string($mtgNotes),
        $mtgID);
    $stmt->execute();
    $stmt->close();
    $connection->close();
    
    $dest = "meetings.php";
    //testSQL($sql);
    destination(307, $dest);
}
function updateMeetingInDB1(){
    /* 
     * this routine updates an existing record in the database
     */
    /* need the following $link command to use the escape_string function */
    include 'database.php';
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die(mysql_error());
    
    
    $ID = $_GET['ID']; 
    $mDate = $_POST['mtgDate'];
    $mType = $_POST['mtgType'];
    $mTitle = $_POST['mtgTitle'];
    $mPresenter = $_POST['mtgPresenter'];
    $mWorship = $_POST['mtgWorship'];
    $mAttendance = $_POST['mtgAttendance'];
    $mDonations = $_POST['mtgDonations'];
    $mMeal = htmlspecialchars($_POST['mtgMeal']);
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
    $sql = $sql . "MtgWorship = '";
    $sql = $sql . $mWorship . "', ";
    $sql = $sql . "Donations = ";
    $sql = $sql . $mDonations . ", ";
    $sql = $sql . "MtgMeal = '";
    $sql = $sql . $mMeal . "', ";
//     $sql = $sql . mysql_real_escape_string($mMeal) . "', ";
    $sql = $sql . "DinnerCnt = '" . $mDinnerCnt . "', ";
    $sql = $sql . "NurseryCnt = '" . $mNurseryCnt . "', ";
    $sql = $sql . "ChildrenCnt = '" . $mChildrenCnt . "', ";
    $sql = $sql . "YouthCnt = '" . $mYouthCnt . "', ";
    $sql = $sql . "MtgNotes = '" . mysql_real_escape_string($mNotes) . "'";
    $sql = $sql . " WHERE ID = '" . $ID . "'";
    
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    mysqli_query($con,$sql);

    mysqli_close($con);
    $dest = "meetings.php";
    //testSQL($sql);
    destination(307, $dest);
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
    include 'database.php';
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
