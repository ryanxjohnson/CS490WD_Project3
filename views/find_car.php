<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '/../connection_old.php';
$query = "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.carspecsID";

/*
 * 
 * if (isset($_POST['search']) && trim($_POST['search'])!=""){ // trim spaces and make sure not empty
 * $data=$_POST['search'];
 * }
 * $query = "SELECT * 
 *      FROM car INNER JOIN carspecs on carspecs.ID = car.carspecsID
 *          WHERE car_make like '%data%' OR car_model like '%data%'";
 */

$result = mysqli_query($db_server, $query);

if (!$result) {
    die("Database access failed: " . mysqli_error());
}
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


