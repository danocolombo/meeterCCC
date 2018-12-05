<?php
require_once('authenticate.php'); /* for security purposes */
require 'meeter.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include 'database.php';
// ---------------------------------------------------
// mtgForm 2.0
// ---------------------------------------------------
//
// get data
//-----------------------------------------------------
$MID = $_GET["ID"];
if ($MID > 0){
    /*------------------------------------------------
     * this section will get the meeting ID from the
     * url and display it for the user
     ===============================================*/
    //if($mysqli->errno > 0){
    if (mysqli_connect_errno()){
        die("Database connection failed: " .
            mysqli_connect_error() .
            " (" . mysqli_connect_error() . ")");
    }
    $sql = "SELECT * FROM meetings WHERE ID = " . $MID;
    
    $mtg = array();
    
    $result = $mysqli->query($sql);
    
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        $mtg[] = array($row['ID'], $row['MtgDate'], $row['MtgType'],
            $row['MtgTitle'], $row['MtgPresenter'], $row['MtgAttendance'],
            $row['MtgNotes'],
            $row['NurseryCnt'], $row['ChildrenCnt'], $row['YouthCnt'],
            $row['DinnerCnt'], $row['Donations'],
            $row['MtgWorship'], $row['MtgMeal'],
            $row['Reader1'], $row['Reader2'], $row['NurseryContact'],
            $row['ChildrenContact'], $row['YouthContact']
        );
    }
    //ordered data
    /*
     * ordered data
     *   0   ID
     *   1   MtgDate
     *   2   MtgType
     *   3   MtgTitle
     *   4   MtgPresenter
     *   5   MtgAttendance
     *   6   MtgNotes
     *   7   NurseryCnt
     *   8   ChildrenCnt
     *   9   YouthCnt
     *   10  DinnerCnt
     *   11  Donations
     *   12  MtgWorship
     *   13  MtgMeal
     *   14  Reader1
     *   15  Reader2
     *   16  NurseryContact
     *   17  ChildrenContact
     *   18  YouthContact
     */
    //---------------------------------------------
    // save data
    $mtgID = $mtg[0][0];
    $mtgDate = $mtg[0][1];
    $mtgType = $mtg[0][2];
    $mtgTitle = $mtg[0][3];
    $mtgPresenter = $mtg[0][4];
    $mtgAttendance = $mtg[0][5];
    $mtgNotes = $mtg[0][6];
    $mtgNurseryCnt = $mtg[0][7];
    $mtgChildrenCnt = $mtg[0][8];
    $mtgYouthCnt = $mtg[0][9];
    $mtgDinnerCnt = $mtg[0][10];
    $mtgDonations = $mtg[0][11];
    $mtgWorship = $mtg[0][12];
    $mtgMeal = $mtg[0][13];
    $mtgReader1 = $mtg[0][14];
    $mtgReader2 = $mtg[0][15];
    $mtgNurseryContact = $mtg[0][16];
    $mtgChildrenContact = $mtg[0][17];
    $mtgYouthContact = $mtg[0][17];
    //==============================================   
    // need to get team listings for drop down
    //
    // Host
    $sql = "SELECT ID, FName, LName, TeachingTeam, WorshipTeam, NurseryTeam, CelebrationPlaceTeam, LandingTeam, ReaderTeam, Chips, SerenityTeam FROM `people` WHERE Active = 1 AND (TeachingTeam = 1 or NurseryTeam = 1 or CelebrationPlaceTeam = 1 or LandingTeam = 1 or ReaderTeam = 1 or Chips = 1 or SerenityTeam = 1) AND ID != 0 ORDER BY FName";
    
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        $peeps[] = array($row['ID'], $row['FName'], $row['LName'],
            $row['TeachingTeam'], $row['WorshipTeam'], $row['NurseryTeam'], $row['CelebrationPlaceTeam'], $row['LandingTeam'],
            $row['ReaderTeam'], $row['Chips'], $row['SerenityTeam']
        );
        /*      array order
         * 
         *  0   ID
         *  1   FName
         *  2   LName
         *  3   TeachingTeam
         *  4   WorshipTeam
         *  5   NurseryTeam
         *  6   CelebrationPlaceTeam
         *  7   LandingTeam
         *  8   ReaderTeam
         *  9   Chips
         *  10  SerenityTeam
         */
        
    }
    
   // all of our selectable areas...
    $hostPeeps = array();
    $hostPeeps[] = array("0", "Nobody");
    $worshipPeeps[] = array();
    $worshipPeeps[] = array("0", "Videos");
    $readerPeeps[] = array();
    $readerPeeps[] = array("0", "Nobody");
    $chipPeeps[] = array();
    $chipPeeps[] = array("0", "Nobody");
    $nurseryPeeps[] = array();
    $nurseryPeeps[] = array("0", "Nobody");
    $childrenPeeps[] = array();
    $childrenPeeps[] = array("0", "Nobody");
    $youthPeeps[] = array();
    $youthPeeps[] = array("0", "Nobody");
    $serenityPeeps[] = array();
    $serenityPeeps[] = array("0", "Nobody");
    
    // lets loop through loading appropriate arrays
    for($i = 0; $i < sizeof($peeps); $i++){
        //teachers-hosts
        //---------------
        
        if($peeps[$i][3] == 1){
            $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
            $hostPeeps[] = array($peeps[$i][0], $fullName);
        }
        //---------------
        // worship
        //---------------
        if($peeps[$i][4] == 1){
            $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
            $worshipPeeps[] = array($peeps[$i][0], $fullName);
        }
        //---------------
        // nursery
        //---------------
        if($peeps[$i][5] == 1){
            $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
            $nurseryPeeps[] = array($peeps[$i][0], $fullName);
        }
        //---------------
        // CP or children
        //---------------
        if($peeps[$i][6] == 1){
            $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
            $childrenPeeps[] = array($peeps[$i][0], $fullName);
        }
        //---------------
        // Landing - Teenagers
        //---------------
        if($peeps[$i][7] == 1){
            $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
            $youthPeeps[] = array($peeps[$i][0], $fullName);
        }
        //---------------
        // Readers
        //---------------
        if($peeps[$i][8] == 1){
            $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
            $readerPeeps[] = array($peeps[$i][0], $fullName);
        }
        //---------------
        // Chips
        //---------------
        if($peeps[$i][9] == 1){
            $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
            $chipPeeps[] = array($peeps[$i][0], $fullName);
        }
        //---------------
        // Serenity
        //---------------
        if($peeps[$i][10] == 1){
            $fullName = $peeps[$i][1] . " " . $peeps[$i][2];
            $serenityPeeps[] = array($peeps[$i][0], $fullName);
        }
    }
    
}


