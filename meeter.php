<?php
/*******************************************
 * meeter.php
 * 
 * --------------------------------------
 * this is a required file that is used
 * for system configuration
 *****************************************/
define("NOBODY", "0");

class mFeature
{

    // features
    public $greeters = true;
    public $resources = true;
    public $transportation = true;
    public $worship = true;
    public $meal = true;
    public $mealFac = true;
    public $chips = true;
    public $readers = true;
    public $announcements = true;
    public $donations = true;
    public $nursery = true;
    public $nurseryFac = true;
    public $children = true;

    public $childrenFac = true;

    public $youth = true;

    public $youthFac = true;

    public $serenity = true;

    public $cafe = true;

    public $cafeFac = true;

    public $setup = true;

    public $teardown = true;

    public $av = true;

    public $security = true;

    function __construct()
    {
        // this is where we can do additional configuratoin, put defaults are above
    }

    function getLatestConfig()
    {
        // -----------------------------------------------------
        // get the latest settings from the database
        // -----------------------------------------------------
        $smpl = 'Worship:True|AV:True|Greeters:False|Resources:False|Readers:False|Setup:True|Serenity:False|TearDown:True';
        $settings = explode('|', $smpl);
        for ($si = 0; $si < sizeof($settings); $si ++) {
            $pair = explode(":", $settings[$si]);
            switch ($pair[0]) {
                case "Worship":
                    if ($pair[1] === "True") {
                        $this->setWorship(true);
                    } else {
                        $this->setWorship(false);
                    }
                    break;
                case "Greeters":
                    if ($pair[1] === "True") {
                       $this->setGreeters(true);
                    } else {
                        $this->setGreeters(false);
                    }
                    break;
                case "AV":
                    if ($pair[1] === "True") {
                        $this->setAV(true);
                    } else {
                        $this->setAV(false);
                    }
                    break;
                case "Meal":
                    if ($pair[1] == "True"){
                        $this->setMeal(true);
                    }else{
                        $this->setMeal(false);
                    }
                case "MealFac":
                    if ($pair[1] == "True"){
                        $this->setMealFac(true);
                    }else{
                        $this->setMealFac(false);
                    }
            }
        }
    }

    /**
     *
     * @return boolean
     */
    public function getGreeters()
    {
        return $this->greeters;
    }

    /**
     *
     * @param boolean $greeters
     */
    public function setGreeters($greeters)
    {
        $this->greeters = $greeters;
    }

    /**
     *
     * @return boolean
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     *
     * @param boolean $resources
     */
    public function setResources($resources)
    {
        $this->resources = $resources;
    }

    /**
     *
     * @return boolean
     */
    public function getTransportation()
    {
        return $this->transportation;
    }

    /**
     *
     * @param boolean $transportation
     */
    public function setTransportation($transportation)
    {
        $this->transportation = $transportation;
    }

    /**
     *
     * @return boolean
     */
    public function getWorship()
    {
        echo "core says: $this->worship\n"; 
        return $this->worship;
    }

    /**
     *
     * @param boolean $worship
     */
    public function setWorship($worship)
    {
        $this->worship = $worship;
    }

    /**
     *
     * @return boolean
     */
    public function getMeal()
    {
        return $this->meal;
    }

    /**
     *
     * @param boolean $meal
     */
    public function setMeal($meal)
    {
        $this->meal = $meal;
    }

    /**
     *
     * @return boolean
     */
    public function getMealFac()
    {
        return $this->mealFac;
    }

    /**
     *
     * @param boolean $mealFac
     */
    public function setMealFac($mealFac)
    {
        $this->mealFac = $mealFac;
    }

    /**
     *
     * @return boolean
     */
    public function getChips()
    {
        return $this->chips;
    }

    /**
     *
     * @param boolean $chips
     */
    public function setChips($chips)
    {
        $this->chips = $chips;
    }

    /**
     *
     * @return boolean
     */
    public function getReaders()
    {
        return $this->readers;
    }

    /**
     *
     * @param boolean $readers
     */
    public function setReaders($readers)
    {
        $this->readers = $readers;
    }

    /**
     *
     * @return boolean
     */
    public function getAnnouncements()
    {
        return $this->announcements;
    }

    /**
     *
     * @param boolean $announcements
     */
    public function setAnnouncements($announcements)
    {
        $this->announcements = $announcements;
    }

    /**
     *
     * @return boolean
     */
    public function getDonations()
    {
        return $this->donations;
    }

    /**
     *
     * @param boolean $donations
     */
    public function setDonations($donations)
    {
        $this->donations = $donations;
    }

