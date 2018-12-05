<?php
    //include 'meeting.inc.php';
    // this file is for use with the meeter meeting functionality.
    function loadCommitTableWithAllPeople(){
        /* ==================================================
         * this function gets all the active people from
         * the people table and parses the commit informaiton
         * and loads it in the Commits table.
         =================================================== */
        /* ---------------------------------------------------
         * the order of operations
         * 1. delete all informaiton in the Commits table
         * 2. get all the active people from people table where
         *    active is 1.
         * 3. Loop through each person
         * 4. parse AOS value
         * 5. save each value to Commits table
         *
         ------------------------------------------------------*/
        mysqli_report(MYSQLI_REPORT_STRICT);
        define('DB_HOST', 'localhost');
        define('DB_USER', 'dcolombo_muat');
        define('DB_PASSWORD', 'MR0mans1212!');
        define('DB_NAME', 'dcolombo_muat');
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        //  1. delete all information in the Commits table
        try{
            $stmt = $connection->prepare("DELETE FROM Commits");
            //             $stmt->bind_param("ss", $newConfig, $PID);
            $stmt->execute();
            $stmt->close();
        } catch (PDOException $e){
            echo "Error: [peopleAOS.php_loadCommitTableWithAllPeople() - delete Commits table contents]\n" . $e->getMessage();
        }
        //  2. get all the active people from people table
        try{
            $sql = "SELECT ID, FName, LName, AOS FROM people where Active = 1 && (length(AOS)>1)";
            $result = $connection->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // for each active user
                    $id = $row["ID"];
                    $fn = $row["FName"];
                    $ln = $row["LName"];
                    $aos = $row["AOS"];
                    if(sizeof($aos)>0){
                        // there are settings
                        $peepCommit = explode("|", $aos);
//                         echo "peepCommit size: " . sizeof($peepCommit) . "\n";
                        $cnt = 0;
                        foreach($peepCommit as $key => $value){
                            
                            $parts = explode(":", $value);
//                             echo $cnt++ . "\t" . $value . "\t" . $parts[0] . "\t" . strlen($parts[0]) . "\n";
                            if(strlen($parts[0])>0){
//                                 echo "saving\n";
                                $sadd = $connection->prepare("INSERT INTO Commits (ID, Category, FName, LName) VALUES (?, ?, ?, ?)");
                                $sadd->bind_param("isss", $id, $parts[0], $fn, $ln);
                                $sadd->execute();
                                //                                 $sadd->close();
                            }
                        }
                    }
                }
                $sadd->close();
            } else {
                echo "0 results";
            }
            $connection->close();
            
        } catch (PDOException $e){
            echo "Error: [peopleAOS.php_loadCommitTableWithAllPeople() - INSERT Commits table contents]\n" . $e->getMessage();
        }
    }
    function getGhostID(){
        $returnValue = 0;
        mysqli_report(MYSQLI_REPORT_STRICT);
        
        define('DB_HOST', 'localhost');
        define('DB_USER', 'dcolombo_muat');
        define('DB_PASSWORD', 'MR0mans1212!');
        define('DB_NAME', 'dcolombo_muat');
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $config = "GhostID";
        $query = $connection->prepare("SELECT Setting FROM Meeter WHERE Config = ?");
        $query->bind_param("s", $config);
        $query->execute();
        $query->bind_result($Setting);
        while($query->fetch()){
            $returnValue = $Setting;
        }
        $query->close();
        $connection->close();
        return $returnValue;
    }
    function getGhostLabel(){
        $returnValue = 0;
        mysqli_report(MYSQLI_REPORT_STRICT);
        
//         define('DB_HOST', 'localhost');
//         define('DB_USER', 'dcolombo_muat');
//         define('DB_PASSWORD', 'MR0mans1212!');
//         define('DB_NAME', 'dcolombo_muat');
//         $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        // Check connection
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $config = "GhostLabel";
        $query = $connection->prepare("SELECT Setting FROM Meeter WHERE Config = ?");
        $query->bind_param("s", $config);
        $query->execute();
        $query->bind_result($Setting);
        while($query->fetch()){
            $returnValue = $Setting;
        }
        $query->close();
        $connection->close();
        return $returnValue;
    }
