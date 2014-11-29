<?php
include "config/db_connection.php";
require_once("/classes/Car.php");

$search_available_cars = new Car();

$query = $search_available_cars->search_field_check(); // . " " . $search_available_cars->check_order_by();    
$search_results = $search_available_cars->print_results($query, "build_searched_car");

