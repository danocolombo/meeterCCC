<?php
require_once ('authenticate.php'); /* used for security purposes */
require 'meeter.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
/*
 * error.php
 * /******************************************************************
 * used to display specific information to user during operation
 * ****************************************************************
 */
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport"
	content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
<title>Meeter Web Application</title>
<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
<link rel="stylesheet" type="text/css"
	href="css/screen_layout_large.css" />
<link rel="stylesheet" type="text/css"
	media="only screen and (min-width:50px) and (max-width:500px)"
	href="css/screen_layout_small.css">
<link rel="stylesheet" type="text/css"
	media="only screen and (min-width:501px) and (max-width:800px)"
	href="css/screen_layout_medium.css">
<!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
</head>
<body>
	<div class="page">
		<header>
			<a class="logo" title="home" href="index.php"><span></span></a>
		</header>
		<?php
            insertNav();
            //===========================================
            // article for the error message.
            echo "<article>";
            $ErrorCode = $_GET['ErrorCode'];
            switch ($ErrorCode){
                case 3001:
                    //--------------------------------------------------------
                    //attempt to save a meeting that already exists
                    //--------------------------------------------------------
                    echo "<br><br>";
                    echo "<h3>That meeting already exists.</h3>";
                    $mid = $_GET['ID'];
                    echo "<a href=\"mtgForm.php?Action=Edit&ID=" . $mid . "\">Click here to view the existing entry</a><br/>";
                    break;
                case 3002:
                    //--------------------------------------------------------
                    // could not get meeting ID after saving the initial values (date/type/title)
                    //--------------------------------------------------------
                    echo "<br><br>";
                    echo "<h3>System error processing mtgAction</h3>";
                    echo "Could not get ID after saving initial values.";
                    break;
                default:
                    echo "<h3>ERROR</h3>";
                    echo "ErrorCode:$ErrorCode<br/>";
                    echo $_GET['ErrorMsg'];
                    echo "<br/><br/>";
                    break;
            }
            echo "</article>";
            // done with the error display
            //===========================================
            insertFooter();
		?>
	</div> <!--  closing the "page" div -->
</body>
</html>