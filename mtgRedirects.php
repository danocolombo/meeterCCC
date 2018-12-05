<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function destination($num, $url){
    static $loc = array(
        301 => "HTTP/1.1 Moved Permanently",
        307 => "HTTP/1.1 307 Temporary Redirect",
        410 => "HTTP/1.1 410 Gone"
        
    );
    
    header($loc[$num]);
    header("Location: $url");
}
?>