    /**
     *
     * @return boolean
     */
    public function getNursery()
    {
        return $this->nursery;
    }

    /**
     *
     * @param boolean $nursery
     */
    public function setNursery($nursery)
    {
        $this->nursery = $nursery;
    }

    /**
     *
     * @return boolean
     */
    public function getNurseryFac()
    {
        return $this->nurseryFac;
    }

    /**
     *
     * @param boolean $nurseryFac
     */
    public function setNurseryFac($nurseryFac)
    {
        $this->nurseryFac = $nurseryFac;
    }

    /**
     *
     * @return boolean
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     *
     * @param boolean $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     *
     * @return boolean
     */
    public function getChildrenFac()
    {
        return $this->childrenFac;
    }

    /**
     *
     * @param boolean $childrenFac
     */
    public function setChildrenFac($childrenFac)
    {
        $this->childrenFac = $childrenFac;
    }

    /**
     *
     * @return boolean
     */
    public function getYouth()
    {
        return $this->youth;
    }

    /**
     *
     * @param boolean $youth
     */
    public function setYouth($youth)
    {
        $this->youth = $youth;
    }

    /**
     *
     * @return boolean
     */
    public function getYouthFac()
    {
        return $this->youthFac;
    }

    /**
     *
     * @param boolean $youthFac
     */
    public function setYouthFac($youthFac)
    {
        $this->youthFac = $youthFac;
    }

    /**
     *
     * @return boolean
     */
    public function getSerenity()
    {
        return $this->serenity;
    }

    /**
     *
     * @param boolean $serenity
     */
    public function setSerenity($serenity)
    {
        $this->serenity = $serenity;
    }

    /**
     *
     * @return boolean
     */
    public function getCafe()
    {
        return $this->cafe;
    }

    /**
     *
     * @param boolean $cafe
     */
    public function setCafe($cafe)
    {
        $this->cafe = $cafe;
    }

    /**
     *
     * @return boolean
     */
    public function getCafeFac()
    {
        return $this->cafeFac;
    }

    /**
     *
     * @param boolean $cafeFac
     */
    public function setCafeFac($cafeFac)
    {
        $this->cafeFac = $cafeFac;
    }

    /**
     *
     * @return boolean
     */
    public function getSetup()
    {
        return $this->setup;
    }

    /**
     *
     * @param boolean $setup
     */
    public function setSetup($setup)
    {
        $this->setup = $setup;
    }

    /**
     *
     * @return boolean
     */
    public function getTeardown()
    {
        return $this->teardown;
    }

    /**
     *
     * @param boolean $teardown
     */
    public function setTeardown($teardown)
    {
        $this->teardown = $teardown;
    }

    /**
     *
     * @return boolean
     */
    public function getAv()
    {
        return $this->av;
    }

    /**
     *
     * @param boolean $av
     */
    public function setAv($av)
    {
        $this->av = $av;
    }

    /**
     *
     * @return boolean
     */
    public function getSecurity()
    {
        return $this->security;
    }

    /**
     *
     * @param boolean $security
     */
    public function setSecurity($security)
    {
        $this->security = $security;
    }
}
$mtrConfig = new mFeature();

class meeting
{

    // this is used to manage and manipulate the meeting information
    // --------------------------------------------------------------
    // these are the properities of a meeting.
    // --------------------------------------------------------------
    public $mtgID;
    public $mtgDate;
    public $mtgType;
    public $mtgTitle;
    // trackable properties

    public $mtgFac;
    public $mtgAttendance;
    public $donations;
    public $worshipFac;
    public $audioVisualFac;
    public $setupFac;
    public $transportationFac;
    public $greeter1Fac;
    public $greeter2Fac;
    public $resourcesFac;
    public $menu;
    public $mealCnt;
    public $mealFac;
    public $reader1Fac;
    public $reader2Fac;
    public $announcementsFac;
    public $teachingFac;
    public $chips1Fac;
    public $chips2Fac;
    public $serenityFac;
    public $newcomers1Fac;
    public $newcomers2Fac;
    public $nurseryCnt;
    public $nurseryFac;
    public $childrenCnt;
    public $childrenFac;
    public $youthCnt;
    public $youthFac;
    public $cafeFac;
    public $tearDownFac;
    public $securityFac;
    public $notes;

    /**
     * @return mixed
     */
    public function getMtgID()
    {
        return $this->mtgID;
    }

    /**
     * @param mixed $mtgID
     */
    public function setMtgID($mtgID)
    {
        $this->mtgID = $mtgID;
    }

