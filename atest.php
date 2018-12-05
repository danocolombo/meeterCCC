<?php
//testing
$target = "Worship";
$storedValues = "Fellowship:True|Prayer:True|Newcomers:True|Greeting:True|SpecialEvents:True|Resources|True|SmallGroup:True|StepStudy:True|Transportation:True|Worship:True|Youth:True|Children:True|Cafe:True|Meal:True|CRIM:False|CRIW:False|Teaching:True|Chips:True";

// $storedValues = "Fellowship:True;Prayer:True;101:False";

$settings = explode("|", $storedValues);

// echo "\$settings size: " . sizeof($settings) . "<br/>";
// echo "\$settings[0] = " . $settings[0] . "<br/>";
// echo "\$settings[1] = " . $settings[1] . "<br/>";
// echo "\$settings[2] = " . $settings[2] . "<br/>";
// echo "\$settings[3] = " . $settings[3] . "<br/>";

$settings = explode("|", $storedValues);
for($chk = 0; $chk < count($settings); $chk++){
    $pair = explode(":", $settings[$chk]);
    if(strcmp($target, $pair[0])==0){
        if(strcmp($pair[1], "True")==0){
            echo $target . " = " . "TRUE<br/>";
            return TRUE;
        }else{
            echo $target . " = " . "FALSE<br/>";
            return FALSE;
        }
    }
}
