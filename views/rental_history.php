<?php

require_once("/../classes/Car.php");

$rental_history = new Car();

$query = $rental_history->get_rental_history();
echo $rental_history_results = $rental_history->print_results($query, "build_tainted_car"); //function build_tainted_car

//$result = $rental_history->get_result($query);
//$returned_cars_found = "";
//while ($row = mysqli_fetch_array($result)) {
//    $returned_cars_found.="
//                    <tr>
//                <td class='img'>
//                <img >
//                    </td>
//                <td class='car_details'>
//                    <div>
//                        <div class='car_title'>
//                            <div class='car_make'>
//                               A Car
//                                <div class='car_year'>
//                                    Year
//                                </div>
//                            </div>
//                        </div>
//                    </div>
//                    <div class='car_size'>
//                        Size
//                    </div>
//                    <div class='rental_ID'>
//                        Rental#:  
//                    </div>
//                    <div class='car_date'>
//                        Rent Date: today
//                    </div>
//                </td>
//                <td>
//                    <div class='return_car'>Return</div>
//                </td>
//            </tr>
//        ";
//}
//echo $returned_cars_found;





//$rental_history_view = "Rental History View";
//?>


