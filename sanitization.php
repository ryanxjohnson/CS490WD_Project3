<?php
/*
 * CS490_Project 3  - Ryan, Jose, Anthony, Alicia
 */

include 'connection.php';

function sanitizeString($var){
    
    if(get_magic_quotes_gpc()) //get rid of unwanted slashes using magic_quotes_gpc
        $var= stripslashes($var);
    
    $var=  htmlentities($var,ENT_COMPAT, 'UTF-8'); //get rid of html entities e.g. &lt;b&gt;hi&lt;/b&gt; = <b>hi</b>
    $var= strip_tags($var); //get rid of html tags e.g. <b>
    return $var;
}

function sanitizeMYSQL($var){
    $var=  sanitizeString($var);
    return $var;
}

?>