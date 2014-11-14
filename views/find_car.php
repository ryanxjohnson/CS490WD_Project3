<?php
require_once("/../classes/Car.php");

$search_available_cars = new Car();

$data="empty search yields all results";
if (isset($_POST['search_field']) && trim($_POST['search_field']) != "") {
    $data = $_POST['search_field'];
    $query = $search_available_cars->get_cars_by_search($data);
    
} elseif (trim($_POST['search_field']) == "") {
    $query = $search_available_cars->get_available_cars();    
}
$result = $search_available_cars->get_result($query);

echo $search_terms = "Showing results for the search '" . $data . "'";
echo $search_results = $search_available_cars->print_results($result, $search_available_cars);

