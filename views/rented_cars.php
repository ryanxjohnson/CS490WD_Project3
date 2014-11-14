<?php
require_once("/../config/db_connection.php");
require_once("/../classes/Car.php");

$rented_cars = new Car();
echo $rented_cars_view = "Rented Cars View";

$query = $rented_cars->get_rented_cars();
 

// TODO: query and display rented cars