    /**
     * @return mixed
     */
    public function getMtgDate()
    {
        return $this->mtgDate;
    }

    /**
     * @param mixed $mtgDate
     */
    public function setMtgDate($mtgDate)
    {
        $this->mtgDate = $mtgDate;
    }

    /**
     * @return mixed
     */
    public function getMtgType()
    {
        return $this->mtgType;
    }

    /**
     * @param mixed $mtgType
     */
    public function setMtgType($mtgType)
    {
        $this->mtgType = $mtgType;
    }

    /**
     * @return mixed
     */
    public function getMtgTitle()
    {
        return $this->mtgTitle;
    }

    /**
     * @param mixed $mtgTitle
     */
    public function setMtgTitle($mtgTitle)
    {
        $this->mtgTitle = $mtgTitle;
    }

    /**
     * @return mixed
     */
    public function getMtgFac()
    {
        return $this->mtgFac;
    }

    /**
     * @param mixed $mtgFac
     */
    public function setMtgFac($mtgFac)
    {
        $this->mtgFac = $mtgFac;
    }

    /**
     * @return mixed
     */
    public function getMtgAttendance()
    {
        return $this->mtgAttendance;
    }

    /**
     * @param mixed $mtgCnt
     */
    public function setMtgAttendance($mtgAttendance)
    {
        $this->mtgAttendance = $mtgAttendance;
    }

    /**
     * @return mixed
     */
    public function getDonations()
    {
        return $this->donations;
    }

    /**
     * @param mixed $donations
     */
    public function setDonations($donations)
    {
        $this->donations = $donations;
    }

    /**
     * @return mixed
     */
    public function getWorshipFac()
    {
        return $this->worshipFac;
    }

    /**
     * @param mixed $worshipFac
     */
    public function setWorshipFac($worshipFac)
    {
        $this->worshipFac = $worshipFac;
    }

    /**
     * @return mixed
     */
    public function getAudioVisualFac()
    {
        return $this->audioVisualFac;
    }

    /**
     * @param mixed $audioVisualFac
     */
    public function setAudioVisualFac($audioVisualFac)
    {
        $this->audioVisualFac = $audioVisualFac;
    }

    /**
     * @return mixed
     */
    public function getSetupFac()
    {
        return $this->setupFac;
    }

    /**
     * @param mixed $setupFac
     */
    public function setSetupFac($setupFac)
    {
        $this->setupFac = $setupFac;
    }

    /**
     * @return mixed
     */
    public function getTransportationFac()
    {
        return $this->transportationFac;
    }

    /**
     * @param mixed $transportationFac
     */
    public function setTransportationFac($transportationFac)
    {
        $this->transportationFac = $transportationFac;
    }

    /**
     * @return mixed
     */
    public function getGreeter1Fac()
    {
        return $this->greeter1Fac;
    }

    /**
     * @param mixed $greeter1Fac
     */
    public function setGreeter1Fac($greeter1Fac)
    {
        $this->greeter1Fac = $greeter1Fac;
    }

    /**
     * @return mixed
     */
    public function getGreeter2Fac()
    {
        return $this->greeter2Fac;
    }

    /**
     * @param mixed $greeter2Fac
     */
    public function setGreeter2Fac($greeter2Fac)
    {
        $this->greeter2Fac = $greeter2Fac;
    }

    /**
     * @return mixed
     */
    public function getResourcesFac()
    {
        return $this->resourcesFac;
    }

    /**
     * @param mixed $resourcesFac
     */
    public function setResourcesFac($resourcesFac)
    {
        $this->resourcesFac = $resourcesFac;
    }

    /**
     * @return mixed
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * @param mixed $menu
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;
    }

    /**
     * @return mixed
     */
    public function getMealCnt()
    {
        return $this->mealCnt;
    }

    /**
     * @param mixed $mealCnt
     */
    public function setMealCnt($mealCnt)
    {
        $this->mealCnt = $mealCnt;
    }

    /**
     * @return mixed
     */
    public function getMealFac()
    {
        return $this->mealFac;
    }

    /**
     * @param mixed $mealFac
     */
    public function setMealFac($mealFac)
    {
        $this->mealFac = $mealFac;
    }

    /**
     * @return mixed
     */
    public function getReader1Fac()
    {
        return $this->reader1Fac;
    }

    /**
     * @param mixed $reader1Fac
     */
    public function setReader1Fac($reader1Fac)
    {
        $this->reader1Fac = $reader1Fac;
    }

    /**
     * @return mixed
     */
    public function getReader2Fac()
    {
        return $this->reader2Fac;
    }

