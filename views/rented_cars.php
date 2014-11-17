<?php
require_once("/../classes/Car.php");

$rented_cars = new Car();
$query = $rented_cars->get_rented_cars(); // order by?

$rented_car_results = $rented_cars->print_results($query,"build_tainted_car"); 

