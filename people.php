<?php
require_once('authenticate.php'); /* used for security purposes */
include 'database.php';
include 'meeter.php';
include 'peopleAOS.php';
include 'mtrAOS.php';
include 'includes/people.inc.php';

global $person;
$person = new MeeterPeep();     //meeter.php
//header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//require_once('authenticate.php'); /* for security purposes */
//include 'meeterRedirects.php';
//include 'database.php';
/*
 * Meeter - people.php
 * ======================================================
 */

/********************************************
 * require_once("classPage.php");
 * $page = new Page();
 * print $page->getTop();
 *******************************************/
$Action = $_GET["Action"];
$Destination = $_GET["Destination"];
$Origin = $_GET["Origin"];
$ID = $_GET["ID"];
$PID = $_GET["PID"];
/*************************************************
 * if new or edit a person we need the following
 * loaded for use. It is up here because we need
 * to load special javascript in the header
 *************************************************/
// if ($Action == "New" || $Action == "Edit" || $Action == "NewPeep"){
    //loads the user information;
//     global $person;
//     $person->getPerson($PID);
    
//     //loads the system configuration
//     global $sAOS;
//     $sAOS = new mConfig();
//     $sAOS->loadConfigFromDB();
    
//     global $peepAOS;
//     $peepAOS= new pConfig();
//     $peepAOS->loadDisplayAOS($PID);
// }

/******************************************************************
 * new meeter header
 ***************************************************************** */
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
        <script type="text/javascript">
			function validateForm(){
				var x = document.forms["peepForm"]["peepFName"].value;
				if (x == ""){
					alert("Name is required.");
					var elem = document.getElementByID("FName");
					elem.focus();
					elem.select();
					return false;
				}else{
					//now depending on the button value, we will take action.
					var b = document.getElementById("submitButton").value;
					if (b == "add"){
						document.getElementById("peepForm").submit();
						return true;
					}else if(b == "update"){
						document.getElementById("peepForm").submit();
						return true;
					}
				}
			}
			function selectAllCommits(){
				// this function enables the checkbox for all configured commit options for the current user
				<?php 
				//-----------------------------------------------------------------------
				// we will build the javascript necessary to select all AOS checkboxes
				//-----------------------------------------------------------------------
				$ckCommits = new mConfig();
				$ckCommits->loadConfigFromDB();
				foreach($ckCommits->AOS as $key => $value){
				    // if the value for the key is false or DisplayValue is NOSHOW, skip
				    $parts = explode("#", $value);
				    if ($parts[0] == "true"){
				        if ($parts[1] != "NOSHOW"){
				            $tmp = "cb_" . $key;
				            echo "\t\t\t\t" . $tmp . ".checked = true;\n";
				        }
				    }
				}
				?>
				return false;
			}
			function deselectAllCommits(){
				// this function enables the checkbox for all configured commit options for the current user
				<?php 
				//-----------------------------------------------------------------------
				// we will build the javascript necessary to select all AOS checkboxes
				//-----------------------------------------------------------------------
				$uckCommits = new mConfig();
				$uckCommits->loadConfigFromDB();
				foreach($uckCommits->AOS as $key => $value){
				    // if the value for the key is false or DisplayValue is NOSHOW, skip
				    $parts = explode("#", $value);
				    if ($parts[0] == "true"){
				        if ($parts[1] != "NOSHOW"){
				            $tmp = "cb_" . $key;
				            echo "\t\t\t\t" . $tmp . ".checked = false;\n";
				        }
				    }
				}
				?>
				return false;
			}
			
			function ExitPeopleForm(){
				// lets go back to the people list
				window.location.href='people.php';
						return true;
			}
			function validateDeleteUser(){
				// if user is trying to delete system user "Removed User", then echo message that
				// action is not possible. 
				//--------------------------------------------------------------------------------
				var FName = document.forms["peepForm"]["peepFName"].value;
				var LName = document.forms["peepForm"]["peepLName"].value;
				if(FName == "Removed" && LName == "User"){
					// user is trying to delete system entry. Post warning and abort
					alert("The entry you are trying to delete is used by the system, and can\'t be removed");
					return false;
				}
				//check if the current user is set to active
				var aFlag = document.getElementById("peepActive").checked;
				if(aFlag == true){
					alert("It is recommended you make the person \'inactive\' rather than deleting.");
					var x = confirm("Press OK if you want to really delete. All references in the system will be lost");
					if (x == true){
						var recordID = getUrlVars()["PID"];
						var newURL = "peepDelete.php?Action=DeletePeep&PID=" + recordID;
						window.location.href=newURL;
						return true;	
					}else{
						return false;
					}
				}
				var x2 = confirm("Click \'OK\' if you are sure you want to delete this user.");
				if (x2 == true){
					var recordID = getUrlVars()["PID"];
					//alert(recordID);
					//alert("DELETE");
					var dest = "peepDelete.php?Action=DeletePeep&PID=" + recordID;
					window.location.href=dest;
				}else{
					alert("Delete User aborted.");
					return false;
				}
			}
			function getUrlVars() {
			    var vars = {};
			    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			        vars[key] = value;
			    });
			    return vars;
			}
        </script>
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
    /**********************************
     * finish generic header above
     **********************************/