    /**
     * @param mixed $reader2Fac
     */
    public function setReader2Fac($reader2Fac)
    {
        $this->reader2Fac = $reader2Fac;
    }

    /**
     * @return mixed
     */
    public function getAnnouncementsFac()
    {
        return $this->announcementsFac;
    }

    /**
     * @param mixed $announcementsFac
     */
    public function setAnnouncementsFac($announcementsFac)
    {
        $this->announcementsFac = $announcementsFac;
    }

    /**
     * @return mixed
     */
    public function getTeachingFac()
    {
        return $this->teachingFac;
    }

    /**
     * @param mixed $teachingFac
     */
    public function setTeachingFac($teachingFac)
    {
        $this->teachingFac = $teachingFac;
    }

    /**
     * @return mixed
     */
    public function getChips1Fac()
    {
        return $this->chips1Fac;
    }

    /**
     * @param mixed $chips1Fac
     */
    public function setChips1Fac($chips1Fac)
    {
        $this->chips1Fac = $chips1Fac;
    }

    /**
     * @return mixed
     */
    public function getChips2Fac()
    {
        return $this->chips2Fac;
    }

    /**
     * @param mixed $chips2Fac
     */
    public function setChips2Fac($chips2Fac)
    {
        $this->chips2Fac = $chips2Fac;
    }

    /**
     * @return mixed
     */
    public function getSerenityFac()
    {
        return $this->serenityFac;
    }

    /**
     * @param mixed $serenityFac
     */
    public function setSerenityFac($serenityFac)
    {
        $this->serenityFac = $serenityFac;
    }

    /**
     * @return mixed
     */
    public function getNewcomers1Fac()
    {
        return $this->newcomers1Fac;
    }

    /**
     * @param mixed $newcomers1Fac
     */
    public function setNewcomers1Fac($newcomers1Fac)
    {
        $this->newcomers1Fac = $newcomers1Fac;
    }

    /**
     * @return mixed
     */
    public function getNewcomers2Fac()
    {
        return $this->newcomers2Fac;
    }

    /**
     * @param mixed $newcomers2Fac
     */
    public function setNewcomers2Fac($newcomers2Fac)
    {
        $this->newcomers2Fac = $newcomers2Fac;
    }

    /**
     * @return mixed
     */
    public function getNurseryCnt()
    {
        return $this->nurseryCnt;
    }

    /**
     * @param mixed $nurseryCnt
     */
    public function setNurseryCnt($nurseryCnt)
    {
        $this->nurseryCnt = $nurseryCnt;
    }

    /**
     * @return mixed
     */
    public function getNurseryFac()
    {
        return $this->nurseryFac;
    }

    /**
     * @param mixed $nurseryFac
     */
    public function setNurseryFac($nurseryFac)
    {
        $this->nurseryFac = $nurseryFac;
    }

    /**
     * @return mixed
     */
    public function getChildrenCnt()
    {
        return $this->childrenCnt;
    }

    /**
     * @param mixed $childrenCnt
     */
    public function setChildrenCnt($childrenCnt)
    {
        $this->childrenCnt = $childrenCnt;
    }

    /**
     * @return mixed
     */
    public function getChildrenFac()
    {
        return $this->childrenFac;
    }

    /**
     * @param mixed $childrenFac
     */
    public function setChildrenFac($childrenFac)
    {
        $this->childrenFac = $childrenFac;
    }

    /**
     * @return mixed
     */
    public function getYouthCnt()
    {
        return $this->youthCnt;
    }

    /**
     * @param mixed $youthCnt
     */
    public function setYouthCnt($youthCnt)
    {
        $this->youthCnt = $youthCnt;
    }

    /**
     * @return mixed
     */
    public function getYouthFac()
    {
        return $this->youthFac;
    }

    /**
     * @param mixed $youthFac
     */
    public function setYouthFac($youthFac)
    {
        $this->youthFac = $youthFac;
    }

    /**
     * @return mixed
     */
    public function getCafeFac()
    {
        return $this->cafeFac;
    }

    /**
     * @param mixed $cafeFac
     */
    public function setCafeFac($cafeFac)
    {
        $this->cafeFac = $cafeFac;
    }

    /**
     * @return mixed
     */
    public function getTearDownFac()
    {
        return $this->tearDownFac;
    }

    /**
     * @param mixed $tearDownFac
     */
    public function setTearDownFac($tearDownFac)
    {
        $this->tearDownFac = $tearDownFac;
    }

    /**
     * @return mixed
     */
    public function getSecurityFac()
    {
        return $this->securityFac;
    }

