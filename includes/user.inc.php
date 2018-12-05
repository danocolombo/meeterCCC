<?php

class User{
    public $uid;
    public $fName;
    public $lName;
    public $commits;
    function User($id, $fn, $ln, $commits){
        
        $this->uid = $id;
        $this->fName = $fn;
        $this->lName = $ln;
        $this->commits = $commits;
    }
}