/*####################################################
 * START MAIN PROCESSING
 * ###################################################
 */



switch ("$Action"){     
    case "Edit":
        showForm("Edit","","", $ID);
        break;
    case "TraineeList":
        $TID = $_GET["TID"];
        showPeepsToTrain($TID);
        break;
    case "TeamList":
        $TID = $_GET["TID"];
        $TeamTitle = $_GET["TeamTitle"];
        showPeepsToDraft($TID, $TeamTitle);
        break;
    case "TeamCandidates":
        $TID = $_GET["TID"];
        $TeamTitle = $_GET["TeamTitle"];
        showDraftList($TID, $TeamTitle);
        break;
    case "NewTrainee":
        /*============================================
         * Need to display blank form to add new person
         * for adding to training
         *============================================
         */
        $TID = $_GET["TID"];
        showForm("NewTrainee", "", "", $TID);
        break;
    case "NewPeep":
        /*============================================
         * Need to display blank form to add new person
         * for adding to system
         *============================================
         */
        showForm("NewPeep", "", "", $TID);
        break;
    case "New":
        /*============================================
         * Need to display blank form to add new person
         * for adding to system
         *============================================
         */
        showForm("New", $_GET['Origin'], $_GET['Dest'], $_GET['$TID']);
        break;
    case "ShowAll":
        /*==================================================
         * show all active and non-active people in system
         * =================================================
         */
        showAllPeople();
        break;
    
    default:
        showPeopleList();
        break;
}

/************************************************
 * end the page definition, now close window
 ***********************************************/
?>
	</article>
	<footer>
		&copy; 2013-2018 Rogue Intelligence
	</footer>
</div>
        <script src="js/meeter.js"></script>
</body>
</html>

