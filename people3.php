<?php
require_once('authenticate.php'); /* used for security purposes */
include 'database.php';
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
 * ======================================================
 * Meeter - people.php   3.0
 * ======================================================
 */

/******************************************************************
 * meeter header
 ***************************************************************** */
?>

<?php 
    /**********************************
     * finish generic header above
     **********************************/
/*####################################################
 * START MAIN PROCESSING
 * ###################################################
 */

/*******************************
 * load person name section
 ******************************/
loadHeader();
displayName();
displayContactInformation();
displayCharacterInformation();
displayInterests();
displayTraining;
displayFooter();
?>
<?php 
function loadHeader(){
    //this loads all the top lines in the html down to body
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

 <?php 
}   //this ends the loadHeader section of php code
 ?>   











?>
