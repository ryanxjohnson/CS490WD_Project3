<?php
require_once("config/db_connection.php");
require_once("classes/Login.php");

$login = new Login();

if ($login->isUserLoggedIn() == true) {

    include("views/cars.php");

} else {
    // we don't change the page, we just show an error message
    include("views/login.php");
}