?>	``
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
			function validateMtgForm(){
				//alert("now we are checking the form content");
				var m_Date = $( "#mtgDate" ).datepicker('getDate');
				//alert(m_Date);
				var m_NewDate = $("#mtgDate").datepicker({ dateFormat: 'yyyy,mm,dd'}).val();
				m_NewDate = m_NewDate.split("/");
				var m_FormattedDate = m_NewDate[2] + "-" + m_NewDate[0] + "-" + m_NewDate[1];
				alert(m_FormattedDate);
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
			<form id="mtgForm" action="mtgAction.php?Action=New" method="post">
				<h2 id="formTitle">New Meeting Entry</h2>
					<table id="formTable">
						<tr>
							<td colspan="2">
							<div class="mtgLabels">Date:&nbsp;
							<input type = "text" id = "mtgDate"></div>
    						</td>
						</tr>
                      	<tr>
                      		<td colspan="2">
                          	<fieldset>
                              <legend>Meeting Type</legend>
                              <label for="radio-1">Lesson</label>
                              <?php 
                              if($mtgType == "Lesson"){
                                  echo "<input type=\"radio\" name=\"radio-1\" id=\"radio-1\" checked=\"checked\">";
                              }else{
                                  echo "<input type=\"radio\" name=\"radio-1\" id=\"radio-1\">";
                              }
                              ?>                             
                              <label for="radio-2">Testimony</label>
                              <?php 
                              if($mtgType == "Testimony"){
                                echo "<input type=\"radio\" name=\"radio-1\" id=\"radio-2\" checked=\"checked\">";
                              }else{
                                  echo "<input type=\"radio\" name=\"radio-1\" id=\"radio-2\">";
                              }
                              ?>
                              <label for="radio-3">Special</label>
                              <?php 
                                if($mtgType == "Special"){
                              	     echo "<input type=\"radio\" name=\"radio-1\" id=\"radio-3\" checked=\"checked\">";
                              	}else{
                              		echo "<input type=\"radio\" name=\"radio-1\" id=\"radio-3\">";
                          		}
                      		    ?>
                            </fieldset>
                			</td>
            			</tr>
            			<tr>
            				<td><div class="mtgLabels" style="float:right">Title:&nbsp;</div></td> 
                			<td><input id="mtgTitle" size="40" type="text" value="<?php echo $mtgTitle;?>"/></td>
            			</tr>
            			<tr>
							<td>
							<div class="mtgLabels" style="float:right">Host:</div></td>
							<td>
							<select id="mtgFacilitator" name="mtgFacilitator">
    							<?php 
    								for($i = 0; $i < sizeof($hostPeeps); $i++){
    								    echo "<option value=\"" . $hostPeeps[$i][0] . "\">" . $hostPeeps[$i][1] . "</option>";
    								}
    								
								?>
							</select>
    						</td>
						</tr>
						<?php 
						if($meeter->getWorship()){
						    //================================
						    //    WORSHIP IS TRUE = DISPLAY OPTION
						    ?>	
                    		<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Worship:</div></td>
    							<td>
    							<select id="mtgWorship" name="mtgWorship">
    								<?php 
        								for($i = 0; $i < sizeof($worshipPeeps); $i++){
        								    echo "<option value=\"" . $worshipPeeps[$i][0] . "\">" . $worshipPeeps[$i][1] . "</option>";
        								}								
    								?>
    							</select>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for Chips
						?>
						<?php 
						if($meeter->getReaders()){
						    //================================
						    //    READERS IS TRUE = DISPLAY OPTION
						    ?>	
    						<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Readers:</div></td>
    							<td>
    							<select id="mtgReader1" name="mtgReader1">
    								<?php 
        								for($i = 0; $i < sizeof($readerPeeps); $i++){
        								    echo "<option value=\"" . $readerPeeps[$i][0] . "\">" . $readerPeeps[$i][1] . "</option>";
        								}								
    								?>
    							</select>
    							&nbsp;
    							<select id="mtgReader2" name="mtgReader2">
    								<?php 
        								for($i = 0; $i < sizeof($readerPeeps); $i++){
        								    echo "<option value=\"" . $readerPeeps[$i][0] . "\">" . $readerPeeps[$i][1] . "</option>";
        								}								
    								?>
    							</select>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for Chips
						?>
						<?php 
						if($meeter->getChips()){
						    //================================
						    //    CHIPS IS TRUE = DISPLAY OPTION
						    ?>
						
    						<tr>
    							<td>
    							<div class="mtgLabels" style="float:right">Chips:</div></td>
    							<td>
    							<select id="mtgChip1" name="mtgChip1">
    								<?php 
        								for($i = 0; $i < sizeof($chipPeeps); $i++){
        								    echo "<option value=\"" . $chipPeeps[$i][0] . "\">" . $chipPeeps[$i][1] . "</option>";
        								}	
    								?>
    							</select>
    							&nbsp;
    							<select id="mtgChip2" name="mtgChip2">
    								<?php 
        								for($i = 0; $i < sizeof($chipPeeps); $i++){
        								    echo "<option value=\"" . $chipPeeps[$i][0] . "\">" . $chipPeeps[$i][1] . "</option>";
        								}								
    								?>
    							</select>
        						</td>
    						</tr>
						<?php
						}     // this ends the if statement for Chips
						?>
						<tr>
							<td>
							<div class="mtgLabels" style="float:right">Serenity:</div></td>
							<td>
							<select id="mtgSerenity" name="mtgSerenity">
								<?php 
    								for($i = 0; $i < sizeof($serenityPeeps); $i++){
    								    echo "<option value=\"" . $serenityPeeps[$i][0] . "\">" . $serenityPeeps[$i][1] . "</option>";
    								}								
								?>
							</select>
    						</td>
						</tr>	
						<tr>
							<td>
							<div class="mtgLabels" style="float:right">Attendance:</div></td>
							<td>
							<select id="mtgAttendance" name="mtgAttendance">
								<?php 
    								for($a = 0; $a<201; $a++){
    								    if($a == $mtgAttendance){
    								        echo "<option value=\"" . $a . "\" selected>" . $a . "</option>";
    								    }else{
    								        echo "<option value=\"" . $a . "\">" . $a . "</option>";
    								    }
    								}
								?>
							</select>
    						</td>
						</tr>
						<tr>
							<td>
							<div class="mtgLabels" style="float:right">Donations:</div></td>
							<td><input id="mtgDonations" size="6" type="text" placeholder="$ 0"/></td>
						</tr>
						<tr>
							<td>
							<div class="mtgLabels" style="float:right">Meal:</div></td>
							<td><input id="mtgMeal" size="30" type="text"/><select id="mtgMealCnt" name="mtgMealCnt">
								<option value="0" selected>0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
							</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table border="3">
									<tr><td>
            							<div class="mtgCare" style="float:right">Nursery:
            							<select id="mtgNurseryCnt" name="mtgNurseryCnt">
            								<?php 
            								for($i = 0; $i < 31; $i++)	{
            								    echo "<option value=\"" . $i . "\">" . $i . "</option>";
            								}
            								?>
            							</select></div></td>
            							<td>&nbsp;&nbsp;Facilitator:&nbsp;<select id="mtgNurseryFac" name="mtgNurseryFac">
            								<?php 
                								for($i = 0; $i < sizeof($nurseryPeeps); $i++){
                								    echo "<option value=\"" . $nurseryPeeps[$i][0] . "\">" . $nurseryPeeps[$i][1] . "</option>";
                								}								
            								?>
            							</select>
                						</td>
            						</tr>
            						<tr>
            							<td>
            							<div class="mtgCare" style="float:right">Children:
            							<select id="mtgChildrenCnt" name="mtgChildrenCnt" style="float:right">
            								<?php 
            								for($i = 0; $i < 31; $i++)	{
            								    echo "<option value=\"" . $i . "\">" . $i . "</option>";
            								}
            								?>
            							</select></div>
            							</td>
            							<td>&nbsp;&nbsp;Facilitator:&nbsp;<select id="mtgChildrensFac" name="mtgChilrensFac">
            								<?php 
                								for($i = 0; $i < sizeof($childrenPeeps); $i++){
                								    echo "<option value=\"" . $childrenPeeps[$i][0] . "\">" . $childrenPeeps[$i][1] . "</option>";
                								}								
            								?>
            							</select>
                						</td>
            						</tr>
            						<tr>
            							<td>
            							<div class="mtgCare" style="float:right">Youth:
            							<select id="mtgYouthCnt" name="mtgYouthCnt">
            								<?php 
            								for($i = 0; $i < 31; $i++)	{
            								    echo "<option value=\"" . $i . "\">" . $i . "</option>";
            								}
            								?>
            							</select></div>
            							</td>
            							<td>&nbsp;&nbsp;Facilitator:&nbsp;<select id="mtgYouthFac" name="mtgYouthFac">
            								<?php 
                								for($i = 0; $i < sizeof($youthPeeps); $i++){
                								    echo "<option value=\"" . $youthPeeps[$i][0] . "\">" . $youthPeeps[$i][1] . "</option>";
                								}								
            								?>
            							</select>
            							</td>
        							</tr>
    							</table>	
    						</td>
						</tr>
						<tr><td colspan="2">
							<fieldset>
                              	<legend>Notes and Comments</legend>
                            	<textarea id="mtgNotes" rows="5" cols="50"></textarea>
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
            
			// ATTENDANCE SPINNER
            var x = <?php echo $mtgAttendance; ?>;
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
			
			
			
            
         });
      </script>
	</body>
</html>
