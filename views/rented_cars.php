<?php
//require_once("/../config/db_connection.php");
require_once("/../classes/Car.php");

$rented_cars = new Car();

$rented_car_results = "";

$query = $rented_cars->get_rented_cars();

$result = $rented_cars->get_result($query);
    
    $row_count = mysqli_num_rows($result);
    
    for ($j = 0; $j < $row_count; ++$j){
        $row = mysqli_fetch_array($result); //fetch the next row 
       echo $rented_car_results = $rented_cars->build_car($row);
    }
