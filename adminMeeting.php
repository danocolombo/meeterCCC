<?php 
require_once('authenticate.php'); /* this is used for security purposes */
require 'meeter.php';
require 'mtrAOS.php';
// need to get the configuration settings from the database
$mtrConfig->getLatestConfig();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
		<title>Meeter Web Application</title>
		<link rel="stylesheet" type="text/css" href="css/jqbase/jquery-ui.theme.css" />
		<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
		<link rel="stylesheet" type="text/css" href="css/screen_layout_large.css" />
		<link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:500px)"   href="css/screen_layout_small.css" />
		<link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width:800px)"  href="css/screen_layout_medium.css" />
		
		<script src="js/jquery/jquery-3.3.1.js" type="text/javascript"></script>
		<script src="js/jqbase/jquery-ui.js" type="text/javascript"></script>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<script>
          	$( function() {
            	$( "#accordion" ).accordion();
          	} );
      	</script>
		<script type="text/javascript">
			function validateForm(){
				
				$( "#dialog-confirm" ).dialog({
					  closeText: "x",
				      resizable: false,
				      height: "auto",
				      width: 400,
				      modal: true,
				      buttons: {
				        "Submit": function() {
				        	var dest = "adminMeeterAction.php?Action=UpdateAOS";
							window.location.href=dest;
// 				          $( this ).dialog( "close" );
				        },
				        "Cancel": function() {
					          $( this ).dialog( "close" );
				        },
				        "Exit without Saving": function() {
				          $( this ).dialog( "close" );
				          cancelForm();
				        }
				      }
			    });

			}
			function cancelForm(){
				var dest = "index.php";
				window.location.href=dest;
			}
      	</script>
      	
      	
	</head>
	<body>
		<div class="page">
			<header>
				<div id="hero"></div>
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
				<form id="adminMtgForm" action="#" method="post">
				<H2>Meeter Meeting Configuration</H2>
				<div>You can configure what features you want to manage simply by
				clicking the checkbox and saving.</div>
				<div id="accordion">
                  <h3>Preparation</h3>
                  <div>
                    <p>
                    In this section you can configure the basics for planning and getting ready.
                    </p>
                    <p>
                    <?php 
                    //===========================
                    // get fresh data to begin
                    //===========================
                    $aosConfig->loadConfigFromDB();
                    if($aosConfig->getConfig("setup") === "true"){
                        echo "<input type=\"checkbox\" name=\"cbSetup\" value=\"Setup\" id=\"cbSetup\" CHECKED>&nbsp;Setup<br>";
                    }else{
                        echo "<input type=\"checkbox\" name=\"cbSetup\" value=\"Setup\" id=\"cbSetup\">&nbsp;Setup<br>";
                    }
                    if($aosConfig->getConfig("worship") === "true"){
                        echo "<input type=\"checkbox\" name=\"cbWorship\" value=\"Worship\" id=\"cbWorship\" CHECKED>&nbsp;Worship/Music/Band<br>";
                    }else{
                        echo "<input type=\"checkbox\" name=\"cbWorship\" value=\"Worship\" id=\"cbWorship\">&nbsp;Worship/Music/Band<br>";
                    }
                    if($aosConfig->getConfig("av") === "true"){
            		      echo "<input type=\"checkbox\" name=\"cbAV\" value=\"AV\" id=\"cbAV\" CHECKED>&nbsp;Audio/Visual<br>";
                    }else{
                        echo "<input type=\"checkbox\" name=\"cbAV\" value=\"AV\" id=\"cbAV\">&nbsp;Audio/Visual<br>";
            		}
            		if($aosConfig->getConfig("greeter") === "true"){
            		    echo "<input type=\"checkbox\" name=\"cbGreeters\" value=\"Greeters\" id=\"cbGreeters\" CHECKED >&nbsp;Greeters<br>";
            		}else{
            		    echo "<input type=\"checkbox\" name=\"cbGreeters\" value=\"Greeters\" id=\"cbGreeters\">&nbsp;Greeters<br>";
            		}
            		if($aosConfig->getConfig("resources") === "true"){
            		    echo "<input type=\"checkbox\" name=\"cbResources\" value=\"Resources\" id=\"cbResources\" CHECKED >&nbsp;Resource Coordinator<br>";
            		}else{
            		    echo "<input type=\"checkbox\" name=\"cbResources\" value=\"Resources\" id=\"cbResources\">&nbsp;Resource Coordinator<br>";
            		}
            		if($aosConfig->getConfig("meal") === "true"){
            		  echo "<input type=\"checkbox\" name=\"cbMeal\" value=\"Meal\" id=\"cbMeal\" CHECKED>&nbsp;Meal attendance<br>";
            		}else{
            		    echo "<input type=\"checkbox\" name=\"cbMeal\" value=\"Meal\" id=\"cbMeal\" >&nbsp;Meal attendance<br>";
            		}
            		if($aosConfig->getConfig("mealFac") === "true"){
            		    echo "<input type=\"checkbox\" name=\"cbMealFac\" value=\"MealFac\" id=\"cbMealFac\" CHECKED>&nbsp;Meal Coordinator<br>";
            		}else{
            		    echo "<input type=\"checkbox\" name=\"cbMealFac\" value=\"MealFac\" id=\"cbMealFac\" >&nbsp;Meal Coordinator<br>";
            		}
            		if($aosConfig->getConfig("transportation") === "true"){
            		    echo "<input type=\"checkbox\" name=\"cbTransportation\" value=\"Transportation\" id=\"cbTransportation\" CHECKED>&nbsp;Transportation<br>";
            		}else{
            		    echo "<input type=\"checkbox\" name=\"cbTransportation\" value=\"Transportation\" id=\"cbTransportation\" >&nbsp;Transportation<br>";
            		}
            		?>
                    </p>
                  </div>
                  <h3>Execution</h3>
                  <div>
                    <p>
                    These are the items related to the actual meeting:<br/>
                    <?php 
                        if($aosConfig->getConfig("reader") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbReaders\" value=\"Readers\" id=\"cbReaders\" CHECKED>&nbsp;Principle/Step Readers<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbReaders\" value=\"Readers\" id=\"cbReaders\" >&nbsp;Principle/Step Readers<br>";
                        }
                        if($aosConfig->getConfig("announcements") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbAnnouncements\" value=\"Announcements\" id=\"cbAnnouncements\" CHECKED>&nbsp;Announcements<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbAnnouncements\" value=\"Announcements\" id=\"cbAnnouncements\" >&nbsp;Announcements<br>";
                        }
                        if($aosConfig->getConfig("chips") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbChips\" value=\"Chips\" id=\"cbChips\" CHECKED>&nbsp;Chip Ceremony<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbChips\" value=\"Chips\" id=\"cbChips\" >&nbsp;Chip Ceremony<br>";
                        }
                        if($aosConfig->getConfig("donations") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbDonations\" value=\"Donations\" id=\"cbDonations\" CHECKED>&nbsp;Donations<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbDonations\" value=\"Donations\" id=\"cbDonations\" >&nbsp;Donations<br>";
                        }
                        if($aosConfig->getConfig("serenity") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbSerenity\" value=\"Serenity\" id=\"cbSerenity\" CHECKED>&nbsp;Serenity Prayer<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbSerenity\" value=\"Serenity\" id=\"cbSerenity\" >&nbsp;Serenity Prayer<br>";
                        }
                        if($aosConfig->getConfig("newcomers") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbNewcomers\" value=\"Newcomers\" id=\"cbNewcomers\" CHECKED>&nbsp;Newcomers Facilitator<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbNewcomers\" value=\"Newcomers\" id=\"cbNewcomers\" >&nbsp;Newcomers Facilitator<br>";
                        }
                    ?>
                    </p>
                  </div>
                  <h3>Child Care &amp; Youth</h3>
                  <div>
                    <p>
                    This section relates to the plans for nursery, kids and youth
                    </p>
                    <p>
                    <?php 
                    if($aosConfig->getConfig("nursery") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbNursery\" value=\"Nursery\" id=\"cbNursery\" CHECKED>&nbsp;Nursery Numbers<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbNursery\" value=\"Nursery\" id=\"cbNursery\" >&nbsp;Nursery Numbers<br>";
                        }
                        if($aosConfig->getConfig("nurseryFac") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbNurseryPeeps\" value=\"NurseryPeeps\" id=\"cbNurseryPeeps\" CHECKED>&nbsp;Nursery Contacts<hr/>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbNurseryPeeps\" value=\"NurseryPeeps\" id=\"cbNurseryPeeps\" >&nbsp;Nursery Contacts<hr/>";
                        }
                        if($aosConfig->getConfig("children") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbChildren\" value=\"Children\" id=\"cbChildren\" CHECKED>&nbsp;Children Numbers<br/>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbChildren\" value=\"Children\" id=\"cbChildren\" >&nbsp;Children Numbers<br/";
                        }
                        if($aosConfig->getConfig("childrenFac") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbChildrenPeeps\" value=\"ChildrenPeeps\" id=\"cbChildrenPeeps\" CHECKED>&nbsp;Children Contacts<hr/>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbChildrenPeeps\" value=\"ChildrenPeeps\" id=\"cbChildrenPeeps\" >&nbsp;Children Contacts<hr/>";
                        }
                        if($aosConfig->getConfig("youth") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbYouth\" value=\"Youth\" id=\"cbYouth\" CHECKED>&nbsp;Youth Numbers<br/>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbYouth\" value=\"Youth\" id=\"cbYouth\" >&nbsp;Youth Numbers<br/";
                        }
                        if($aosConfig->getConfig("youthFac") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbYouthPeeps\" value=\"YouthPeeps\" id=\"cbYouthPeeps\" CHECKED>&nbsp;Youth Contacts<hr/>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbYouthPeeps\" value=\"YouthPeeps\" id=\"cbYouthPeeps\" >&nbsp;Youth Contacts<hr/>";
                        }
                    ?>
                    </p>
                  </div>
                  <h3>Wrap-up</h3>
                  <div>
                    <p>
                    This is all the items to conclude your General Meeting Night
                    </p>
                    <p>
                    <?php 
                    if($aosConfig->getConfig("cafe") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbCafe\" value=\"Cafe\" id=\"cbCafe\" CHECKED>&nbsp;Cafe<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbCafe\" value=\"Cafe\" id=\"cbCafe\" >&nbsp;Cafe<br>";
                        }
                        if($aosConfig->getConfig("teardown") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbTearDown\" value=\"TearDown\" id=\"cbTearDown\" CHECKED>&nbsp;Tear Down/Clean-up<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbTearDown\" value=\"TearDown\" id=\"cbTearDown\" >&nbsp;Tear Down/Clean-up<br>";
                        }
                        if($aosConfig->getConfig("security") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbSecurity\" value=\"Security\" id=\"cbSecurity\" CHECKED>&nbsp;Security<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbSecurity\" value=\"Security\" id=\"cbSecurity\" >&nbsp;Security<br>";
                        }
                    ?>
                    </p>
                  </div>
                  <h3>Misc/Others</h3>
                  <div>
                    <p>
                    These are generic roles and things you can track related to your ministry, but not necessarily on GMN.
                    </p>
                    <p>
                    <?php 
                    if($aosConfig->getConfig("fellowship") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbFellowship\" value=\"Fellowship\" id=\"cbFellowship\" CHECKED>&nbsp;Fellowship<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbFellowship\" value=\"Fellowship\" id=\"cbFellowship\" >&nbsp;Fellowship<br>";
                        }
                        if($aosConfig->getConfig("prayer") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbPrayer\" value=\"Prayer\" id=\"cbPrayer\" CHECKED>&nbsp;Prayer Team<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbPrayer\" value=\"Prayer\" id=\"cbPrayer\" >&nbsp;Prayer Team<br>";
                        }
                        if($aosConfig->getConfig("specialEvents") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbSecurity\" value=\"Security\" id=\"cbSecurity\" CHECKED>&nbsp;Special Events Team<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbSecurity\" value=\"Security\" id=\"cbSecurity\" >&nbsp;Special Events Team<br>";
                        }
                        if($aosConfig->getConfig("stepStudy") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbStepStudy\" value=\"StepStudy\" id=\"cbStepStudy\" CHECKED>&nbsp;Step Study Teams<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbStepStudy\" value=\"StepStudy\" id=\"cbStepStudy\" >&nbsp;Step Study Teams<br>";
                        }
                        if($aosConfig->getConfig("crim") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbCRIMen\" value=\"CRIMen\" id=\"cbCRIMen\" CHECKED>&nbsp;CRI Men Team<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbCRIMen\" value=\"CRIMen\" id=\"cbCRIMen\" >&nbsp;CRI Men Team<br>";
                        }
                        if($aosConfig->getConfig("criw") === "true"){
                            echo "<input type=\"checkbox\" name=\"cbCRIWomen\" value=\"CRIMen\" id=\"cbCRIWomen\" CHECKED>&nbsp;CRI Women Team<br>";
                        }else{
                            echo "<input type=\"checkbox\" name=\"cbCRIWomen\" value=\"CRIMen\" id=\"cbCRIWomen\" >&nbsp;CRI Women Team<br>";
                        }
                    ?>
                    </p>
                    
                  </div>

                </div>
              	<p>
                	<input type="button" id="btnCancel" value="Cancel Button"/>&nbsp;&nbsp;
                	<input type="button" id="btnSubmit" value="Commit In"/>
				</p>
                <script type="text/javascript">
                    // POST FORM SCRIPT
                    
                    $( "#btnCancel" ). button({
                        label: "Cancel"
                    });
                    $( "#btnCancel").click(function(){
        				cancelForm();
        			});
                    
                    $( "#btnSubmit" ).button({
        				label: "Save Settings",
                    });
        			$( "#btnSubmit").click(function(){
        				validateForm();
        			});
        			
              </script>
				</form>
			</article>
			<footer>
				&copy; 2013-2018 Rogue Intelligence
			</footer>
		</div>
        <!-- The following div is the dialog that pops prior to submitting form. -->
        <div id="dialog-confirm" title="Configuration Confirmation">
          <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Your changes can impact what is managed for each meetting; what areas people can serve in and what teams are coordintated.<br/>Previous saved values will not be lost.</p>
        </div>
</body>
</html>