<?php 
/*************************************************
 * END OF HTML OUTPUT
**************************************************/
/*************************************************
 * functions for processing below
*************************************************/
function showPeopleList() {
   include 'database.php';
   echo "<center><h1>CR Personnel</h1>";

   if($connection->errno > 0){
       printf("Mysql error number generated: %d", $connection->errno);
       exit();
   }
   $query = "SELECT * FROM people WHERE Active = '1' order by FName";
   $result = $connection->query($query, MYSQLI_STORE_RESULT);
   //echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=NewPeep'>NEW ENTRY</a></div>";
   echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=ShowAll'><img src='images/btnShowAll.gif'/></a></div>";
   echo "<table>";
   while(list($ID, $FName, $LName) = $result->fetch_row()){
           echo "<tr><td>";
           echo "<a href='people.php?Action=Edit&PID=" . $ID . "'><img src='images/btnEdit.gif'></img></a></td>";
           echo "<td>&nbsp;" . $FName . " " . $LName . "</td></tr>";
   }
   echo "</table>";
   
}
function showAllPeople() {
   include 'database.php';
   echo "<center><h1>CR Personnel</h1>";

   if($connection->errno > 0){
       printf("Mysql error number generated: %d", $connection->errno);
       exit();
   }
   $query = "SELECT ID, FName, LName, Active FROM people order by FName";
   $result = $connection->query($query, MYSQLI_STORE_RESULT);
   echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=NewPeep'>NEW ENTRY</a></div>";
   //echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=ShowAll'><img src='images/btnShowAll.gif'/></a></div>";
   echo "<table>";
   while(list($ID, $FName, $LName, $Active) = $result->fetch_row()){
           echo "<tr><td valign='bottom'>";
           echo "<a href='people.php?Action=Edit&PID=" . $ID . "'><img src='images/btnEdit.gif'></img></a></td>";
           echo "<td valign='bottom'>" . $FName . " " . $LName . " ";
           if ($Active == '0'){
               echo "<a href=peepAction.php?Action=Activate&ID=" . $ID . "'><img src='images/btnInActive.gif' height='20' valign='bottom'/></a>";
           }
                   
                   
                   "</td></tr>";
   }
   echo "</table>";
   
}

