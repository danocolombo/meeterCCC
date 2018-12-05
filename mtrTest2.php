<?php
include 'mtrAOS.php';

$aosConfig->loadConfigFromDB();

// check if chips exist, should be true
if($aosConfig->doesSettingExist("chips")){
    echo "We confirmed \"chips\" does exist<br/>";
}else{
    echo "\"chips\" does not exist<br/>";
}

// check if chips exist, should be true
if($aosConfig->doesSettingExist("av")){
    echo "We confirmed \"av\" does exist<br/>";
}else{
    echo "confirmed \"av\" does not exist. So we added it.<br/>";
    $aosConfig->addConfig("av", "false");
}
// now confirm we added it locally
if($aosConfig->doesSettingExist("av")){
    echo "We confirmed \"av\" has been added.<br/>";
}else{
    echo "\"av\" was NOT added.<br/>";
}
