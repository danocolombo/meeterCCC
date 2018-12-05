<?php
    //include 'mtrAOS.php';
    // this file is for use with the meeter people functionality.
    
    function people_select_all_commits(){
        $enabledFields = getDisplayValueArray();
        
        foreach($enabledFields as $field){
            echo "field: $field<br>";
        }
    }