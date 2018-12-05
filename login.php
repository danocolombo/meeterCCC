<?php
//require_once("classPage.php");
/*=========================================================
 * login.php
 * This file is leveraged from the following example:
 * 
 * http://www.developerdrive.com/2013/05/creating-a-simple-to-do-application-–-part-3/
 * 
 * had to change the destination to be index.php
 * 
 */
$username = null;
$password = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	require_once('database.php');
	if(!empty($_POST["username"]) && !empty($_POST["password"])) {
		$username = $_POST["username"];
		$password = $_POST["password"];
	
		$query = $connection->prepare("SELECT `user_id` FROM `users` WHERE `user_login` = ? and `user_password` = PASSWORD(?)");
		$query->bind_param("ss", $username, $password);
		$query->execute();
		$query->bind_result($userid);
		$query->fetch();
		$query->close();
		
		if(!empty($userid)) {
			session_start();
			$session_key = session_id();
			
			$query = $connection->prepare("INSERT INTO `sessions` ( `user_id`, `session_key`, `session_address`, `session_useragent`, `session_expires`) VALUES ( ?, ?, ?, ?, DATE_ADD(NOW(),INTERVAL 1 HOUR) );");
			$query->bind_param("isss", $userid, $session_key, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'] );
			$query->execute();
			$query->close();
			
                        $_SESSION["username"] = $username;
                        $_SESSION["password"] = $password;
			header('Location: index.php');
		}
		else {
                        
			header('Location: login.php');
		}
		
	} else {
		header('Location: login.php');
	}
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Meeter Web Application</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div id="page">
	<!-- [content] -->
	<section id="content">
		<form id="login" method="post">
                    <center>
                    <fieldset style="width: 400px;">
                        <legend>&nbsp;Meeter Web Application&nbsp;</legend>
                    <p><label for="username">Username:</label><input id="username" name="username" type="text" required></p>
                    <p><label for="password">Password:</label><input id="password" name="password" type="password" required></p>					
                       <p><input type="submit" value="Login"></p>

                    </fieldset>
                    </center>
                    
                    
                    <!--
			<label for="username">Username:</label>
			<input id="username" name="username" type="text" required>
			<label for="password">Password:</label>
			<input id="password" name="password" type="password" required>					
			<br />
			<input type="submit" value="Login">
                    -->
		</form>
	</section>
	<!-- [/content] -->
	<!--
	<footer id="footer">
		<details>
			<summary>Copyright 2013</summary>
                        <p><a href="http://www.developerdrive.com/2013/05/creating-a-simple-to-do-application-%E2%80%93-part-3/" target="_new">created from this tutorial</a></p>
			<p>Jonathan Schnittger. All Rights Reserved.</p>
		</details>
	</footer>
        -->
        //<?php
//            return file_get_contents("pageBottom.txt");
//        ?>
</div>
    
<!-- </body>
</html>-->
<?php } ?>

