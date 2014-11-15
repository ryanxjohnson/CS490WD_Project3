<?php
require_once("/../classes/Car.php");

$rented_cars = new Car();
$query = $rented_cars->get_rented_cars();

echo "Showing all rented vehicles. Click 'Return Car' to return a vehicle to inventory";
echo $rented_car_results = $rented_cars->print_results($query,"build_tainted_car"); 

// function build_tainted_car   build_searched_car