function showForm($action, $origin, $destination, $ID){
    /*##########################################################
     * showForm function
     * #########################################################
     */
    /* echo "showForm(" . $action . ", " . $origin . ", " . $destination . ")"; */
    $PID = $_GET["PID"];
    
    include 'database.php';
   
   if($connection->errno > 0){
       printf("Mysql error number generated: %d", $connection->errno);
       exit();
   }
    switch ($action){
        case "New":
            switch ($_GET['Origin']){
                case "grpForm":
                    $dest = "peepAction.php?Action=AddPerson&Origin=grpForm&GID=" . $_GET['GID'] . "&MID=" . $_GET['MID'];
                    break;
                case "trnForm":
                    $dest = "peepAction.php?Action=AddPerson&Origin=trnForm&ID=" . $_GET['ID'];
                    break;
                case "mtgForm_Default":
                    $dest = "peepAction.php?Action=AddPerson&Origin=mtgForm";
                    break;
                case "mtgForm_Edit":
                    $dest = "peepAction.php?Action=AddPerson&Origin=mtgForm&ID=" . $_GET['MID'];
                    break;
                default:
                    $dest = "peepAction.php?Action=AddPerson&Origin=" . $origin;
                    break;
            }
            
            break;
        case "Edit":
            
            $dest = "peepAction.php?Action=Update&PID=" . $PID;
            /*---------------------------------------------------
             * get the peep info
             * --------------------------------------------------
             */
//             if($connection->errno > 0){
//                 printf("Mysql error number generated: %d", $connection->errno);
//                 exit();
//             }
            
//             $query = "SELECT * FROM people WHERE ID =" . $PID;
//             $result = $connection->query($query, MYSQLI_STORE_RESULT);
//             list($ID, $FName, $LName, $Address, $City, $State, $Zipcode, $Phone1, 
//                     $Phone2, $Email1, $Email2, 
//                     $RecoveryArea, $RecoverySince, $CRSince, $Covenant,
//                     $SpiritualGifts, $AreasServed, $JoyAreas, $ReasonsToServe,
//                     $FellowshipTeam, $PrayerTeam, $NewcomersTeam,
//                     $GreetingTeam, $SpecialEventsTeam, $ResourceTeam,
//                     $SmallGroupTeam, $StepStudyTeam, $TransportationTeam,
//                     $WorshipTeam, $LandingTeam, $CelebrationPlaceTeam,
//                     $SolidRockTeam, $MealTeam, $CRImen, $CRIwomen, $TeachingTeam,
//                     $Chips, $Active, $Notes) = $result->fetch_row(); 
            /*---------------------------------------------------
             * see if there is any training attended
             ====================================================*/
            /*
             $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
             
            if($mysqli->errno > 0){
                printf("Mysql error number generated: %d", $mysqli->errno);
                exit();
            }
            $query = "SELECT training.tDate training.tTitle";
            $query = $query . " FROM training INNER JOIN ";
            $query = $query . " trainees ON training.ID = trainees.TID";
            $query = $query . " WHERE trainees.PID='" . $ID . "'";
            
            $education = array();
            $result = $mysqli->query($query);
            while ($row = $result->fetch_array(MYSQLI_ASSOC))
            {
                $education[] = array($row['eDate'], $row['eTitle']);
            } 
             * 
             */
            break;
        
        case "NewTrainee":
            /*---------------------------------------------------
             * 
             *---------------------------------------------------
             */
            $dest = "peepAction.php?Action=AddPerson&TID=" . $ID;
            break;
        case ("NewPeep"):
            /*---------------------------------------------------
             * 
             *---------------------------------------------------
             */
            $dest = "peepAction.php?Action=AddPerson";
            break;
        default:
            $dest = "people.php";
            break; 
    }
    //loads the user information;
    global $person;
    $person->getPerson($PID);
    
    //loads the system configuration
    global $sAOS;
    $sAOS = new mConfig();
    $sAOS->loadConfigFromDB();
    
    global $peepAOS;
    $peepAOS= new pConfig();
    $peepAOS->loadDisplayAOS($PID);
    echo "<form id='peepForm' action='" . $dest . "' method='post'>";
    echo "<center><h2>CR Personnel Form</h2></center>";
    echo "<center>";
    echo "<table border='0'>";
    echo "<tr><td align='right'>First Name:</td><td><input type='text' id='peepFName' name='peepFName' size='15' value='" . htmlspecialchars($person->getFName(),ENT_QUOTES) . "'/></td></tr>";

    echo "<tr><td align='right'>Last Name:</td><td><input type='text' id='peepLName' name='peepLName' size='15' value='" . htmlspecialchars($person->getLName(),ENT_QUOTES) . "'/></td></tr>";     
    echo "<tr><td align='right'>Address:</td><td><input type='text' id='peepAddress' name='peepAddress' size='25' value='" . htmlspecialchars($person->getStreet(),ENT_QUOTES) . "'/></td></tr>";     
    echo "<tr><td align='right'>City:</td><td><input type='text' id='peepCity' name='peepCity' size='15' value='" . htmlspecialchars($person->getCity(),ENT_QUOTES) . "'/> ";
    echo "<tr><td align='right'>State:</td><td><input type='text' id='peepState' name='peepState' size='2' value='" . htmlspecialchars($person->getState(),ENT_QUOTES) . "'/>";     
    echo "<tr><td align='right'>Zipcode:</td><td><input type='text' id='peepZipcode' name='peepZipcode' size='25' value='" . htmlspecialchars($person->getPostalCode(),ENT_QUOTES) . "'/></td></tr>";       
    echo "<tr><td align='right'>Phone 1:</td><td><input type='text' id='peepPhone1' name='peepPhone1' size='15' value='"  . htmlspecialchars($person->getPhone1(),ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Phone 2:</td><td><input type='text' id='peepPhone2' name='peepPhone2' size='15' value='"  . htmlspecialchars($person->getPhone2(),ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Email 1:</td><td><input type='text' id=peepEmail1' name='peepEmail1' size='40' value='"  . htmlspecialchars($person->getEmail1(),ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Email 2:</td><td><input type='text' id='peepEmail2' name='peepEmail2' size='40' value='"  . htmlspecialchars($person->getEmail2(),ENT_QUOTES) . "'/></td></tr>";
    
    echo "<tr><td align='right'>Spiritual Gifts:</td><td><textarea id='peepSpiritualGifts' name='peepSpiritualGifts' cols='40' rows='2'>" . htmlspecialchars($person->getSpiritualGifts(),ENT_QUOTES) . "</textarea></td></tr>";
    echo "<tr><td align='right'>Recovery Area:</td><td><textarea id='peepRecoveryArea' name='peepRecoveryArea' cols='40' rows='2'>" . htmlspecialchars($person->getRecoveryArea(),ENT_QUOTES) . "</textarea></td></tr>";
    echo "<tr><td align='right'>Recovery Since:</td><td><input type='text' id='peepRecoverySince' name='peepRecoverySince' size='15' value='" . htmlspecialchars($person->getRecoverySince(),ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>CR Since:&nbsp;</td><td><input type='text' id='peepCRSince' name='peepCRSince' size='15' value='" . htmlspecialchars($person->getCrSince(),ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Covenant Date:&nbsp;</td><td><input type='text' name='peepCovenant' size='15' value='" . htmlspecialchars($person->getCovenantDate(),ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Areas Served:</td><td><textarea id='peepAreasServed' name='peepAreasServed' cols='40' rows='4'>" . htmlspecialchars($person->getAreasServed(),ENT_QUOTES) . "</textarea></td></tr>";
    echo "<tr><td align='right'>Joy Areas:</td><td><textarea id='peepJoyAreas' name='peepJoyAreas' cols='40' rows='4'>" . htmlspecialchars($person->getJoyAreas(),ENT_QUOTES) . "</textarea></td></tr>";
    echo "<tr><td align='right'>Reasons To Serve:</td><td><textarea peepReasonsToServe' name='peepReasonsToServe' cols='40' rows='5'>" . htmlspecialchars($person->getReasonsToServe(),ENT_QUOTES) . "</textarea></td></tr>";
    echo "</table>";
    echo "<table border='0'><tr><td colspan='3'></td></tr>";   // opens the section
    echo "<tr><td valign='top'><table border='3'><tr><td>";             // border around interests
    /* ############################################
     *     AOS TABLE
     #############################################*/
    echo "<table border='0'>";                     //table formatting interests
    echo "<tr><td colspan='2' align='center'><strong>Areas of Interest</strong></td></tr>";
    echo "</td></tr>";
    /* =======================================================
     * the values listed to volunteer/serve in are based on the Meeter configuration stored in the
     * database Meeter["AOS"].  Then the values are based on whether the PID has any of the
     * managed fields selected in the people table AOS setting.
     ========================================================*/
    foreach($sAOS->AOS as $sk => $sv){
        //$sv contains string enabled#displayValue
        $enabled = explode("#", $sv);
        
        if ($enabled[0] == "true"){
            
            if ($sAOS->getDisplayString($sk) != "NOSHOW"){
                echo "<tr><td align='right'>" . $sAOS->getDisplayString($sk) . "&nbsp;</td><td><input type='checkbox' id='cb_$sk' name='cb_$sk' ";
//                 echo "<tr><td align='right'>" . $sAOS->getDisplayString($sk) . "&nbsp;</td><td><input type='checkbox' id='cb_$sk' value='cb_$sk' name='cbCommit' ";
                if ($peepAOS->doesSettingExist($sk)){
                    echo "checked>&nbsp;</td></tr>";
                }else{
                    echo ">&nbsp;</td></tr>";
                }
            }
        }
    }
    
    
    foreach($peepAOS->displayAOS as $key => $value){
        //display the configured settings from the database along with the user settings
        if($value == "true"){
            echo "<tr><td align='right'>$key:&nbsp;</td><td><input type='checkbox' id='cb$key' name='cb$key' checked>&nbsp;</td></tr>";
//             echo "<tr><td align='right'>$key:&nbsp;</td><td><input type='checkbox' id='cb$key' value='cb$key' name='cbCommit' checked>&nbsp;</td></tr>";
        }else {
            echo "<tr><td align='right'>$key:&nbsp;</td><td><input type='checkbox' id='cb$key' name='cb$key'>&nbsp;</td></tr>";
//             echo "<tr><td align='right'>$key:&nbsp;</td><td><input type='checkbox' id='cb$key' value='cb$key' name='cbCommit'>&nbsp;</td></tr>";
        }
    }
    echo "<tr><td aiign='right'><button type='button' id='selectBtn' onclick='selectAllCommits()'>Check All</button>&nbsp;&nbsp;
        <button type='button' id='selectBtn' onclick='deselectAllCommits()'>Clear All</button></td></tr>";
    echo "</table>";          //closes table formatting interests
    echo "</td></tr></table>"; //closes table around interests
    

    // now create the table on the right with the classes attended listed.
    echo "</td><td></td><td valign='top'><table border='4'><tr><td>";          //table around education
    
    //data section start
    if($connection->errno > 0){
        printf("Mysql error number generated: %d", $connection->errno);
        exit();
    }
    $query = "SELECT training.tDate, training.tTitle";
            $query = $query . " FROM training INNER JOIN ";
            $query = $query . " trainees ON training.ID = trainees.TID";
            $query = $query . " WHERE trainees.PID='" . $ID . "'";
            $query = $query . " ORDER BY tDate DESC";
    
    //echo $query;
    
    
    //$query = "SELECT * FROM people WHERE Active = '1' order by FName";
    $result = $connection->query($query, MYSQLI_STORE_RESULT);
    echo "<table><tr><td align='center'><strong>CR Leader Participation</strong></td></tr>";
    /** echo "<tr><td><hr/><td></tr>"; **/
    while(list($tDate, $tTitle) = $result->fetch_row()){
            echo "<tr><td>" . $tDate . " " . $tTitle . "</td></tr>";
    }
    echo "</table>";
    //data section stop
    
    
    
    //echo "<table border='0'><tr><td colspan='3'>EDUCATION</td></tr>"; //formatting education data
    //echo "<tr><td colspan='3'><hr/></td></tr>";
    //echo "<tr><td> 3/26/2014</td><td> - </td><td>Pathway to Leadership</td></tr>";
    //echo "</table>";           //closes education formatting
    echo "</td></tr></table>"; //closes the border around education
    echo "</td></tr></table>";           //closes the section table
    
    echo "<br/><table>"; //new table at bottom for notes
    echo "<tr><td align='right'>Notes:</td><td><textarea id='peepNotes' name='peepNotes' cols='40' rows='5'>" . htmlspecialchars($person->getNotes(),ENT_QUOTES) . "</textarea></td></tr>";
    if ($person->getActive()=="1"){
        echo "<tr><td align=\"right\">Active:</td><td><input type=\"checkbox\" id=\"peepActive\" name=\"peepActive\" checked></td></tr>";
    }else{
        echo "<tr><td align=\"right\">Active:</td><td><input type=\"checkbox\" id=\"peepActive\" name=\"peepActive\"></td></tr>";
    }
    
    
//     echo "<button type='button' id='newPeepClick' onclick='DoNewPersonSubmit()'>DoNewPersonSubmit()</button>&nbsp;";
//     echo "<button type='button' id='selectBtn' onclick='SelectNoInterests()'>COPY Clear All</button></td></tr>";
    echo "</table></center>";
    echo "<div align='center'><br/>";
    echo "<button type='button' id='cancelButton' onclick='ExitPeopleForm()'>&nbsp;Cancel&nbsp;</button>&nbsp;&nbsp";
    switch($action){
        case "Edit":
            echo "<button type='button' id='submitButton' onclick='validateForm()' value='update'>Update Record</button>";
            break;
        case "Add":
        case "NewPeep":
            echo "<button type='button' id='submitButton' onclick='validateForm()' value='add'>Add User</button>";
            break;
    }
    if($action == "Edit"){
        echo "<div style='float:right;'><button type='button' id='deleteButton' onclick='validateDeleteUser()' style='background:red;color:white;'>&nbsp;DELETE USER&nbsp;</button></div>";
    }
    echo "</div>";
}

function showPeepsToDraft($TID, $TeamTitle){
    /************************************************
     * displays a list to add to a team
     * **********************************************
     */
//    include 'mysql.connect.php';
    echo "<center><h1>Add members to " . $TeamTitle . "</h1>";

   if($connection->errno > 0){
       printf("Mysql error number generated: %d", $connection->errno);
       exit();
   }
   $query = "SELECT * FROM people order by FName";
   $result = $connection->query($query, MYSQLI_STORE_RESULT);
   echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=NewTrainee&TID=" . $TID . "'>NEW ENTRY</a></div>";
   echo "<table>";
   while(list($ID, $FName, $LName) = $result->fetch_row()){
           echo "<tr><td>";
           echo "<a href='teamAction.php?Action=AddMember&TID=" . $TID . "&PID=". $ID . "'><img src='images/plusbutton.gif'></img></a></td>";
           echo "<td>" . $FName . " " . $LName . "</td></tr>";
   }
   echo "</table>";
}

function showDraftList($TID, $TeamTitle){
    /************************************************
     * only shows people that can be added to team
     * **********************************************
     */
    include 'database.php';
    echo "<center><h1>Add members to " . $TeamTitle . "</h1>";

    if($connection->errno > 0){
        printf("Mysql error number generated: %d", $connection->errno);
        exit();
    }
    //get array of members on the team already
    $query = "SELECT PID FROM team_members WHERE TID = " . $TID;    
    $members = array();
    $team = array();
    $result = $connection->query($query);
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        $members[] = array($row['PID']);

    }
    $MemberCnt = $result->num_rows;
   
   // now skip the people aleady on the team 
   $query = "SELECT * FROM people";
   if ($MemberCnt > 0) {
       //if there are members of the team, omit them in SQL
       $query = $query . " WHERE";
       for($cnt=0;$cnt<$MemberCnt;$cnt++){
           $query = $query . " ID <> " . $members[$cnt][0];
           $testValue = $MemberCnt - 1;
           if ($cnt < $testValue){
                   $query = $query . " AND ";
           }
           
       }
   
   }
   
   $query = $query . " order by FName";

   
   $result = $connection->query($query, MYSQLI_STORE_RESULT);
   echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=NewTrainee&TID=" . $TID . "'>NEW ENTRY</a></div>";
   echo "<table>";
   while(list($ID, $FName, $LName) = $result->fetch_row()){
           echo "<tr><td>";
           echo "<a href='teamAction.php?Action=AddMember&TID=" . $TID . "&PID=". $ID . "&TeamTitle=" . $TeamTitle . "'><img src='images/plusbutton.gif'></img></a></td>";
           echo "<td>" . $FName . " " . $LName . "</td></tr>";
   }
   echo "</table>";
   
    
}


function showPeepsToTrain($TID){
    /************************************************
     * displays a list to add to a training session
     * **********************************************
     */
    include 'database.php';
    echo "<center><h1>CR Personnel</h1>";

   if($connection->errno > 0){
       printf("Mysql error number generated: %d", $connection->errno);
       exit();
   }
   $query = "SELECT * FROM people order by FName";
   $result = $connection->query($query, MYSQLI_STORE_RESULT);
   echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=NewTrainee&TID=" . $TID . "'>NEW ENTRY</a></div>";
   echo "<table>";
   while(list($ID, $FName, $LName) = $result->fetch_row()){
           echo "<tr><td>";
           echo "<a href='ldrAction.php?Action=AddTrainee&TID=" . $TID . "&PID=". $ID . "'><img src='images/plusbutton.gif'></img></a></td>";
           echo "<td>" . $FName . " " . $LName . "</td></tr>";
   }
   echo "</table>";
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