    /**
     * @param mixed $securityFac
     */
    public function setSecurityFac($securityFac)
    {
        $this->securityFac = $securityFac;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
    
    function __construct($mDate, $mType, $mTitle){
        $this->setMtgDate($mDate);
        $this->setMtgType($mType);
        $this->setMtgTitle($mTitle);
    }
    public function printMeeting()
    {
        echo "------------ PRINTING MEETING DEFINITION -------------------";
        echo "$mtgDate: " . $mtgDate . nl2br("\n");
        echo "$mtgType: " . $mtgType . nl2br("\n");
        echo "$mtgTitle: " . $mtgTitle . nl2br("\n");
        echo "$id: " . $id . nl2br("\n");
        echo "$host: " . $host . nl2br("\n");
        echo "$attendance: " . $attendance . nl2br("\n");
        echo "$donationAmount: " . $donationAmount . nl2br("\n");
        echo "$mealGuests: " . $mealGuests . nl2br("\n");
        echo "$notes: " . $notes . nl2br("\n");
        echo "$greeter1: " . $greeter1 . nl2br("\n");
        echo "$greeter2: " . $greeter2 . nl2br("\n");
        echo "$resources: " . $resources . nl2br("\n");
        echo "$transportation: " . $transportation . nl2br("\n");
        echo "$worship: " . $worship . nl2br("\n");
        echo "$chips1: " . $chips1 . nl2br("\n");
        echo "$chips2: " . $chips2 . nl2br("\n");
        echo "$meal: " . $meal . nl2br("\n");
        echo "$mealFac: " . $mealFac . nl2br("\n");
        echo "$reader1: " . $reader1 . nl2br("\n");
        echo "$reader2: " . $reader2 . nl2br("\n");
        echo "$announcements: " . $announcements . nl2br("\n");
        echo "$donations: " . $donations . nl2br("\n");
        echo "$nursery: " . $nursery . nl2br("\n");
        echo "$nurseryFac: " . $nurseryFac . nl2br("\n");
        echo "$children: " . $children . nl2br("\n");
        echo "$childrenFac: " . $childrenFac . nl2br("\n");
        echo "$youth: " . $youth . nl2br("\n");
        echo "$youthFac: " . $youthFac . nl2br("\n");
        echo "$serenity: " . $serenity . nl2br("\n");
        echo "$nurseryFac: " . $nurseryFac . nl2br("\n");
        echo "$cafe: " . $cafe . nl2br("\n");
        echo "$cafeFac: " . $cafeFac . nl2br("\n");
        echo "$setup: " . $setup . nl2br("\n");
        echo "$teardown: " . $teardown . nl2br("\n");
        echo "$av: " . $av . nl2br("\n");
        echo "$security: " . $security . nl2br("\n");
    }

    public function commitNew()
    {
        // this inserts Date/Type/Title into database and sets id
        try {
            $stmt = $connection->prepare("INSERT INTO `meetings` ( MtgDate, MtgType, MtgTitle) VALUES ( ?, ?, ?)");
            $stmt->bind_param("sss", $this->mtgDate, $this->mtgType, $this->mtgTitle);
            $stmt->execute();
            
            $this->id = $connection->insert_id;
            
            $stmt->close();
        } catch (PDOException $e) {
            echo "Error: [meeter.php_commitNew()] " . $e->getMessage();
        }
        
        $connection = null;
    }

    public function getMeeting($MID){
        //-----------------------------------------
        // this function will load the class with
        // the MID passed in.
        //-----------------------------------------
        if ( isset( $connection ) ) return;
            
        mysqli_report(MYSQLI_REPORT_STRICT);
            
        define('DB_HOST', 'localhost');
        define('DB_USER', 'dcolombo_muat');
        define('DB_PASSWORD', 'MR0mans1212!');
        define('DB_NAME', 'dcolombo_muat');
        $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            
        if (mysqli_connect_errno()) {
            die(sprintf("[meeter.php] Connect failed: %s\n", mysqli_connect_error()));
        }
        $sql = "SELECT * FROM meetings WHERE ID = " . $MID;
        
        $mtg = array();
        
        $result = $mysqli->query($sql);
        
        while ($row = $result->fetch_array(MYSQLI_ASSOC))
        {
            $mtg[] = array($row['ID'], $row['MtgDate'], $row['MtgType'],
                $row['MtgTitle'], $row['MtgPresenter'], $row['MtgAttendance'],
                $row['MtgWorship'], $row['MtgMeal'], $row['DinnerCnt'],
                $row['NurseryCnt'], $row['ChildrenCnt'], $row['YouthCnt'],
                $row['MtgNotes'], $row['Donations'],$row['Reader1'], $row['Reader2'],
                $row['NurseryContact'],$row['ChildrenContact'], $row['YouthContact'],
                $row['MealContact'],$row['CafeContact'], $row['TransportationContact'],
                $row['SetupContact'],$row['TearDownContact'], $row['Greeter1'],
                $row['Greeter2'],$row['Resources'], $row['Serenity'],$row['AudioVisual'],
                $row['Announcements'], $row['SecurityContact']
                
            );
        }
        $this->setId($mtg[0][0]);
        $this->setMtgDate($mtg[0][1]);
        $this->setMtgType($mtg[0][2]);
        $this->setMtgTitle($mtg[0][3]);
        $this->setHost($mtg[0][4]);
        $this->setAttendance($mtg[0][5]);
        $this->setWorship($mtg[0][6]);
        $this->setMeal($mtg[0][7]);
        $this->setMealGuests($mtg[0][8]);
        $this->setNursery($mtg[0][9]);
        $this->setChildren($mtg[0][10]);
        $this->setYouth($mtg[0][11]);
        $this->setNotes($mtg[0][12]);
        $this->setDonationAmount($mtg[0][13]);
        $this->setReader1($mtg[0][14]);
        $this->setReader2($mtg[0][15]);
        $this->setNurseryFac($mtg[0][16]);
        $this->setChildrenFac($mtg[0][17]);
        $this->setYouthFac($mtg[0][18]);
        $this->setMealFac($mtg[0][19]);
        $this->setCafeFac($mtg[0][20]);
        $this->setTransportation($mtg[0][21]);
        $this->setSetup($mtg[0][22]);
        $this->setTeardown($mtg[0][23]);
        $this->setGreeter1($mtg[0][24]);
        $this->setGreeter2($mtg[0][25]);
        $this->setResources($mtg[0][26]);
        $this->setSerenity($mtg[0][27]);
        $this->setAv($mtg[0][28]);
        $this->setAnnouncements($mtg[0][29]);
        $this->setSecurity($mtg[0][30]);
    }
}
$theMeeting = new meeting($mDate, $mType, $mTitle);

//#####################################
//    MeeterPeep
//#####################################
class MeeterPeep{
    public $id = "";
    public $active = "";
    public $fName = "";
    public $lName = "";
    public $street = "";
    public $city = "";
    public $state = "";
    public $postalCode = "";
    public $phone1 = "";
    public $phone2 = "";
    public $email1 = "";
    public $email2 = "";
    public $spiritualGifts = "";
    public $recoveryArea = "";
    public $recoverySince = "";
    public $crSince = "";
    public $covenantDate = "";
    public $areasServed = "";
    public $joyAreas = "";
    public $reasonsToServe = "";
    public $interests = "";
    public $notes = "";
    public $birthDay = "";
    public $AOS = "";           // AOS = AreasOfService (volunteer configs)
    
