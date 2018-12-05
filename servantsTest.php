<?php
include 'includes/user.inc.php';
include 'includes/serviceArea.inc.php';
include 'peopleAOS.php';
//$res[] = new ServiceArea("greeter", 3, "Jimmy", "Cricket");
//$res[] = new ServiceArea("greeter", 9, "Mary", "Lamb");
//$res[] = new ServiceArea("reader", 3, "Missy", "Prissy");
//$res[] = new ServiceArea("serenity", 9, "John", "Day");

//$people[] = new User;
$peeps = new pConfig();

// get info from database
mysqli_report(MYSQLI_REPORT_STRICT);
        
define('DB_HOST', 'localhost');
define('DB_USER', 'dcolombo_muat');
define('DB_PASSWORD', 'MR0mans1212!');
define('DB_NAME', 'dcolombo_muat');
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT ID, FName, LName, AOS FROM people WHERE Active = 1";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $people[] = new User($row['ID'], $row['FName'], $row['LName'], $row['AOS']);

    }
} else {
    echo "0 results";
}
$connection->close();

foreach($people as $peep){
    echo "<br/>$peep->uid | $peep->fName $peep->lName";
}
// foreach($res as $r){
//     echo "<br>$r->aos | $r->uid | $r->fName |$r->lName";
// }