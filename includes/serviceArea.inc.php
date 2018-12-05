<?php 

class ServiceArea extends User{
    
    // public $info = "This is ServiceArea info";
    function ServiceArea($area, $uid, $fN, $lN){
        $this->aos = $area;
        $this->uid = $uid;
        $this->fName = $fN;
        $this->lName = $lN;
    }
}

//load the resources up.

// $res[] = new ServiceArea("greeter", 3, "Jimmy", "Cricket");
// $res[] = new ServiceArea("greeter", 9, "Mary", "Lamb");
// $res[] = new ServiceArea("reader", 3, "Missy", "Prissy");
// $res[] = new ServiceArea("serenity", 9, "John", "Day");
// //var_dump($res);

// foreach($res as $r){
//     echo "<br>$r->aos | $r->uid | $r->fName |$r->lName";
// }