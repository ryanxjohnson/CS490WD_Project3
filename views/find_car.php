<?php

require_once("/../config/db_connection.php");
require_once("/../classes/Car.php");

$search_available_cars = new Car();

$search_results = "";
if (isset($_POST['search_field']) && trim($_POST['search_field']) != "") {
    $data = $_POST['search_field'];
    $query = $search_available_cars->get_cars_by_search($data);
    
    $result = mysqli_query($db_server, $query);
    if (!$result) {
        die("Database access failed: " . mysqli_error());
    }
    $row_count = mysqli_num_rows($result);

    echo $search_results = build_found_cars($result, $row_count);
}

function build_found_cars(&$result, &$row_count) {
    $cars_found = "";
    // build object search_item
    for ($j = 0; $j < $row_count; ++$j) {
        $row = mysqli_fetch_array($result); //fetch the next row   
        $cars_found.=
                "<div class='search_item'>"
                . "<img src='data:" . $row['picture_type'] . ";base64," . base64_encode($row['picture']) . "'>"
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
    return $cars_found;
}

mysqli_close($db_server);
?>