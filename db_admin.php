<?php

include 'database.php';
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
OR die(mysql_error());


$sql = "DELIMETER // CREATE PROCEDURE getUser2Day(IN p_id INT) BEGIN SELECT * FROM users WHERE users.ID = p_id; END // DELIMITER ;";

$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
// Check connection
if (mysqli_connect_errno($con))
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_query($con,$sql);

mysqli_close($con);

?>