<?php

require_once("/../config/db_connection.php");
require_once("/../classes/Car.php");

$search_available_cars = new Car();


if (isset($_POST['search_field']) && trim($_POST['search_field']) != "") {
    $data = $_POST['search_field'];

    $query = $search_available_cars->get_cars_by_search($data);
    $result = $search_available_cars->get_result($query);
} elseif (trim($_POST['search_field']) == "") {
    $query = $search_available_cars->get_available_cars();
    $result = $search_available_cars->get_result($query);
    
    
    //$row_count = mysqli_num_rows($result);
    for ($j = 0; $j < mysqli_num_rows($result); ++$j) {
        $row = mysqli_fetch_array($result); //fetch the next row 
        echo $search_results = $search_available_cars->build_car($row);
    }
}

