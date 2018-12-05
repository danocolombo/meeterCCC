<?php
global $connection;
/*-----------------
 * database.php
 * ========================================
 * This is authentication method learned from
 * http://www.developerdrive.com/2013/05/creating-a-simple-to-do-application-–-part-3/
 * 
 */
if ( isset( $connection ) )
	return;
mysqli_report(MYSQLI_REPORT_STRICT);

define('DB_HOST', 'localhost');
define('DB_USER', 'dcolombo_muat');
define('DB_PASSWORD', 'MR0mans1212!');
define('DB_NAME', 'dcolombo_muat');
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


if (mysqli_connect_errno()) {		
	die(sprintf("[database.php] Connect failed: %s\n", mysqli_connect_error()));
}
?>