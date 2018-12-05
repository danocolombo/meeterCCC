<?php
require_once('authenticate.php'); /* for security purposes */
require 'meeter.php';
require 'mtrAOS.php';
require 'includes/database.inc.php';
require 'includes/meeting.inc.php';
//require 'peopleAOS.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include 'database.php';
// ---------------------------------------------------
// mtgForm 2.0
// ---------------------------------------------------
/* --------------------------------------------------------
 *  load the system configuration and possible assignees
--------------------------------------------------------- */
// $peepConfig = new pConfig();
// $peepConfig->loadCommitTableWithAllPeople();
loadCommitTableWithAllPeople();
$_gid = getGhostID();
$_glabel = getGhostLabel();
// echo "\nID: " . $_gid . "\tlabel: " . $_glabel . "\n";
// $aosConfig->setGhostID($_gid);
// $aosConfig->setGhostLabel($_glabel);
// echo "ID:$aosConfig->getGhostID \tLabel: $aosConfig->getGhostLabel()\n";
//
// get data
//-----------------------------------------------------
$edit = FALSE;
$MID = $_GET["ID"];
if($MID > 0 ){
    $edit = TRUE;
//     $theMeeting->getMeeting($MID);

    if (mysqli_connect_errno()){
        die("Database connection failed: " .
            mysqli_connect_error() .
            " (" . mysqli_connect_error() . ")");
    }
    $sql =  "select * from meetings where ID = $MID";
    
    $mtg = array();
    
    $result = $mysqli->query($sql);
    
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        $mtg[] = array($row['ID'], $row['MtgDate'], $row['MtgType'],
            $row['MtgTitle'], $row['MtgFac'], $row['MtgAttendance'],
            $row['MtgWorship'], $row['Menu'], $row['MealCnt'], $row['NurseryCnt'],
            $row['ChildrenCnt'], $row['YouthCnt'], $row['MtgNotes'], $row['Donations'],
            $row['Newcomers1Fac'], $row['Newcomers2Fac'], $row['Reader1Fac'],
            $row['Reader2Fac'], $row['NurseryFac'], $row['ChildrenFac'],
            $row['YouthFac'], $row['MealFac'], $row['CafeFac'],
            $row['TransportationFac'], $row['SetupFac'], $row['TearDownFac'],
            $row['Greeter1Fac'], $row['Greeter2Fac'], $row['Chips1Fac'],
            $row['Chips2Fac'], $row['ResourcesFac'], $row['TeachingFac'],
            $row['SerenityFac'], $row['AudioVisualFac'],
            $row['AnnouncementsFac'], $row['SecurityFac']
        );
    }   
}
if ($edit){
    $mtgID = $MID;
    $mtgDate = $mtg[0][1];
    $mtgType = $mtg[0][2];
    $mtgTitle = $mtg[0][3];
    $mtgFac = $mtg[0][4];
    $mtgAttendance = $mtg[0][5];
    $mtgWorship = $mtg[0][6];
    $mtgMenu = $mtg[0][7];
    $mtgMealCnt = $mtg[0][8];
    $mtgNurseryCnt = $mtg[0][9];
    $mtgChildrenCnt = $mtg[0][10];
    $mtgYouthCnt = $mtg[0][11];
    $mtgNotes = $mtg[0][12];
    $mtgDonations = $mtg[0][13];
    $mtgNewcomers1Fac = $mtg[0][14];
    $mtgNewcomers2Fac = $mtg[0][15];
    $mtgReader1Fac = $mtg[0][16];
    $mtgReader2Fac = $mtg[0][17];
    $mtgNurseryFac = $mtg[0][18];
    $mtgChildrenFac = $mtg[0][19];
    $mtgYouthFac = $mtg[0][20];
    $mtgMealFac = $mtg[0][21];
    $mtgCafeFac = $mtg[0][22];
    $mtgTransportationFac = $mtg[0][23];
    $mtgSetupFac = $mtg[0][24];
    $mtgTearDownFac = $mtg[0][25];
    $mtgGreeter1Fac = $mtg[0][26];
    $mtgGreeter2Fac = $mtg[0][27];
    $mtgChips1Fac = $mtg[0][28];
    $mtgChips2Fac = $mtg[0][29];
    $mtgResourcesFac = $mtg[0][30];
    $mtgTeachingFac = $mtg[0][31];
    $mtgSerenityFac = $mtg[0][32];
    $mtgAudioVisualFac = $mtg[0][33];
    $mtgAnnouncementsFac = $mtg[0][34];
    $mtgSecurityFac = $mtg[0][35];
}
// load the system configuration settings into object to use.
$aosConfig->loadConfigFromDB();


//#############################################
//  END OF PRE-CONDITIONING
//#############################################

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport"
	content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
	<meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<title>Meeter Web Application</title>
<link rel="stylesheet" type="text/css" href="css/vader/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
<link rel="stylesheet" type="text/css" href="css/screen_layout_large.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:500px)" href="css/screen_layout_small.css" />
<link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width:800px)" href="css/screen_layout_medium.css" />

<script src="js/jquery/jquery-3.3.1.js" type="text/javascript"></script>
<script src="js/jquery/jquery-ui.js" type="text/javascript"></script>

