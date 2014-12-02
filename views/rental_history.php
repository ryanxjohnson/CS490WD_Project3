<?php
/*
 * CS490_Project 3  - Ryan, Jose, Anthony, Alicia
 */

include "config/db_connection.php";
require_once("/../classes/Car.php");

$rental_history = new Car();
$query = $rental_history->get_rental_history();


echo "<table>";
echo "<th>Picture</th>";
echo "<th>Details</th>";
$rental_history_results = $rental_history->print_results($query, "build_tainted_car");
echo "</table>";



