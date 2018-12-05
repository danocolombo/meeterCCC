<?php
include 'mtrAOS.php';
/*============================================
 * adminMeeterAction.php
 * 
 * the purpose of this file is to process the adminMeeter.php file, which
 * mainly updates the Meeter AOS (area of service) definition in the database
 * 
 */

$Action = $_GET['Action'];
if ($Action <> "UpdateAOS"){
    echo "INVALID ENTRY";
    exit;
}
//now we have config from database. update valuse from form and update database.
$aosConfig->loadConfigFromDB();
foreach($aosConfig->AOS as $key => $value){
    $cb = "cb_" . $key;
    $tb = "tb_" . $key;
    if(isset($_POST[$cb])){
        $aosConfig->setConfigToTrue($key);
        if($aosConfig->canVolunteer($key)){
            $dV = $_POST[$tb];
            $aosConfig->setDisplayString($key, $dV);
        }      
    }else{
        $aosConfig->setConfigToFalse($key);
    }
}
$aosConfig->saveConfigToDB();

// if(isset($_POST['cbSetup'])){
//     $aosConfig->setConfigToTrue("setup");
// }else{
//     $aosConfig->setConfigToFalse("setup");
// }
// if(isset($_POST['cbWorship'])){
//     $aosConfig->setConfigToTrue("worship");
// }else{
//     $aosConfig->setConfigToFalse("worship");
// }
// if(isset($_POST['cbAV'])){
//     $aosConfig->setConfigToTrue("av");
// }else{
//     $aosConfig->setConfigToFalse("av");
// }
// if(isset($_POST['cbAV'])){
//     $aosConfig->setConfigToTrue("av");
// }else{
//     $aosConfig->setConfigToFalse("av");
// }
// if(isset($_POST['cbGreeters'])){
//     $aosConfig->setConfigToTrue("greeter");
// }else{
//     $aosConfig->setConfigToFalse("greeter");
// }
// if(isset($_POST['cbResources'])){
//     $aosConfig->setConfigToTrue("resources");
// }else{
//     $aosConfig->setConfigToFalse("resources");
// }
// if(isset($_POST['cbMeal'])){
//     $aosConfig->setConfigToTrue("meal");
// }else{
//     $aosConfig->setConfigToFalse("meal");
// }
// if(isset($_POST['cbMealFac'])){
//     $aosConfig->setConfigToTrue("mealFac");
// }else{
//     $aosConfig->setConfigToFalse("mealFac");
// }
// if(isset($_POST['cbTransportation'])){
//     $aosConfig->setConfigToTrue("transportation");
// }else{
//     $aosConfig->setConfigToFalse("transportation");
// }
// if(isset($_POST['cbReaders'])){
//     $aosConfig->setConfigToTrue("reader");
// }else{
//     $aosConfig->setConfigToFalse("reader");
// }
// if(isset($_POST['cbAnnouncements'])){
//     $aosConfig->setConfigToTrue("announcements");
// }else{
//     $aosConfig->setConfigToFalse("announcements");
// }
// if(isset($_POST['cbChips'])){
//     $aosConfig->setConfigToTrue("chips");
// }else{
//     $aosConfig->setConfigToFalse("chips");
// }
// if(isset($_POST['cbDonations'])){
//     $aosConfig->setConfigToTrue("donations");
// }else{
//     $aosConfig->setConfigToFalse("donations");
// }
// if(isset($_POST['cbSerenity'])){
//     $aosConfig->setConfigToTrue("serenity");
// }else{
//     $aosConfig->setConfigToFalse("serenity");
// }
// if(isset($_POST['cbNewcomers'])){
//     $aosConfig->setConfigToTrue("newcomers");
// }else{
//     $aosConfig->setConfigToFalse("newcomers");
// }
// if(isset($_POST['cbNursery'])){
//     $aosConfig->setConfigToTrue("nursery");
// }else{
//     $aosConfig->setConfigToFalse("nursery");
// }
// if(isset($_POST['cbNurseryFac'])){
//     $aosConfig->setConfigToTrue("nurseryFac");
// }else{
//     $aosConfig->setConfigToFalse("nurseryFac");
// }
// if(isset($_POST['cbChildren'])){
//     $aosConfig->setConfigToTrue("children");
// }else{
//     $aosConfig->setConfigToFalse("children");
// }
// if(isset($_POST['cbChildrenFac'])){
//     $aosConfig->setConfigToTrue("childrenFac");
// }else{
//     $aosConfig->setConfigToFalse("childrenFac");
// }
// if(isset($_POST['cbYouth'])){
//     $aosConfig->setConfigToTrue("youth");
// }else{
//     $aosConfig->setConfigToFalse("youth");
// }
// if(isset($_POST['cbYouthFac'])){
//     $aosConfig->setConfigToTrue("youthFac");
// }else{
//     $aosConfig->setConfigToFalse("youthFac");
// }
// if(isset($_POST['cbCafe'])){
//     $aosConfig->setConfigToTrue("cafe");
// }else{
//     $aosConfig->setConfigToFalse("cafe");
// }
// if(isset($_POST['cbTearDown'])){
//     $aosConfig->setConfigToTrue("teardown");
// }else{
//     $aosConfig->setConfigToFalse("teardown");
// }
// if(isset($_POST['cbSecurity'])){
//     $aosConfig->setConfigToTrue("security");
// }else{
//     $aosConfig->setConfigToFalse("security");
// }
// if(isset($_POST['cbFellowship'])){
//     $aosConfig->setConfigToTrue("fellowship");
// }else{
//     $aosConfig->setConfigToFalse("fellowship");
// }
// if(isset($_POST['cbPrayer'])){
//     $aosConfig->setConfigToTrue("prayer");
// }else{
//     $aosConfig->setConfigToFalse("prayer");
// }
// if(isset($_POST['cbSpecialEvents'])){
//     $aosConfig->setConfigToTrue("specialEvents");
// }else{
//     $aosConfig->setConfigToFalse("specialEvents");
// }
// if(isset($_POST['cbStepStudy'])){
//     $aosConfig->setConfigToTrue("stepStudy");
// }else{
//     $aosConfig->setConfigToFalse("stepStudy");
// }
// if(isset($_POST['cbCRIMen'])){
//     $aosConfig->setConfigToTrue("crim");
// }else{
//     $aosConfig->setConfigToFalse("crim");
// }
// if(isset($_POST['cbCRIWomen'])){
//     $aosConfig->setConfigToTrue("criw");
// }else{
//     $aosConfig->setConfigToFalse("criw");
// }

// $aosConfig->saveConfigToDB();

header($loc["301"]);
header("Location: index.php");