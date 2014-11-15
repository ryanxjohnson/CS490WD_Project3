<?php
require_once("config/db_connection.php");
require_once("classes/Login.php");

$login = new Login();

if ($login->isUserLoggedIn() == true) {

    include("views/cars.php");

} else {
    // show'em to the door
    include("views/login.php");
}