//     function getGhostInfo(){
//         /* ===========================================================
//          * this function gets the Nobody, N/A value from the people 
//          * table and stores it in the mtrAOS objects...
//          *      ghostID
//          *      ghostLabel
//          ============================================================*/
//         mysqli_report(MYSQLI_REPORT_STRICT);
        
//         define('DB_HOST', 'localhost');
//         define('DB_USER', 'dcolombo_muat');
//         define('DB_PASSWORD', 'MR0mans1212!');
//         define('DB_NAME', 'dcolombo_muat');
//         $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
//         // Check connection
//         if ($connection->connect_error) {
//             die("Connection failed: " . $connection->connect_error);
//         }
//         $config = "GhostID";
//         $query = $connection->prepare("SELECT Setting FROM Meeter WHERE Config = ?");
//         $query->bind_param("s", $config);
//         $query->execute();
//         $query->bind_result($Setting);
//         while($query->fetch()){
//             $aosConfig->setGhostID($Setting);
//         }
//         $query->close();
//         $config = "GhostLabel";
//         $query = $connection->prepare("SELECT Setting FROM Meeter WHERE Config = ?");
//         $query->bind_param("s", $config);
//         $query->execute();
//         $query->bind_result($Setting);
//         while($query->fetch()){
//             $aosConfig->setGhostLabel($Setting);
//         }
//         $query->close();
//         $connection->close();
//     }
    /*-----------------------------------------------------------------------
     * getCandidates($cat)
     * ----------------------------------------------------------------------
     * the form will call this function to get an object with the people that
     * signed up for the particular cateogory. The possible information is
     * stored in the Commits table in the database.
     * 
     */
    function getPeepsForService($service){
        // we will load array and return
        $peeps = array();
        // going to query database for the category (service) passed in and load array
        mysqli_report(MYSQLI_REPORT_STRICT);
        
        define('DB_HOST', 'localhost');
        define('DB_USER', 'dcolombo_muat');
        define('DB_PASSWORD', 'MR0mans1212!');
        define('DB_NAME', 'dcolombo_muat');
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $query = $connection->prepare("SELECT ID, FName, LName FROM Commits WHERE Category = ?");
        $query->bind_param("s", $service);
        $query->execute();
        $query->bind_result($id, $fn, $ln);
        while($query->fetch()){
            $name = $fn . " " . $ln;
            $peeps[$id] = $name;
        }
        $query->close();
        return $peeps;
    }

    function getHostsForMeeting(){
        //---------------------------------------------------------
        // this returns an array with the ID and name for each Host listed in Meeter HostSet
        $hosts = array();
        $hostString;
        mysqli_report(MYSQLI_REPORT_STRICT);
        
//         define('DB_HOST', 'localhost');
//         define('DB_USER', 'dcolombo_muat');
//         define('DB_PASSWORD', 'MR0mans1212!');
//         define('DB_NAME', 'dcolombo_muat');
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $query = $connection->prepare("SELECT Setting From Meeter WHERE Config = 'HostSet'");
        $query->execute();
        $query->bind_result($setting);
        while($query->fetch()){
            $hostString = $setting;
        }
        $query->close();
        $hostID = explode("|", $hostString);

        //now get the people reference for the hostIDs
        $peeps = array();
        $query = $connection->prepare("SELECT ID, FName, LName FROM people WHERE Active = 1");
        $query->execute();
        $query->bind_result($id, $fn, $ln);
        while($query->fetch()){
            $name = $fn . " " . $ln;
            $peeps[$id] = $name;
        }
        $query->close();
        //=====================================
        // now loop through the hosts getting their names
        //=====================================
        foreach ($hostID as $id){
            foreach($peeps as $pID => $name){
                if($id == $pID){
                    $hosts[$id] = $name;
                }
            }
        }
        return $hosts;
    }
    