    public function getID()
    {
        return $this->id;
    }
    
    public function setID($ID)
    {
        $this->id = $ID;
    }

    public function getActive()
    {
        return $this->active;
    }
    
    public function setActive($active)
    {
        $this->active = $active;
    }
    
    public function getFName()
    {
        return $this->fName;
    }

    public function setFName($fName)
    {
        $this->fName = $fName;
    }

    public function getLName()
    {
        return $this->lName;
    }

    public function setLName($lName)
    {
        $this->lName = $lName;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    public function getPhone1()
    {
        return $this->phone1;
    }

    public function setPhone1($phone1)
    {
        $this->phone1 = $phone1;
    }

    public function getPhone2()
    {
        return $this->phone2;
    }

    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;
    }

    public function getEmail1()
    {
        return $this->email1;
    }

    public function setEmail1($email1)
    {
        $this->email1 = $email1;
    }

    public function getEmail2()
    {
        return $this->email2;
    }

    public function setEmail2($email2)
    {
        $this->email2 = $email2;
    }

    public function getSpiritualGifts()
    {
        return $this->spiritualGifts;
    }

    public function setSpiritualGifts($spiritualGifts)
    {
        $this->spiritualGifts = $spiritualGifts;
    }

    public function getRecoveryArea()
    {
        return $this->recoveryArea;
    }

    public function setRecoveryArea($recoveryArea)
    {
        $this->recoveryArea = $recoveryArea;
    }

    public function getRecoverySince()
    {
        return $this->recoverySince;
    }