<!-- Javascript -->
<script type="text/javascript">
//             $( "#mtgDonations" ).keypress(function() {
//             	var regex = new RegExp("^[a-zA-Z0-9]+$");
//                 var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
//                 if (!regex.test(key)) {
//                    event.preventDefault();
//                    return false;
//                 }
//         	});

			function validateMtgForm(){
				// start with validating the date value
				var tmpString = "";
				var m_Date = $( "#mtgDate" ).datepicker('getDate');
				var m_NewDate = $("#mtgDate").datepicker({ dateFormat: 'yyyy,mm,dd'}).val();
				if(isValidDate(m_NewDate) == false){
					alert("please select an accurate date");
					$("#mtgDate").datepicker("setDate", new Date());
					$("#mtgDate").datepicker( "show" );
					return false;
				}
				var m_type = $('input[name=rdoMtgType]:checked').attr('id');
				if(m_type == "undefined"){
					alert("Please select the type of meeting you are entering");
					return false;
				}
				switch(m_type){
				case "rdoLesson":
					m_type = "Lesson";
					break;
				case "rdoTestimony":
					m_type = "Testimony";
					break;
				case "rdoSpecial":
					m_type = "Special";
					break;
				default:
					alert("You have to select a Meeting Type.");
					return false;
					break;
				}
				<?php 
				    // we will check if this is a new entry or update
				if($MID > 0){
				    echo "var recordID = getUrlVars()[\"ID\"];";
				}
				
				
				?>

				if($("#mtgTitle").val().length<3){
					alert("You need to provide a title longer than 2 characters");
					$("#mtgTitle").focus();
					return false;
				}
				// need to ensure that the donations text box is a monetary amount
				var m_donations = $("#mtgDonations").val();
				if ($("#mtgDonations").val().length<1){
					$("#mtgDonations").val("0");
				}else{
					fDonations = +$("#mtgDonations").val();
					if(isNaN(fDonations)){
						tmpString = "You need to enter a numeric value for Donations";
						$("#mtgDonations").val("");
					}
				}
				var recordID = getUrlVars()["ID"];
				if(!recordID){
					var dest = "mtgAction.php?Action=New";
				}else{
					var dest = "mtgAction.php?Action=Update&ID=" + recordID;
				}
				$("#mtgForm").submit();
// 				window.location.href=dest;
			}
			function cancelMtgForm(){
				var dest = "meetings.php";
				window.location.href=dest;
			}

			function isValidDate(dateString){
				// First check for the pattern
			    if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString))
			        return false;

			    // Parse the date parts to integers
			    var parts = dateString.split("/");
			    var day = parseInt(parts[1], 10);
			    var month = parseInt(parts[0], 10);
			    var year = parseInt(parts[2], 10);

			    // Check the ranges of month and year
			    if(year < 1000 || year > 3000 || month == 0 || month > 12)
			        return false;

			    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

			    // Adjust for leap years
			    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
			        monthLength[1] = 29;

			    // Check the range of the day
			    return day > 0 && day <= monthLength[month - 1];
			}
			
			function importedValidation(){
				// if user is trying to delete system user "Removed User", then echo message that
				// action is not possible. 
				//--------------------------------------------------------------------------------
				var mDate = $("mtgDate").value;
				alert(mDate);
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
// 						window.location.href=newURL;
						$("#mtgForm").submit();
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
// 					window.location.href=dest;
// 					$("#mtgForm").submit();
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
<script type="text/javascript" src="js/farinspace/jquery.imgpreload.min.js"></script>
</head>
<body>
	<div class="page">
		<header>
			<div id="hero"></div>
			<a class="logo" title="home" href="index.php"><span></span></a>
		</header>
		<nav>
			<a href="meetings.php">Meetings</a> <a href="people.php">People</a> <a
				href="teams.php">Teams</a> <a href="leadership.php">Leadership</a> <a
				href="reportlist.php">Reporting</a> <a href="#">ADMIN</a> <a
				href="logout.php">[ LOGOUT ]</a>
		</nav>
		<article>
			<?php 
			if($edit){
    			echo "<form id=\"mtgForm\" action=\"mtgAction.php?Action=Update&MID=$mtgID\" method=\"post\">";
    				echo "<h2 id=\"formTitle\">Meeting Entry</h2>";
			}else{
				echo "<form id=\"mtgForm\" action=\"mtgAction.php?Action=New\" method=\"post\">";
					echo "<h2 id=\"formTitle\">New Meeting Entry</h2>";
			}?>
					<table id="formTable">
						<tr>
							<td colspan="2">
							<table><tr>
    							<td width="150px;" align="right"><div class="mtgLabels">Date:</div></td>
    							<td><input type = "text" id = "mtgDate" name="mtgDate"></td>
							</tr>
							</table>
    						</td>
						</tr>
                      	<tr>
                      		<td colspan="2">
                      			<table><tr>
                      				<td>
                                      	<fieldset>
                                          <legend>Meeting Type</legend>
                                          <label for="rdoLesson">Lesson</label>
                                          <?php 
                                            if($mtgType == "Lesson"){
                                                  echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoLesson\" value=\"Lesson\" checked=\"checked\">";
                                              }else{
                                                  echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoLesson\" value=\"Lesson\" >";
                                              }
                                          ?>                             
                                          <label for="rdoTestimony">Testimony</label>
                                          <?php 
                                          if($mtgType == "Testimony"){
                                                echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoTestimony\" value=\"Testimony\" checked=\"checked\">";
                                              }else{
                                                  echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoTestimony\" value=\"Testimony\" >";
                                              }
                                          ?>
                                          <label for="rdoSpecial">Special</label>
                                          <?php 
                                          if($mtgType == "Special"){
                                              	     echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoSpecial\" value=\"Special\" checked=\"checked\">";
                                              	}else{
                                              		echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoSpecial\" value=\"Special\" >";
                                          		}
                                  		    ?>
                                        </fieldset>
                            	</td></tr></table>
                			</td>
            			</tr>
            			<tr>
            				<td>
            					<?php  // BEGINNING TABLE 1
            					echo "<table>";
            					echo "<tr>";
            					echo "<td align=\"right\"><div class=\"mtgLabels\">Title:&nbsp;</div></td>";
            						echo "<td><input id=\"mtgTitle\" name=\"mtgTitle\" size=\"40\" style=\"font-size:14;\" type=\"text\" value=\"$mtgTitle\"/></td>";
            					echo "</tr>";
            					echo "<tr>";
            						echo "<td align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">Host:</div></td>";
            						echo "<td><select id=\"mtgCoordinator\" name=\"mtgCoordinator\">";
            						$option = getHostsForMeeting();
            						foreach($option as $id => $name){
            						    if($mtgFac == $id){
            						        echo "<option value=\"$id\" SELECTED>$name</option>";
            						    }else{
            						        echo "<option value=\"$id\">$name</option>";
            						    }
            						}
            						//add the ghost to the bottom
            						if($edit){
            						    if($mtgFac == $_gid){
            						        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            						    }else{
            						        echo "<option value=\"$_gid\">$_glabel</option>";
            						    }
            						}else{
            						    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            						}
            						echo "</select></td>";
        						echo "</tr>";
        						echo "<tr>";
        						echo "<td align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">Attendance:</div></td>";
        							echo "<td><select id=\"mtgAttendance\" name=\"mtgAttendance\">";
            								for($a = 0; $a<201; $a++){
            								    if($a == $mtgAttendance){
            								        echo "<option value=\"" . $a . "\" selected>" . $a . "</option>";
            								    }else{
            								        echo "<option value=\"" . $a . "\">" . $a . "</option>";
            								    }
            								}
        								echo "</select>";
    								echo "</td>";
    							echo "</tr>";
                                if($aosConfig->getConfig("donations") == "true"){
                                    echo "<tr>";
                                    echo "<td align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">Donations:</div></td>";
                                    if(sizeof($mtgDonations) > 0){
        							    echo "<td><input id=\"mtgDonations\" name=\"mtgDonations\" size=\"6\" type=\"text\" value=\"$mtgDonations\"/>";
        							}else{
        							    echo "<td><input id=\"mtgDonations\"  name=\"mtgDonations\" size=\"6\" type=\"text\" placeholder=\"0\"/>";
       
        							}
                                    echo "</td>";
                                }
        						echo "</tr>";
        						if($aosConfig->getConfig("worship") == "true"){
    						          //================================
    						          //    WORSHIP IS TRUE = DISPLAY OPTION
    						          //================================
        						      echo "<tr><td align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("worship") . ":</div></td>";
        						      echo "<td><select id=\"mtgWorship\" name=\"mtgWorship\">";
                                      $option = getPeepsForService("worship");
                                      foreach($option as $id => $name){
                                          if($mtgWorship == $id){
                                              echo "<option value=\"$id\" SELECTED>$name</option>";
                                          }else{
                                              echo "<option value=\"$id\">$name</option>";
                                          }
                                      }
                                      //add the ghost to the bottom
                                      if($edit){
                                          if($mtgWorship == $_gid){
                                              echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                                          }else{
                                              echo "<option value=\"$_gid\">$_glabel</option>";
                                          }
                                      }else{
                                          echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                                      }
                                      echo "</select>";
        						      echo "<a href=\"#\" title=\"People on Worship team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a></td></tr>";
		                        }
		                        if($aosConfig->getConfig("av") == "true"){
		                            //================================
		                            //    AV IS TRUE = DISPLAY OPTION
		                            //================================
		                            echo "<tr><td align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">". $aosConfig->getDisplayString("av") . ":</div></td>";
		                            echo "<td><select id=\"mtgAV\" name=\"mtgAV\">";
		                            $option = getPeepsForService("av");
		                            foreach($option as $id => $name){
		                                if($mtgAudioVisualFac == $id){
		                                    echo "<option value=\"$id\" SELECTED>$name</option>";
		                                }else{
		                                    echo "<option value=\"$id\">$name</option>";
		                                }
		                            }
		                            //add the ghost to the bottom
		                            if($edit){
		                                if($mtgAudioVisualFac == $_gid){
		                                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
		                                }else{
		                                    echo "<option value=\"$_gid\">$_glabel</option>";
		                                }
		                            }else{
		                                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
		                            }
		                            echo "</select>";
		                            echo "<a href=\"#\"  title=\"People on A/V team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
                                    echo "</td></tr>";
		                        }
		                        if($aosConfig->getConfig("setup") == "true"){
		                            //================================
		                            //    setup IS TRUE = DISPLAY OPTION
		                            //================================
		                            echo "<tr><td align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("setup") . ":</div></td>";
		                            echo "<td><select id=\"mtgSetup\" name=\"mtgSetup\">";
		                            $option = getPeepsForService("setup");
		                            foreach($option as $id => $name){
		                                if($mtgSetupFac == $id){
		                                    echo "<option value=\"$id\" SELECTED>$name</option>";
		                                }else{
		                                    echo "<option value=\"$id\">$name</option>";
		                                }
		                            }
		                            //add the ghost to the bottom
		                            if($edit){
		                                if($mtgSetupFac == $_gid){
		                                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
		                                }else{
		                                    echo "<option value=\"$_gid\">$_glabel</option>";
		                                }
		                            }else{
		                                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
		                            }
		                            echo "</select>";
		                            echo "<a href=\"#\" title=\"People on setup team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
		                            echo "</td></tr>";
		                        }
		                        if($aosConfig->getConfig("transportation") == "true"){
		                            //================================
		                            //    transportation IS TRUE = DISPLAY OPTION
		                            //================================
		                            echo "<tr><td align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("transportation") . ":</div></td>";
		                            echo "<td><select id=\"mtgTransportation\" name=\"mtgTransportation\">";
		                            $option = getPeepsForService("transportation");
		                            foreach($option as $id => $name){
		                                if($mtgTransportationFac == $id){
		                                    echo "<option value=\"$id\" SELECTED>$name</option>";
		                                }else{
		                                    echo "<option value=\"$id\">$name</option>";
		                                }
		                            }
		                            //add the ghost to the bottom
		                            if($edit){
		                                if($mtgTransportationFac == $_gid){
		                                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
		                                }else{
		                                    echo "<option value=\"$_gid\">$_glabel</option>";
		                                }
		                            }else{
		                                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
		                            }
		                            echo "</select>";
		                            echo "<a href=\"#\" title=\"People on transportation team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
		                            echo "</td></tr>";
		                        }
		                        if($aosConfig->getConfig("greeter") == "true"){
		                            //================================
		                            //    GREETER IS TRUE = DISPLAY OPTION
		                            //======================================
                                    echo "<tr><td>";
                                    echo "<div class=\"mtgGreeter1\" style=\"float:right\">" .  $aosConfig->getDisplayString("greeter") . ":</div></td>";
                                    echo "<td>";
                                        echo "<select id=\"mtgGreeter1\" name=\"mtgGreeter1\">";
                                        $option = getPeepsForService("greeter");
                                        foreach($option as $id => $name){
                                            if($mtgGreeter1Fac == $id){
                                                echo "<option value=\"$id\" SELECTED>$name</option>";
                                            }else{
                                                echo "<option value=\"$id\">$name</option>";
                                            }
                                        }
                                        //add the ghost to the bottom
                                        if($edit){
                                            if($mtgGreeter1Fac == $_gid){
                                                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                                            }else{
                                                echo "<option value=\"$_gid\">$_glabel</option>";
                                            }
                                        }else{
                                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                                        }
                                        echo "</select>";
                                        echo "<select id=\"mtgGreeter2\" name=\"mtgGreeter2\">";
                                        foreach($option as $id => $name){
                                            if($mtgGreeter2Fac == $id){
                                                echo "<option value=\"$id\" SELECTED>$name</option>";
                                            }else{
                                                echo "<option value=\"$id\">$name</option>";
                                            }
                                        }
                                        //add the ghost to the bottom
                                        if($edit){
                                            if($mtgGreeter2Fac == $_gid){
                                                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                                            }else{
                                                echo "<option value=\"$_gid\">$_glabel</option>";
                                            }
                                        }else{
                                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                                        }
                                        echo "</select>";
                                        echo "<a href=\"#\" title=\"People on Greeting team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
                                        echo "</td></tr>";
		                        }
		                        if($aosConfig->getConfig("resources") == "true"){
    		                            //================================
    		                            //    resources IS TRUE = DISPLAY OPTION
    		                            //================================
    		                            //echo "<tr><td width=\"150px\" align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("resources") . ":</div></td>";
		                            echo "<tr><td align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("resources") . ":</div></td>";
    		                            echo "<td><select id=\"mtgSetup\" name=\"mtgResources\">";
    		                            $option = getPeepsForService("resources");
    		                            foreach($option as $id => $name){
    		                                if($mtgResourcesFac == $id){
    		                                    echo "<option value=\"$id\" SELECTED>$name</option>";
    		                                }else{
    		                                    echo "<option value=\"$id\">$name</option>";
    		                                }
    		                            }
    		                            //add the ghost to the bottom
    		                            if($edit){
    		                                if($mtgResourcesFac == $_gid){
    		                                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
    		                                }else{
    		                                    echo "<option value=\"$_gid\">$_glabel</option>";
    		                                }
    		                            }else{
    		                                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
    		                            }
    		                            echo "</select>";
    		                            echo "<a href=\"#\" title=\"People on resource team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
    		                            echo "</td></tr>";
		                            
					            }     // this ends the if statement for RESOURCES
					            
// 		                        echo "</td></tr>";
            					echo "</table>";
            					// END OF TABLE 1
            					
            					// BEGINNING of TABLE 2  (DINNER)
            					if($aosConfig->getConfig("meal") == "true"){
            					    //the configuration is to manage/track the meal
            					    //echo "<table><tr><td width=\"100px;\">&nbsp;</td><td>";
            					    echo "<table><tr><td>";
            					    echo "<fieldset><legend>Meal</legend>";
            					    echo "<table>";
            					    if($aosConfig->getConfig("menu") == "true"){
                					    echo "<tr><td colspan=4 align=\"left\"><div class=\"mtgLabels\" style=\"float:left\">Menu:&nbsp;";
                					    echo "<input id=\"mtgMenu\" name=\"mtgMenu\" size=\"40\" style=\"font-size:14;\" type=\"text\" value=\"" . $mtgMenu . "\"/></div></td></tr>";
            					    }
            					    echo "<tr><td align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">Served:&nbsp;</div></td>";
            					    echo "<td><select id=\"mtgMealCnt\" name=\"mtgMealCnt\">";
            					    for($a = 0; $a<201; $a++){
            					        if($a == $mtgMealCnt){
            					            echo "<option value=\"" . $a . "\" SELECTED>" . $a . "</option>";
            					        }else{
            					            echo "<option value=\"" . $a . "\">" . $a . "</option>";
            					        }
            					    }
            					    echo "</select>";
            					    echo "</td>";
            					    if($aosConfig->getConfig("mealFac") == "true"){
            					        echo "<td>" . $aosConfig->getDisplayString("mealFac") . "&nbsp;<select id=\"mtgMealFac\" name=\"mtgMealFac\">";
            					        $option = getPeepsForService("mealFac");
            					        foreach($option as $id => $name){
            					            if($mtgMealFac == $id){
            					                echo "<option value=\"$id\" SELECTED>$name</option>";
            					            }else{
            					                echo "<option value=\"$id\">$name</option>";
            					            }
            					        }
            					        //add the ghost to the bottom
            					        if($edit){
            					            if($mtgMealFac == $_gid){
            					                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					            }else{
            					                echo "<option value=\"$_gid\">$_glabel</option>";
            					            }
            					        }else{
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }
            					        echo "</select>";
            					    }else{
            					        echo "<td>";
            					    }
            					    echo "</td></tr></table>";
            					    echo "</fieldset>";
            					    echo "</td></tr></table>";
            					    
            					}  // END OF TABLE 2 (DINNER)
            					
            				    // BEGINNING TABLE 3
            					echo "<table>";
            					echo "<tr>";
            					echo "<td>";
            					if($aosConfig->getConfig("reader") == "true"){
            					    //================================
            					    //    READERS IS TRUE = DISPLAY OPTION
            					    //======================================
            					    echo "<div class=\"mtgLabels\" style=\"float:right\">" .  $aosConfig->getDisplayString("reader") . ":</div></td>";
            					    echo "<td>";
            					    echo "<select id=\"mtgReader1\" name=\"mtgReader1\">";
            					    $option = getPeepsForService("reader");
            					    foreach($option as $id => $name){
            					        if($mtgReader1Fac == $id){
            					            echo "<option value=\"$id\" SELECTED>$name</option>";
            					        }else{
            					            echo "<option value=\"$id\">$name</option>";
            					        }
            					    }
            					    //add the ghost to the bottom
            					    if($edit){
            					        if($mtgReader1Fac == $_gid){
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }else{
            					            echo "<option value=\"$_gid\">$_glabel</option>";
            					        }
            					    }else{
            					        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					    }
            					    echo "</select>";
            					    echo "<select id=\"mtgReader2\" name=\"mtgReader2\">";
            					    foreach($option as $id => $name){
            					        if($mtgReader2Fac == $id){
            					            echo "<option value=\"$id\" SELECTED>$name</option>";
            					        }else{
            					            echo "<option value=\"$id\">$name</option>";
            					        }
            					    }
            					    //add the ghost to the bottom
            					    if($edit){
            					        if($mtgReader2Fac == $_gid){
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }else{
            					            echo "<option value=\"$_gid\">$_glabel</option>";
            					        }
            					    }else{
            					        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					    }
            					    echo "</select>";
            					    echo "<a href=\"#\" title=\"People on Reader team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
            					    echo "</td></tr>";
            					}
            					if($aosConfig->getConfig("announcements") == "true"){
            					    //================================
            					    //    ANNOUNCEMENTS IS TRUE = DISPLAY OPTION
            					    //======================================
            					    echo "<tr><td>";
            					    echo "<div class=\"mtgLabels\" style=\"float:right\">" .  $aosConfig->getDisplayString("announcements") . ":</div></td>";
            					    echo "<td>";
            					    echo "<select id=\"mtgAnnouncements\" name=\"mtgAnnouncements\">";
            					    $option = getPeepsForService("announcements");
            					    foreach($option as $id => $name){
            					        if($mtgAnnouncementsFac == $id){
            					           echo "<option value=\"$id\" SELECTED>$name</option>";
            					        }else{
            					            echo "<option value=\"$id\">$name</option>";
            					        }
            					    }
            					    //add the ghost to the bottom
            					    if($edit){
            					        if($mtgAnnouncementsFac == $_gid){
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }else{
            					            echo "<option value=\"$_gid\">$_glabel</option>";
            					        }
            					    }else{
            					        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					    }
            					    echo "</select>";
            					    echo "<a href=\"#\" title=\"People on Announcement team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
            					    echo "</td></tr>";
            					}
            					if($aosConfig->getConfig("teaching") == "true"){
            					    //================================
            					    //    TEACHING IS TRUE = DISPLAY OPTION
            					    //======================================
            					    echo "<tr><td>";
            					    echo "<div class=\"mtgLabels\" style=\"float:right\">" .  $aosConfig->getDisplayString("teaching") . ":</div></td>";
            					    echo "<td>";
            					    echo "<select id=\"mtgTeaching\" name=\"mtgTeaching\">";
            					    $option = getPeepsForService("teaching");
            					    foreach($option as $id => $name){
            					        if($mtgTeachingFac == $id){
            					           echo "<option value=\"$id\" SELECTED>$name</option>";
            					        }else{
            					            echo "<option value=\"$id\">$name</option>";
            					        }
            					    }
            					    //add the ghost to the bottom
            					    if($edit){
            					        if($mtgTeachingFac == $_gid){
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }else{
            					            echo "<option value=\"$_gid\">$_glabel</option>";
            					        }
            					    }else{
            					        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					    }
            					    echo "</select>";
            					    echo "<a href=\"#\" title=\"People on Teaching team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
            					    echo "</td></tr>";
            					}
            					
            					if($aosConfig->getConfig("chips") == "true"){
            					    //================================
            					    //    CHIPS IS TRUE = DISPLAY OPTION
            					    //======================================
            					    echo "<tr><td>";
            					    echo "<div class=\"mtgLabels\" style=\"float:right\">" .  $aosConfig->getDisplayString("chips") . ":</div></td>";
            					    echo "<td>";
            					    echo "<select id=\"mtgChips1\" name=\"mtgChips1\">";
            					    $option = getPeepsForService("chips");
            					    foreach($option as $id => $name){
            					        if($mtgChips1Fac == $id){
            					            echo "<option value=\"$id\" SELECTED>$name</option>";
            					        }else{
            					            echo "<option value=\"$id\">$name</option>";
            					        }
            					    }
            					    //add the ghost to the bottom
            					    if($edit){
            					        if($mtgChips1Fac == $_gid){
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }else{
            					            echo "<option value=\"$_gid\">$_glabel</option>";
            					        }
            					    }else{
            					        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					    }
            					    echo "</select>";
            					    echo "<select id=\"mtgChips2\" name=\"mtgChips2\">";
            					    foreach($option as $id => $name){
            					        if($mtgChips2Fac == $id){
            					            echo "<option value=\"$id\" SELECTED>$name</option>";
            					        }else{
            					            echo "<option value=\"$id\">$name</option>";
            					        }
            					    }
            					    //add the ghost to the bottom
            					    if($edit){
            					        if($mtgChips2Fac == $_gid){
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }else{
            					            echo "<option value=\"$_gid\">$_glabel</option>";
            					        }
            					    }else{
            					        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					    }
            					    echo "</select>";
            					    echo "<a href=\"#\" title=\"People on Chips team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
            					    echo "</td></tr>";
            					}
            					if($aosConfig->getConfig("newcomers") == "true"){
            					    //================================
            					    //    NEWCOMERS (101) IS TRUE = DISPLAY OPTION
            					    //======================================
            					    echo "<tr><td>";
            					    echo "<div class=\"mtgLabels\" style=\"float:right\">" .  $aosConfig->getDisplayString("newcomers") . ":</div></td>";
            					    echo "<td>";
            					    echo "<select id=\"mtgNewcomers1\" name=\"mtgNewcomers1\">";
            					    $option = getPeepsForService("newcomers");
            					    foreach($option as $id => $name){
            					        if($mtgNewcomers1Fac == $id){
            					            echo "<option value=\"$id\" SELECTED>$name</option>";
            					        }else{
            					            echo "<option value=\"$id\">$name</option>";
            					        }
            					    }
            					    //add the ghost to the bottom
            					    if($edit){
            					        if($mtgNewcomers1Fac == $_gid){
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }else{
            					            echo "<option value=\"$_gid\">$_glabel</option>";
            					        }
            					    }else{
            					        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					    }
            					    echo "</select>";
            					    echo "<select id=\"mtgNewcomers2\" name=\"mtgNewcomers2\">";
            					    foreach($option as $id => $name){
            					        if($mtgNewcomers2Fac == $id){
            					            echo "<option value=\"$id\" SELECTED>$name</option>";
            					        }else{
            					            echo "<option value=\"$id\">$name</option>";
        					            }
            					    }
            					    //add the ghost to the bottom
            					    if($edit){
            					        if($mtgNewcomers2Fac == $_gid){
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }else{
            					            echo "<option value=\"$_gid\">$_glabel</option>";
            					        }
            					    }else{
            					        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					    }
            					    echo "</select>";
            					    echo "<a href=\"#\" title=\"People on Newcomers (101) team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
            					    echo "</td></tr>";
            					}
            					if($aosConfig->getConfig("serenity") == "true"){
            					    //================================
            					    //    SERENITY IS TRUE = DISPLAY OPTION
            					    //======================================
            					    echo "<tr><td>";
            					    echo "<div class=\"mtgLabels\" style=\"float:right\">" .  $aosConfig->getDisplayString("serenity") . ":</div></td>";
            					    echo "<td>";
            					    echo "<select id=\"mtgSerenity\" name=\"mtgSerenity\">";
            					    $option = getPeepsForService("serenity");
            					    foreach($option as $id => $name){
            					        if($mtgSerenityFac == $id){
            					            echo "<option value=\"$id\" SELECTED>$name</option>";
            					        }else{
            					            echo "<option value=\"$id\">$name</option>";
            					        }
            					    }
            					    //add the ghost to the bottom
            					    if($edit){
            					        if($mtgSerenityFac == $_gid){
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }else{
            					            echo "<option value=\"$_gid\">$_glabel</option>";
            					        }
            					    }else{
            					        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					    }
            					    echo "</select>";
            					    echo "<a href=\"#\" title=\"People on Serenity Prayer team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
            					    echo "</td></tr>";
            					}
            					
            					echo "</table>";
            					
            					// BEGINNING of TABLE 4  (GENERATIONS)
            					if($aosConfig->getConfig("youth") == "true" || $aosConfig->getConfig("children") == "true" || $aosConfig->getConfig("nursery") == "true"){
            					    // if any of the generations is enabled, display the table
            					    
            					    echo "<table><tr><td>";
            					    echo "<fieldset><legend>Generations</legend>";
            					    echo "<table>";
            					    if($aosConfig->getConfig("nursery") == "true"){
            					        echo "<tr><td align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">Nursery:&nbsp;</div></td>";
            					        echo "<td><select id=\"mtgNursery\" name=\"mtgNursery\">";
            					        for($a = 0; $a<201; $a++){
            					            if($a == $mtgNurseryCnt){
            					                echo "<option value=\"" . $a . "\" SELECTED>" . $a . "</option>";
            					            }else{
            					                echo "<option value=\"" . $a . "\">" . $a . "</option>";
            					            }
            					        }
            					        echo "</select>";
            					        echo "</td>";
            					        if($aosConfig->getConfig("nurseryFac") == "true"){
            					            echo "<td align=\"right\">" . $aosConfig->getDisplayString("nurseryFac") . "</td><td><select id=\"mtgNurseryFac\" name=\"mtgNurseryFac\">";
            					            $option = getPeepsForService("nurseryFac");
            					            foreach($option as $id => $name){
            					                if($mtgNurseryFac == $id){
            					                    echo "<option value=\"$id\" SELECTED>$name</option>";
            					                }else{
            					                    echo "<option value=\"$id\">$name</option>";
            					                }
            					            }
            					            //add the ghost to the bottom
            					            if($edit){
            					                if($mtgNurseryFac == $_gid){
            					                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					                }else{
            					                    echo "<option value=\"$_gid\">$_glabel</option>";
            					                }
            					            }else{
            					                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					            }
            					            echo "</select></td>";
            					        }
            					        echo "</tr>";
            					    }
            					    if($aosConfig->getConfig("children") == "true"){
            					        echo "<tr><td align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">Children:&nbsp;</div></td>";
            					        echo "<td><select id=\"mtgChildren\" name=\"mtgChildren\">";
            					        for($a = 0; $a<201; $a++){
            					            if($a == $mtgChildrenCnt){
            					                echo "<option value=\"" . $a . "\" SELECTED>" . $a . "</option>";
            					            }else{
            					                echo "<option value=\"" . $a . "\">" . $a . "</option>";
            					            }
            					        }
            					        echo "</select>";
            					        echo "</td>";
            					        if($aosConfig->getConfig("childrenFac") == "true"){
            					            echo "<td align=\"right\">" . $aosConfig->getDisplayString("childrenFac") . "</td><td><select id=\"mtgChildrenFac\" name=\"mtgChildrenFac\">";
            					            $option = getPeepsForService("childrenFac");
            					            foreach($option as $id => $name){
            					                if($mtgChildrenFac == $id){
            					                    echo "<option value=\"$id\" SELECTED>$name</option>";
            					                }else{
            					                    echo "<option value=\"$id\">$name</option>";
            					                }
            					            }
            					            //add the ghost to the bottom
            					            if($edit){
            					                if($mtgChildrenFac == $_gid){
            					                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					                }else{
            					                    echo "<option value=\"$_gid\">$_glabel</option>";
            					                }
            					            }else{
            					                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					            }
            					            echo "</select></td>";
            					        }
            					        echo "</tr>";
            					    }
            					    if($aosConfig->getConfig("youth") == "true"){
            					        echo "<tr><td align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">Youth:&nbsp;</div></td>";
            					        echo "<td><select id=\"mtgYouth\" name=\"mtgYouth\">";
            					        for($a = 0; $a<201; $a++){
            					            if($a == $mtgYouthCnt){
            					                echo "<option value=\"" . $a . "\" SELECTED>" . $a . "</option>";
            					            }else{
            					                echo "<option value=\"" . $a . "\">" . $a . "</option>";
            					            }
            					        }
            					        echo "</select>";
            					        echo "</td>";
            					        if($aosConfig->getConfig("youthFac") == "true"){
            					            echo "<td align=\"right\">" . $aosConfig->getDisplayString("youthFac") . "</td><td><select id=\"mtgYouthFac\" name=\"mtgYouthFac\">";
            					            $option = getPeepsForService("youthFac");
            					            foreach($option as $id => $name){
            					                if($mtgYouthFac == $id){
            					                    echo "<option value=\"$id\" SELECTED>$name</option>";
            					                }else{
            					                    echo "<option value=\"$id\">$name</option>";
            					                }
            					            }
            					            //add the ghost to the bottom
            					            if($edit){
            					                if($mtgYouthFac == $_gid){
            					                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					                }else{
            					                    echo "<option value=\"$_gid\">$_glabel</option>";
            					                }
            					            }else{
            					                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					            }
            					            echo "</select></td>";
            					        }
            					        echo "</tr>";
            					    }
            					    echo "</table>";
            					    echo "</fieldset>";
            					    echo "</td><tr></table>";
            					    
            					}  // END OF TABLE 4 (GENERATIONS)
            					// BEGINNING TABLE 5
            					echo "<table>";
            					echo "<tr>";
            					echo "<td>";
            					if($aosConfig->getConfig("cafe") == "true"){
            					    //================================
            					    //    CAFE IS TRUE = DISPLAY OPTION
            					    //======================================
            					    echo "<tr><td>";
            					    echo "<div class=\"mtgLabels\" style=\"float:right\">" .  $aosConfig->getDisplayString("cafe") . ":</div></td>";
            					    echo "<td>";
            					    echo "<select id=\"mtgCafe\" name=\"mtgCafe\">";
            					    $option = getPeepsForService("cafe");
            					    foreach($option as $id => $name){
            					        if($mtgCafeFac == $id){
            					            echo "<option value=\"$id\" SELECTED>$name</option>";
            					        }else{
            					            echo "<option value=\"$id\">$name</option>";
            					        }
            					    }
            					    //add the ghost to the bottom
            					    if($edit){
            					        if($mtgCafeFac == $_gid){
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }else{
            					            echo "<option value=\"$_gid\">$_glabel</option>";
            					        }
            					    }else{
            					        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					    }
            					    echo "</select>";
            					    echo "<a href=\"#\" title=\"People on Cafe team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
            					    echo "</td></tr>";
            					}
            					if($aosConfig->getConfig("teardown") == "true"){
            					    //================================
            					    //    TEARDOWN IS TRUE = DISPLAY OPTION
            					    //======================================
            					    echo "<tr><td>";
            					    echo "<div class=\"mtgLabels\" style=\"float:right\">" .  $aosConfig->getDisplayString("teardown") . ":</div></td>";
            					    echo "<td>";
            					    echo "<select id=\"mtgTearDown\" name=\"mtgTearDown\">";
            					    $option = getPeepsForService("teardown");
            					    foreach($option as $id => $name){
            					        if($mtgTearDownFac == $id){
            					            echo "<option value=\"$id\" SELECTED>$name</option>";
            					        }else{
            					            echo "<option value=\"$id\">$name</option>";
            					        }
            					    }
            					    //add the ghost to the bottom
            					    if($edit){
            					        if($mtgTearDownFac == $_gid){
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }else{
            					            echo "<option value=\"$_gid\">$_glabel</option>";
            					        }
            					    }else{
            					        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					    }
            					    echo "</select>";
            					    echo "<a href=\"#\" title=\"People on Tear-Down team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
            					    echo "</td></tr>";
            					}
            					
            					if($aosConfig->getConfig("security") == "true"){
            					    //================================
            					    //    SECURITY IS TRUE = DISPLAY OPTION
            					    //======================================
            					    echo "<tr><td>";
            					    echo "<div class=\"mtgLabels\" style=\"float:right\">" .  $aosConfig->getDisplayString("security") . ":</div></td>";
            					    echo "<td>";
            					    echo "<select id=\"mtgSecurity\" name=\"mtgSecurity\">";
            					    $option = getPeepsForService("security");
            					    foreach($option as $id => $name){
            					        if($mtgSecurityFac == $id){
            					            echo "<option value=\"$id\">$name</option>";
            					        }else{
            					            echo "<option value=\"$id\">$name</option>";
            					        }
            					    }
            					    //add the ghost to the bottom
            					    if($edit){
            					        if($mtgSecurityFac == $_gid){
            					            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					        }else{
            					            echo "<option value=\"$_gid\">$_glabel</option>";
            					        }
            					    }else{
            					        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            					    }
            					    echo "</select>";
            					    echo "<a href=\"#\" title=\"People on Security team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\"/></a>";
            					    echo "</td></tr>";
            					}
            					echo "</table>";
            					?>
							</td>
            			</tr>
						<tr><td colspan="2">
							<fieldset>
                              	<legend>Notes and Comments</legend>
                              	<?php 
                              	if(sizeof($mtgNotes) > 0){
                              	    echo "<textarea id=\"mtgNotes\" name=\"mtgNotes\" rows=\"5\" cols=\"50\">" . $mtgNotes . "</textarea>";
                              	}else{
                              	    echo "<textarea id=\"mtgNotes\" name=\"mtgNotes\"  rows=\"5\" cols=\"50\"></textarea>";
                              	}
                              	?>
                        	</fieldset>
                            </td></tr>	
                            <tr><td colspan="2">
                            	<input type="button" id="btnCancel" value="Cancel Button"/>&nbsp;&nbsp;
                            	<input type="button" id="btnSubmit" value="Commit In"/>
           					</td>
       					</tr>
					</table>
			</form>
			</article>
			<footer>
				&copy; 2013-2018 Rogue Intelligence
			</footer>
		</div>
		<script type="text/javascript">
         $(function() {
            $("#mtgDate").datepicker({
                showAnim: "blind",
                numberOfMonths: 1,
                showWeek: false,
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                minDate: new Date(2013, 1 - 1, 1),
                maxDate: new Date(2020, 12 - 1, 31)
            });
            <?php 
                //date from db is in format: YYYY-MM-DD
                if (sizeof($mtgDate)>0){
                    $mYear = substr($mtgDate, 0, 4);
                    $mMonth = substr($mtgDate, 5, 2);
                    $mDay = substr($mtgDate, 8, 2);
                
                    echo "$(\"#mtgDate\").datepicker(\"setDate\", new Date(" . $mYear . ", " . $mMonth . " - 1, " . $mDay . "));";
                }else{
                    echo "$(\"#mtgDate\").datepicker(\"setDate\", new Date());";
                }
            ?>
            // MEETING TYPE
            $( "input[type='radio']" ).checkboxradio();
            $("#radios").buttonset();

            //$( "#mtgWorship" ).selectMenu();
            
			// ATTENDANCE SPINNER
            	//var x = <?php echo $mtgAttendance; ?>;
            //$( "#spnrAttendance" ).spinner("value", x );
			//$( "#spnrAttendance" ).spinner("value", 5 );
			
            // CANCEL BUTTON
            $( "#btnCancel" ). button({
                label: "Cancel"
            });
            //$("#btnCancel").button("option", "label", "Cancel");

            // SUBMIT BUTTON
            $( "#btnSubmit" ).button({
				label: "Submit",
            });
			$( "#btnSubmit").click(function(){
				validateMtgForm();
			});
			$( "#btnCancel").click(function(){
				cancelMtgForm();
			});
         });
      </script>
	</body>
</html>