<?php
require_once("/../classes/Car.php");

$rental_history = new Car();
$query = $rental_history->get_rental_history();

$rental_history_results = $rental_history->print_results($query, "build_tainted_car");


