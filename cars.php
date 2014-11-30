<?php

//include "config/db_connection.php";
include "connection.php";
session_start();
if (isset($_POST['type']) && is_session_active()) {
    $type = $_POST['type'];
    //var_dump($_POST);die;
    switch ($type) {
        case "search_field":
            //echo $search=$_POST['search_field'];
            break;
        case "name":
            echo $name = $_SESSION["real_name"];
            break;
        case "search_results":
            include("views/find_car.php");
            break;
        case "rented_cars":
            require_once("views/rented_cars.php");
            break;
        case "returned_cars":
            include("views/rental_history.php");
            break;
        case "logout":
            logout();
            echo "success";
            break;
        case "rent":
            $car_id = $_POST['car_id'];
            $car_spec_id = $_POST['car_spec_id'];
            $result = update_car_status($car_id, $car_spec_id, $db_server);
            if ($result) {
                create_rental_record($car_id, $db_server);
                echo "success";
            }
            break;
        case "return":
            $car_id = $_POST['car_id'];
            $car_spec_id = $_POST['car_spec_id'];
            $result = update_rental_record($car_id, $car_spec_id, $db_server);
            if ($result) {
                echo "success";
            }
            break;
    }
}

function is_session_active() {
    return isset($_SESSION) && count($_SESSION) > 0;
}

function logout() {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}

// gets the highest ID since the key isn't auto incrementing
function get_max_rental_id($db_server) {
    $query3 = "SELECT MAX(CAST(rental.ID as UNSIGNED)) as max FROM rental;";
    $result3 = mysqli_query($db_server, $query3);
    $row = mysqli_fetch_array($result3);
    $id = $row['max'];
    $next_id = $id + 1;
    return $next_id;
}

function update_car_status($car_id, $car_spec_id, $db_server) {
    $query = "UPDATE car 
                INNER JOIN carspecs ON carspecs.ID = car.CarSpecsID
                SET car.status='2' 
                WHERE car.ID='$car_id' AND carspecs.ID='$car_spec_id'";
    $result = mysqli_query($db_server, $query);
    return $result;
}

function create_rental_record($car_id, $db_server) {
    $next_id = get_max_rental_id($db_server);
    $query2 = "INSERT INTO cars.rental (ID, rentDate, returnDate, status, CustomerID, carID) 
	VALUES ('$next_id', '".date("Y-m-d")."', 0000-01-01, 2, '" . $_SESSION["username"] . "', '$car_id');";
    $result = mysqli_query($db_server, $query2);
}

function update_rental_record($car_id, $car_spec_id, $db_server) {
    $query = "UPDATE rental 
INNER JOIN car on car.ID = rental.carID
 INNER JOIN carspecs on carspecs.ID = car.carspecsID 
                SET rental.status='1', rental.returnDate='".date("Y-m-d")."', car.status='1'
                WHERE car.ID='$car_id' AND car.carspecsID='$car_spec_id' AND rental.CustomerID='" . $_SESSION["username"] . "' ;";
    $result = mysqli_query($db_server, $query);
    return $result;
}

function get_current_status($car_id, $car_spec_id, $db_server) {
    $query = "select car.ID, carspecs.ID, car.status, rental.carID from car
                INNER JOIN carspecs on carspecs.ID = car.carspecsID 
                INNER JOIN rental on rental.ID = car.ID
WHERE car.ID = '$car_id' AND carspecs.ID = '$car_spec_id';";
    $result = mysqli_query($db_server, $query);
    return $result;
}
