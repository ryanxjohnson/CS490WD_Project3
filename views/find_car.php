<?php
/*
 * CS490_Project 3  - Ryan, Jose, Anthony, Alicia
 */

include "config/db_connection.php";
require_once("/classes/Car.php");

$search_available_cars = new Car();

if (isset($_POST['search_field']) && trim($_POST['search_field']) != "") {
$query = $search_available_cars->search_field_check();
$search_results = $search_available_cars->print_results($query, "build_searched_car");
}

