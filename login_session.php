<?php
/*
 * CS490_Project 3  - Ryan, Jose, Anthony, Alicia
 */
include "sanitization.php";
include "connection.php";

if (isset($_POST['name']) && isset($_POST['password'])) {

    $username = sanitizeMYSQL($_POST['name']);
    $password=md5(sanitizeMYSQL($_POST['password']));

    $query = "SELECT * FROM customer WHERE ID='".$username."' AND Password='".$password."'";

    $result = mysqli_query($db_server, $query);
    $text="";
    if (!$result)
        $text="Invalid username or password";
    else{
        $row_count = mysqli_num_rows($result);
    if($row_count==1){ //start a session
       $text="success";
       $row = mysqli_fetch_array($result);
       session_start(); // this is duplicate, session already started in Login.php
       ini_set('session.gc_maxlifetime',60*5); //the life time of the session is 5 minutes
        $_SESSION["username"] =$row["ID"];  
        $_SESSION["real_name"] =$row["Name"]; 
    }
    else
        $text="Invalid username or password"; 
    }
    echo $text;
}