    public function setRecoverySince($recoverySince)
    {
        $this->recoverySince = $recoverySince;
    }

    public function getCrSince()
    {
        return $this->crSince;
    }

    public function setCrSince($crSince)
    {
        $this->crSince = $crSince;
    }

    public function getCovenantDate()
    {
        return $this->covenantDate;
    }

    public function setCovenantDate($covenantDate)
    {
        $this->covenantDate = $covenantDate;
    }

    public function getAreasServed()
    {
        return $this->areasServed;
    }

    public function setAreasServed($areasServed)
    {
        $this->areasServed = $areasServed;
    }

    public function getJoyAreas()
    {
        return $this->joyAreas;
    }

    public function setJoyAreas($joyAreas)
    {
        $this->joyAreas = $joyAreas;
    }

    public function getReasonsToServe()
    {
        return $this->reasonsToServe;
    }

    public function setReasonsToServe($reasonsToServe)
    {
        $this->reasonsToServe = $reasonsToServe;
    }

    public function getInterests()
    {
        return $this->interests;
    }

    public function setInterests($interests)
    {
        $this->interests = $interests;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    public function getBirthDay()
    {
        return $this->birthDay;
    }

    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;
    }
    public function getAOS()
    {
        return $this->AOS;
    }
    
    public function setAOS($AOS)
    {
        $this->AOS = $AOS;
    }
    
    public function evalAOS($target){
        $storedValues = $this->getAOS();
//         echo "\$storedValues in func: " . $storedValues;
        $settings = explode("|", $storedValues);
//         echo "setttings=" . count($settings) . "<br/>";
        for($chk = 0; $chk < count($settings); $chk++){
//             echo "in for loop<br/>";
            $pair = explode(":", $settings[$chk]);
            if(strcmp($target, $pair[0])==0){
//                 echo "in if<br/>";
                if(strcmp($pair[1], "True")==0){
                    return "TRUE";
                }else{
                    return "FALSE";
                }
            }
        }
        return FALSE;
        
    }
    public function getPerson($PID){
        //this loads the class with the person associated with PID
        if ( isset( $connection ) ) return;
        
        mysqli_report(MYSQLI_REPORT_STRICT);
        
        define('DB_HOST', 'localhost');
        define('DB_USER', 'dcolombo_muat');
        define('DB_PASSWORD', 'MR0mans1212!');
        define('DB_NAME', 'dcolombo_muat');
        $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        
        if (mysqli_connect_errno()) {
            die(sprintf("[meeter.php] Connect failed: %s\n", mysqli_connect_error()));
        }
        $sql = "SELECT * FROM people WHERE ID = " . $PID;
        $mtg = array();
        
        $result = $mysqli->query($sql);
         
        while ($row = $result->fetch_array(MYSQLI_ASSOC))
        {
//             $mtg[] = array($row['ID'], $row['FName'], $row['LName'],
//                 $row['Address'], $row['City'], $row['State'],
//                 $row['Zipcode'], $row['Phone1'], $row['Phone2'],
//                 $row['Email1'], $row['Email2'], $row['RecoveryArea'],
//                 $row['RecoverySince'], $row['CRSince'],$row['Covenant'], $row['SpiritualGifts'],
//                 $row['AreasServed'],$row['JoyAreas'], $row['ReasonsToServe'],
//                 $row['Interests']
//             );
            
            $this->setID($row['ID']);
            $this->setActive($row['Active']);
            $this->setFName($row['FName']);
            $this->setLName($row['LName']);
            $this->setStreet($row['Address']);
            $this->setCity($row['City']);
            $this->setState($row['State']);
            $this->setPostalCode($row['Zipcode']);
            $this->setPhone1($row['Phone1']);
            $this->setPhone2($row['Phone2']);
            $this->setEmail1($row['Email1']);
            $this->setEmail2($row['Email2']);
            $this->setRecoveryArea($row['RecoveryArea']);
            $this->setRecoverySince($row['RecoverySince']);
            $this->setCrSince($row['CRSince']);
            $this->setCovenantDate($row['Covenant']);
            $this->setSpiritualGifts($row['SpiritualGifts']);
            $this->setAreasServed($row['AreasServed']);
            $this->setJoyAreas($row['JoyAreas']);
            $this->setReasonsToServe($row['ReasonsToServe']);
            $this->setInterests($row['Interests']);
            $this->setAOS($row['AOS']);
            $this->setNotes($row['Notes']);
            
            
        }
        if(sizeof($this->getAOS())<1){
            $this->defineAOS($PID);
        }
//         $this->defineAOS($PID);
        $result->close();
        $connection->close();
    }

