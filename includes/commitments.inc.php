<?php
// include 'user.inc.php';
class Commitments extends User{
    public $peepCommits = array(User);
    function Commitments(){
        
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
//         $peepCommits = array_merge($people);
        $u = array(User);
        foreach($people as $peep){
            echo "<br/>$peep->uid | $peep->fName $peep->lName";
            $u = User($peep->uid,$peep->fName, $peep->lName, $peep->commits);
            $this->peepCommits = array_push($u);
        }
    }
//     function getCommits($config){
//         returnValue[] = array();

//     }
    function printCommits(){
        echo "<br/>we made it inside function<br/>#########<br/>";
//         $people = array();
//         $people = array_merge($this->peepCommits);
var_dump($this->peepCommits);
        foreach($this->peepCommits as $peep){
            echo "<br/>$peep->uid | $peep->fName $peep->lName";
        }
    }

}