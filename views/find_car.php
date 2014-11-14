<?php
require_once("/../config/db_connection.php");
require_once("/../classes/Car.php");

$all_cars = new Car();

$query = $all_cars->get_all_cars();

$result = mysqli_query($db_server, $query);
if (!$result) {
    die("Database access failed: " . mysqli_error());
}
$row_count = mysqli_num_rows($result);

echo $search_results = build_item($result, $row_count);

function build_item(&$result, &$row_count) {
    $search_results = "";
    // build object search_item
    for ($j = 0; $j < $row_count; ++$j) {
        $row = mysqli_fetch_array($result); //fetch the next row   
        $search_results.=    
                 "<div class='search_item'>"
                . "<img src='data:" .$row['picture_type'] . ";base64," .base64_encode($row['picture']) . "'>"
                . "<div class='car_make_background'>"
                . "<div class='car_make'>" . $row['Make'] . "</div>"
                . "<div class='car_model'>" . $row['Model'] . " | " . $row['Year'] . "</div>"
                . "</div>" // end make_background
                . "<div class='car_size'>Size: " . $row['Size'] . "</div>"                                
                . "<div class='car_color'>Color: "
                . "<div class='" . $row['Color'] . "'>"
                . "</div>"
                . "</div>" // end car color
                . "<div class='car_rent'>Rent Car</div>" 
                . "</div>"; // end search_item
    }
  //  msqli_free_results; //free up some memory?
    return $search_results;
}

mysqli_close($db_server);