    public function defineAOS($PID){
        $s = "";
        
        if ( isset( $connection ) ) return;
        
        mysqli_report(MYSQLI_REPORT_STRICT);
        
        define('DB_HOST', 'localhost');
        define('DB_USER', 'dcolombo_muat');
        define('DB_PASSWORD', 'MR0mans1212!');
        define('DB_NAME', 'dcolombo_muat');
        $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        
        if (mysqli_connect_errno()) {
            die(sprintf("[meeter.php] Connect failed: %s\n", mysqli_connect_error()));
        }
        $sql = "SELECT * FROM people WHERE ID = " . $PID;
        $mtg = array();
        
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_array(MYSQLI_ASSOC))
        {
            $s = "Fellowship:";
            if($row['FellowshipTeam'] == "1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|Prayer:";
            if($row['PrayerTeam'] == "1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|Newcomers:";
            if($row['NewcomersTeam'] == "1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|Greeting:";
            if($row['GreetingTeam'] == "1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|SpecialEvents:";
            if($row['SpecialEventsTeam'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|Resources|";
            if($row['ResourceTeam'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|SmallGroup:";
            if($row['SmallGroupTeam'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|StepStudy:";
            if($row['StepStudyTeam'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|Transportation:";
            if($row['TransportationTeam'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|Worship:";
            if($row['WorshipTeam'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|Youth:";
            if($row['LandingTeam'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|Children:";
            if($row['CelebrationPlaceTeam'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|Cafe:";
            if($row['SolidRockTeam'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|Meal:";
            if($row['MealTeam'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|CRIM:";
            if($row['CRIMen'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|CRIW:";
            if($row['CRIWomen'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|Teaching:";
            if($row['TeachingTeam'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            $s = $s . "|Chips:";
            if($row['Chips'] =="1"){
                $s = $s . "True";
            }else{
                $s = $s . "False";
            }
            
        }
        echo $s . "<br/>";
        $result->close();
        $connection->close();
        $this->setAOS($s);
    }

    // end MeeterPeep Class
}
$thePeep = new MeeterPeep();

class mtrInterests{
    public $defineInterests = "";
    
    public function confirmInterests($ints){
        //===================================================
        // this routine loads the default/expected values, then
        // compares the passed in string, then adding to the 
        // string before returning.
        //======================================================
        // order does not matter, add new areas at the end of definition
        $baseline = "GMNFaciliator";
        $baseline += "|Teaching";
        $baseline += "|AV";
        $baseline += "|Greeting";
        $baseline += "|Resources";
        $baseline += "|Readers";
        $baseline += "|Announcements";
        $baseline += "|Chips";
        $baseline += "|Serenity";
        $baseline += "|Cafe";
        $baseline += "|Meals";
        $baseline += "|Nursery";
        $baseline += "|Children";
        $baseline += "|Youth";
        $baseline += "|Setup";
        $baseline += "|TearDown";
        $baseline += "|Transportation";
        $baseline += "|Security";
        $baseline += "|Fellowship";
        $baseline += "|Prayer";
        $baseline += "|Newcomers";
        $baseline += "|SpecialEvents";
        $baseline += "|SmallGroups";
        $baseline += "|StepStudy";
        $baseline += "|CRIM";
        $baseline += "|CRIW";
        
        //create definitions
        $ref = explode("|", $baseline);
        //get settings passed in
        $settings = explode("|", $ints);
        
        for ($l = 0; $l < sizeof($ref); $l++ ){
            //for every basesline
            $found = false;
            for($il = 0; $il< sizeof($settings); $il++){
                $pair = explode(":", $setting[$il]);
                if($ref[$l] == $pair[0]){
                    $found = True;
                    $il = sizeof($settings);
                }
            }
            if($found == false){
                //current ref not in list, add it
                $ints += $ref[$l] . ":False";
            }
        
        }
        return $ints;
    }
    
}
function insertNav(){
    echo "<nav>";
    echo "<a href=\"meetings.php\">Meetings</a>";
    echo "<a href=\"people.php\">People</a>";
    echo "<a href=\"teams.php\">Teams</a>";
    echo "<a href=\"leadership.php\">Leadership</a>";
    echo "<a href=\"reportlist.php\">Reporting</a>";
    echo "<a href=\"#\">ADMIN</a>";
    echo "<a href=\"logout.php\">[ LOGOUT ]</a>";
    echo "</nav>";
}
function insertFooter(){
    echo "<footer> &copy; 2013-2018 Rogue Intelligence </footer>";
}
