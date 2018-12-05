<?php
include 'mtrAOS.php';

$aosConfig->loadConfigFromDB();
echo "start<br/>";
echo "newcomers(config): " . $aosConfig->getConfig("newcomers") . "<br/>";
echo "newcomers(display string): " . $aosConfig->getDisplayString("newcomers") . "<br/>";
$aosConfig->getDisplayString("newcomers");
echo "now change display string to 101<br/>";
$aosConfig->setDisplayString("newcomers", "101");
echo "newcomers(config): " . $aosConfig->getConfig("newcomers") . "<br/>";
echo "newcomers(display string): " . $aosConfig->getDisplayString("newcomers") . "<br/>";
echo "<br/>set config to false<br/>";
$aosConfig->setConfigToFalse("newcomers");
echo "newcomers(config): " . $aosConfig->getConfig("newcomers") . "<br/>";
echo "newcomers(display string): " . $aosConfig->getDisplayString("newcomers") . "<br/>";
echo "<br/>set config to back to true<br/>";
$aosConfig->setConfigToTrue("newcomers");
echo "newcomers(config): " . $aosConfig->getConfig("newcomers") . "<br/>";
echo "newcomers(display string): " . $aosConfig->getDisplayString("newcomers") . "<br/>";

if($aosConfig->canVolunteer("setup")){
    echo "<br/>we CAN volunteer for: setup.<br/>";
}else{
    echo "<br/>CANNOT volunteer for: setup.<br/>";
}
if($aosConfig->canVolunteer("youth")){
    echo "<br/>we CAN volunteer for: youth.<br/>";
}else{
    echo "<br/>CANNOT volunteer for: youth.<br/>";
}

echo "<br/><hr/><br/>";
$aosConfig->showConfig();

// $aosConfig->showConfig();

//==========================================


// $aosConfig->getConfig("teaching");
// $aosConfig->checkBConfig("meal");
// $aosConfig->checkBConfig("chips");

// $aosConfig->showConfig();

// $aosConfig->printGreeter();

// echo "<br/>Adding a new value";
// $aosConfig->addConfig("boss", "false");
// $aosConfig->showConfig();

// echo "FROM DB...<br/>";
// $aosConfig->showConfig();
// // echo "<br\>now change to...<br/>";

// $aosConfig->addConfig("meal", "true");
// // $aosConfig->showConfig();
// $aosConfig->saveConfigToDB();

// PIDs...
//  1   Dano
//  29  Missy
//  34  Billy
//  57  Andy
// $PID = 1;
// $aosPeepConfig->loadDisplayAOS($PID);

// foreach($aosPeepConfig->displayAOS as $key => $value){
//     echo "$key: $value<br/>";
// }





echo "<br/>done";