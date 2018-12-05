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
				<?php
        			//  every config value that has a label definition must have a value if the associated checkbox is true.
        			// these are the pairs to validate
        			//	cbSetup => tbSetup 
				 
				    // this php section gets the display values and verifies if there is a display label for each checked configuration
				    // 
				    // check each Display value on each stored configuration. If the value is != NOSHOW, then make sure that the 
				    // associated Display value is not blank
				    //====================================================================
    				$aosConfig->loadConfigFromDB();
    				// loop through each AOS value. if it is displayed for people, and check box is CHECKED, then we nned DisplayValue.
				    foreach($aosConfig->AOS as $key => $value){
				        //echo "alert(\"$key\");";
        				echo "if(document.forms[\"adminMtrForm\"][\"cb_$key\"].checked == true){";
        				    if ($aosConfig->canVolunteer($key)){
            				    echo "var val = document.forms[\"adminMtrForm\"][\"tb_$key\"].value;";
            				    echo "if (val.length < 2){";
            				        echo "var msg = \"You need a longer title for the \'$key\' display label.\";";
            				        echo "alert(msg);";
            				        echo "document.getElementById(\"tb_$key\").focus();";
            				        echo "return false;";
            				    echo "}";
            				    echo "if(val == \"NOSHOW\"){";
//             				        echo "alert(\"it is NOSHOW\");";
            				        echo "var msg = \"Your display value for '$key' is unacceptable. Term NOSHOW is a reserved.\";";
            				        echo "alert(msg);";
            				        echo "return false;";
        				        echo "}";
    				        }
    				    //echo "alert(\"it is enabled.\");";
    				    echo "}else{";
    				        //echo "alert(\"it is not enabled\");";
        			     echo "}";
//         			     echo "alert(\"Loop:$key\");";
				    }
