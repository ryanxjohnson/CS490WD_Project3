<?php
/*
 * CS490_Project 3  - Ryan, Jose, Anthony, Alicia
 */

include "config/db_connection.php";
require_once("/../classes/Car.php");

$rented_cars = new Car();
$query = $rented_cars->get_rented_cars();

echo "Showing all rented vehicles. Click 'Return Car' to return a vehicle to inventory.";

echo "<table>";
echo "<th>Picture</th>";
echo "<th>Details</th>";
$rented_car_results = $rented_cars->print_results($query, "build_tainted_car");
echo "</table>";