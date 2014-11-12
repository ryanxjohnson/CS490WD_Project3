<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '/../connection.php';

$query = "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.carspecsID";
//$query = carDB::getInstance();

$result = mysqli_query($db_server, $query);

if (!$result) {
    die("Database access failed: " . mysqli_error());
}
//$find_car_view = "Find Car View";
//$search_results="";

$row_count = mysqli_num_rows($result);

$search_results = build_item($result, $row_count);

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
?>