// 				    echo "alert(\"done\");";
                ?>
				$( "#dialog-confirm" ).dialog({
					  closeText: "x",
				      resizable: false,
				      height: "auto",
				      width: 400,
				      modal: true,
				      buttons: {
				        "Submit": function() {
				        	document.getElementById("adminMtrForm").submit();
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
				<form id="adminMtrForm" action="adminMeeterAction.php?Action=UpdateAOS" method="post">
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
                    echo "<table>";
                    echo "<tr><td>Configuration</td><td>Display Text</td></tr>";
                    if($aosConfig->getConfig("setup") === "true"){
                        echo "<tr><td><input type=\"checkbox\" name=\"cb_setup\" value=\"Setup\" id=\"cb_setup\" CHECKED>&nbsp;Setup</td>";
                        echo "<td><input type=\"text\" name=\"tb_setup\" value=\"" . $aosConfig->getDisplayString("setup") . "\"></td></tr>";
                    }else{
                        echo "<tr><td><input type=\"checkbox\" name=\"cb_setup\" value=\"Setup\" id=\"cb_setup\">&nbsp;Setup</td>";
                        echo "<td><input type=\"text\" name=\"tb_setup\" value=\"" . $aosConfig->getDisplayString("setup") . "\"></td></tr>";
                    }
                    if($aosConfig->getConfig("worship") === "true"){
                        echo "<tr><td><input type=\"checkbox\" name=\"cb_worship\" value=\"Worship\" id=\"cb_worship\" CHECKED>&nbsp;Worship</td>";
                        echo "<td><input type=\"text\" name=\"tb_worship\" value=\"" . $aosConfig->getDisplayString("worship") . "\"></td></tr>";
                    }else{
                        echo "<tr><td><input type=\"checkbox\" name=\"cb_worship\" value=\"Worship\" id=\"cb_worship\">&nbsp;Worship</td>";
                        echo "<td><input type=\"text\" name=\"tb_worship\" value=\"" . $aosConfig->getDisplayString("worship") . "\"></td></tr>";
                    }
                    if($aosConfig->getConfig("av") === "true"){
                        echo "<tr><td><input type=\"checkbox\" name=\"cb_av\" value=\"av\" id=\"cb_av\" CHECKED>&nbsp;Audio/Visual</td>";
                        echo "<td><input type=\"text\" name=\"tb_av\" value=\"" . $aosConfig->getDisplayString("av") . "\"></td></tr>";
                    }else{
                        echo "<tr><td><input type=\"checkbox\" name=\"cb_av\" value=\"av\" id=\"cb_av\">&nbsp;Audio/Visual</td>";
                        echo "<td><input type=\"text\" name=\"tb_av\" value=\"" . $aosConfig->getDisplayString("av") . "\"></td></tr>";
            		}
            		if($aosConfig->getConfig("greeter") === "true"){
            		    echo "<tr><td><input type=\"checkbox\" name=\"cb_greeter\" value=\"Greeter\" id=\"cb_greeter\" CHECKED>&nbsp;Greeters</td>";
            		    echo "<td><input type=\"text\" name=\"tb_greeter\" value=\"" . $aosConfig->getDisplayString("greeter") . "\"></td></tr>";
            		}else{
            		    echo "<tr><td><input type=\"checkbox\" name=\"cb_greeter\" value=\"Greeter\" id=\"cb_greeter\">&nbsp;Greeters</td>";
            		    echo "<td><input type=\"text\" name=\"tb_greeter\" value=\"" . $aosConfig->getDisplayString("greeter") . "\"></td></tr>";
            		}
            		if($aosConfig->getConfig("resources") === "true"){
            		    echo "<tr><td><input type=\"checkbox\" name=\"cb_resources\" value=\"Resources\" id=\"cb_resources\" CHECKED>&nbsp;Resources</td>";
            		    echo "<td><input type=\"text\" name=\"tb_resources\" value=\"" . $aosConfig->getDisplayString("resources") . "\"></td></tr>";
            		}else{
            		    echo "<tr><td><input type=\"checkbox\" name=\"cb_resources\" value=\"Resources\" id=\"cb_resources\">&nbsp;Resources</td>";
            		    echo "<td><input type=\"text\" name=\"tb_resources\" value=\"" . $aosConfig->getDisplayString("resources") . "\"></td></tr>";
            		}
            		if($aosConfig->getConfig("meal") === "true"){
            		    echo "<tr><td><input type=\"checkbox\" name=\"cb_meal\" value=\"Meal\" id=\"cb_meal\" CHECKED>&nbsp;Meal attendance&nbsp;</td>";
            		    echo "<td></td></tr>";
            		}else{
            		    echo "<tr><td><input type=\"checkbox\" name=\"cb_meal\" value=\"Meal\" id=\"cb_meal\">&nbsp;Meal attendance</td>";
            		    echo "<td></td></tr>";
            		}
            		if($aosConfig->getConfig("mealFac") === "true"){
            		    echo "<tr><td><input type=\"checkbox\" name=\"cb_mealFac\" value=\"MealFac\" id=\"cb_mealFac\" CHECKED>&nbsp;Meal Coordiator</td>";
            		    echo "<td><input type=\"text\" name=\"tb_mealFac\" value=\"" . $aosConfig->getDisplayString("mealFac") . "\"></td></tr>";
            		}else{
            		    echo "<tr><td><input type=\"checkbox\" name=\"cb_mealFac\" value=\"MealFac\" id=\"cb_mealFac\">&nbsp;Meal Facilitator</td>";
            		    echo "<td><input type=\"text\" name=\"tb_mealFac\" value=\"" . $aosConfig->getDisplayString("mealFac") . "\"></td></tr>";
            		}
            		if($aosConfig->getConfig("menu") === "true"){
            		    echo "<tr><td><input type=\"checkbox\" name=\"cb_menu\" value=\"Menu\" id=\"cb_menu\" CHECKED>&nbsp;Meal Served</td>";
            		}else{
            		    echo "<tr><td><input type=\"checkbox\" name=\"cb_menu\" value=\"Menu\" id=\"cb_menu\">&nbsp;Meal Served</td>";
            		}
            		if($aosConfig->getConfig("transportation") === "true"){
            		    echo "<tr><td><input type=\"checkbox\" name=\"cb_transportation\" value=\"Transportation\" id=\"cb_transportation\" CHECKED>&nbsp;Transportation</td>";
            		    echo "<td><input type=\"text\" name=\"tb_transportation\" value=\"" . $aosConfig->getDisplayString("transportation") . "\"></td></tr>";
            		}else{
            		    echo "<tr><td><input type=\"checkbox\" name=\"cb_transportation\" value=\"Transportation\" id=\"`cb_transportation\">&nbsp;Transportation</td>";
            		    echo "<td><input type=\"text\" name=\"tb_transportation\" value=\"" . $aosConfig->getDisplayString("transportation") . "\"></td></tr>";
            		}
            		echo "</table>";
            		?>
                    </p>
                  </div>
                  <h3>Execution</h3>
                  <div>
                    <p>
                    These are the items related to the actual meeting:<br/>
                    <?php 
                        echo "<table>";
                        echo "<tr><td>Configuration</td><td>Display Text</td></tr>";
                        if($aosConfig->getConfig("reader") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_reader\" value=\"Readers\" id=\"cb_reader\" CHECKED>&nbsp;Readers</td>";
                            echo "<td><input type=\"text\" name=\"tb_reader\" value=\"" . $aosConfig->getDisplayString("reader") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_reader\" value=\"Readers\" id=\"cb_reader\" >&nbsp;Readers</td>";
                            echo "<td><input type=\"text\" name=\"tb_reader\" value=\"" . $aosConfig->getDisplayString("reader") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("announcements") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_announcements\" value=\"Announcements\" id=\"cb_announcements\" CHECKED>&nbsp;Announcements</td>";
                            echo "<td><input type=\"text\" name=\"tb_announcements\" value=\"" . $aosConfig->getDisplayString("announcements") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_announcements\" value=\"Announcements\" id=\"cb_announcements\">&nbsp;Announcements</td>";
                            echo "<td><input type=\"text\" name=\"tb_announcements\" value=\"" . $aosConfig->getDisplayString("announcements") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("teaching") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_teaching\" value=\"Teaching\" id=\"cb_teaching\" CHECKED>&nbsp;Teaching/Lessons</td>";
                            echo "<td><input type=\"text\" name=\"tb_teaching\" value=\"" . $aosConfig->getDisplayString("teaching") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_teaching\" value=\"Teaching\" id=\"cb_teaching\">&nbsp;Teaching/Lessons</td>";
                            echo "<td><input type=\"text\" name=\"tb_teachings\" value=\"" . $aosConfig->getDisplayString("teaching") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("chips") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_chips\" value=\"Chips\" id=\"cb_chips\" CHECKED>&nbsp;Chip Ceremony</td>";
                            echo "<td><input type=\"text\" name=\"tb_chips\" value=\"" . $aosConfig->getDisplayString("chips") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_chips\" value=\"Chips\" id=\"cb_chips\">&nbsp;Chip Ceremony</td>";
                            echo "<td><input type=\"text\" name=\"tb_chips\" value=\"" . $aosConfig->getDisplayString("chips") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("donations") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_donations\" value=\"Donations\" id=\"cb_donations\" CHECKED>&nbsp;Donations&nbsp;</td>";
                            echo "<td></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_donations\" value=\"Donations\" id=\"cb_donations\" >&nbsp;Donations&nbsp;</td>";
                            echo "<td></td></tr>";
                        }
                        if($aosConfig->getConfig("serenity") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_serenity\" value=\"Serenity\" id=\"cb_serenity\" CHECKED>&nbsp;Serenity Prayer</td>";
                            echo "<td><input type=\"text\" name=\"tb_serenity\" value=\"" . $aosConfig->getDisplayString("serenity") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_serenity\" value=\"Serenity\" id=\"cb_serenity\" >&nbsp;Serenity Prayer</td>";
                            echo "<td><input type=\"text\" name=\"tb_serenity\" value=\"" . $aosConfig->getDisplayString("serenity") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("smallGroup") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_smallGroup\" value=\"SmallGroup\" id=\"cb_smallGroup\" CHECKED>&nbsp;Small Group Facilitator</td>";
                            echo "<td><input type=\"text\" name=\"tb_smallGroup\" value=\"" . $aosConfig->getDisplayString("smallGroup") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_smallGroup\" value=\"SmallGroup\" id=\"cb_smallGroup\" >&nbsp;Small Group Facilitator</td>";
                            echo "<td><input type=\"text\" name=\"tb_smallGroup\" value=\"" . $aosConfig->getDisplayString("smallGroup") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("newcomers") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_newcomers\" value=\"Newcomers\" id=\"cb_newcomers\" CHECKED>&nbsp;Newcomers</td>";
                            echo "<td><input type=\"text\" name=\"tb_newcomers\" value=\"" . $aosConfig->getDisplayString("newcomers") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_newcomers\" value=\"Newcomers\" id=\"cb_newcomers\" >&nbsp;Newcomers</td>";
                            echo "<td><input type=\"text\" name=\"tb_newcomers\" value=\"" . $aosConfig->getDisplayString("newcomers") . "\"></td></tr>";
                        }
                        echo "</table>";
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
                        echo "<table>";
                        echo "<tr><td>Configuration</td><td>Display Text</td></tr>";
                    
                        if($aosConfig->getConfig("nursery") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_nursery\" value=\"Nursery\" id=\"cb_nursery\" CHECKED>&nbsp;Nursery Count&nbsp;</td>";
                            echo "<td></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_nursery\" value=\"Nursery\" id=\"cb_nursery\" >&nbsp;Nursery Count&nbsp;</td>";
                            echo "<td></td></tr>";
                        }
                        if($aosConfig->getConfig("nurseryFac") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_nurseryFac\" value=\"NurseryFac\" id=\"cb_nursery\" CHECKED>&nbsp;Nursery facilitator</td>";
                            echo "<td><input type=\"text\" name=\"tb_nurseryFac\" value=\"" . $aosConfig->getDisplayString("nurseryFac") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_nurseryFac\" value=\"NurseryFac\" id=\"cb_nursery\" >&nbsp;Nursery facilitator</td>";
                            echo "<td><input type=\"text\" name=\"tb_nurseryFac\" value=\"" . $aosConfig->getDisplayString("nurseryFac") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("children") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_children\" value=\"Children\" id=\"cb_children\" CHECKED>&nbsp;Children Count&nbsp;</td>";
                            echo "<td></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_children\" value=\"Children\" id=\"cb_children\" CHECKED>&nbsp;Children Count&nbsp;</td>";
                            echo "<td></td></tr>";
                        }
                        if($aosConfig->getConfig("childrenFac") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_childrenFac\" value=\"ChildrenFac\" id=\"cb_childrenFac\" CHECKED>&nbsp;Children Fac</td>";
                            echo "<td><input type=\"text\" name=\"tb_childrenFac\" value=\"" . $aosConfig->getDisplayString("childrenFac") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_childrenFac\" value=\"ChildrenFac\" id=\"cb_childrenFac\" >&nbsp;Children Fac</td>";
                            echo "<td><input type=\"text\" name=\"tb_childrenFac\" value=\"" . $aosConfig->getDisplayString("childrenFac") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("youth") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_youth\" value=\"Youth\" id=\"cb_youth\" CHECKED>&nbsp;Youth Count&nbsp;</td>";
                            echo "<td></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_youth\" value=\"Youth\" id=\"cb_youth\" >&nbsp;Youth Count&nbsp;</td>";
                            echo "<td></td></tr>";
                        }
                        if($aosConfig->getConfig("youthFac") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_youthFac\" value=\"YouthFac\" id=\"cb_youthFac\" CHECKED>&nbsp;Youth facilitator</td>";
                            echo "<td><input type=\"text\" name=\"tb_youthFac\" value=\"" . $aosConfig->getDisplayString("youthFac") . "\"></td></tr>";
                        }else{
                            
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_youthFac\" value=\"YouthFac\" id=\"cb_youthFac\" >&nbsp;Youth facilitator</td>";
                            echo "<td><input type=\"text\" name=\"tb_youthFac\" value=\"" . $aosConfig->getDisplayString("youthFac") . "\"></td></tr>";
                        }
                        echo "</table>";
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
                    echo "<table>";
                    echo "<tr><td>Configuration</td><td>Display Text</td></tr>";
                    if($aosConfig->getConfig("cafe") === "true"){
                        echo "<tr><td><input type=\"checkbox\" name=\"cb_cafe\" value=\"Cafe\" id=\"cb_cafe\" CHECKED>&nbsp;Cafe</td>";
                        echo "<td><input type=\"text\" name=\"tb_cafe\" value=\"" . $aosConfig->getDisplayString("cafe") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_cafe\" value=\"Cafe\" id=\"cb_cafe\" >&nbsp;Cafe</td>";
                            echo "<td><input type=\"text\" name=\"tb_cafe\" value=\"" . $aosConfig->getDisplayString("cafe") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("teardown") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_teardown\" value=\"TearDown\" id=\"cb_teardown\" CHECKED>&nbsp;Tear Down</td>";
                            echo "<td><input type=\"text\" name=\"tb_teardown\" value=\"" . $aosConfig->getDisplayString("teardown") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_teardown\" value=\"TearDown\" id=\"cb_teardown\">&nbsp;Tear Down</td>";
                            echo "<td><input type=\"text\" name=\"tb_teardown\" value=\"" . $aosConfig->getDisplayString("teardown") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("security") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_security\" value=\"Security\" id=\"cb_security\" CHECKED>&nbsp;Security</td>";
                            echo "<td><input type=\"text\" name=\"tb_security\" value=\"" . $aosConfig->getDisplayString("security") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_security\" value=\"Security\" id=\"cb_security\" >&nbsp;Security</td>";
                            echo "<td><input type=\"text\" name=\"tb_security\" value=\"" . $aosConfig->getDisplayString("security") . "\"></td></tr>";
                        }
                        echo "</table>";
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
                    echo "<table>";
                    echo "<tr><td>Configuration</td><td>Display Text</td></tr>";
                    if($aosConfig->getConfig("fellowship") === "true"){
                        echo "<tr><td><input type=\"checkbox\" name=\"cb_fellowship\" value=\"Fellowship\" id=\"cb_fellowship\" CHECKED>&nbsp;Fellowship</td>";
                        echo "<td><input type=\"text\" name=\"tb_fellowship\" value=\"" . $aosConfig->getDisplayString("fellowship") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_fellowship\" value=\"Fellowship\" id=\"cb_fellowship\" >&nbsp;Fellowship</td>";
                            echo "<td><input type=\"text\" name=\"tb_fellowship\" value=\"" . $aosConfig->getDisplayString("fellowship") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("prayer") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_prayer\" value=\"Prayer\" id=\"cb_prayer\" CHECKED>&nbsp;Prayer Team</td>";
                            echo "<td><input type=\"text\" name=\"tb_prayer\" value=\"" . $aosConfig->getDisplayString("prayer") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_prayer\" value=\"Prayer\" id=\"cb_prayer\" >&nbsp;Fellowship</td>";
                            echo "<td><input type=\"text\" name=\"tb_prayer\" value=\"" . $aosConfig->getDisplayString("prayer") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("specialEvents") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_specialEvents\" value=\"SpecialEvents\" id=\"cb_specialEvents\" CHECKED>&nbsp;Special Events</td>";
                            echo "<td><input type=\"text\" name=\"tb_specialEvents\" value=\"" . $aosConfig->getDisplayString("specialEvents") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_specialEvents\" value=\"SpecialEvents\" id=\"cb_specialEvents\" >&nbsp;Special Events</td>";
                            echo "<td><input type=\"text\" name=\"tb_specialEvents\" value=\"" . $aosConfig->getDisplayString("specialEvents") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("stepStudy") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_stepStudy\" value=\"StepStudy\" id=\"cb_stepStudy\" CHECKED>&nbsp;Step Study Team</td>";
                            echo "<td><input type=\"text\" name=\"tb_stepStudy\" value=\"" . $aosConfig->getDisplayString("stepStudy") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_stepStudy\" value=\"StepStudy\" id=\"cb_stepStudy\" >&nbsp;Step Study Team</td>";
                            echo "<td><input type=\"text\" name=\"tb_stepStudy\" value=\"" . $aosConfig->getDisplayString("stepStudy") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("crim") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_crim\" value=\"CRIMen\" id=\"cb_crim\" CHECKED>&nbsp;CRI Men</td>";
                            echo "<td><input type=\"text\" name=\"tb_crim\" value=\"" . $aosConfig->getDisplayString("crim") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_crim\" value=\"CRIMen\" id=\"cb_crim\" >&nbsp;CRI Men</td>";
                            echo "<td><input type=\"text\" name=\"tb_crim\" value=\"" . $aosConfig->getDisplayString("crim") . "\"></td></tr>";
                        }
                        if($aosConfig->getConfig("criw") === "true"){
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_criw\" value=\"CRIWomen\" id=\"cb_criw\" CHECKED>&nbsp;CRI Women</td>";
                            echo "<td><input type=\"text\" name=\"tb_criw\" value=\"" . $aosConfig->getDisplayString("criw") . "\"></td></tr>";
                        }else{
                            echo "<tr><td><input type=\"checkbox\" name=\"cb_criw\" value=\"CRIWomen\" id=\"cb_criw\" >&nbsp;CRI Women</td>";
                            echo "<td><input type=\"text\" name=\"tb_criw\" value=\"" . $aosConfig->getDisplayString("criw") . "\"></td></tr>";
                        }
                        echo "</table>";
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