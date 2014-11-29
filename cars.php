<?php

//include "config/db_connection.php";
include "connection.php";
session_start();
if (isset($_POST['type'])) {// && is_session_active()) {
    $type = $_POST['type'];
    $name = $_SESSION["real_name"];

    switch ($type) {
        case "name":
            echo $name;
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
            $query = "UPDATE car 
                INNER JOIN carspecs ON carspecs.ID = car.CarSpecsID
                SET car.status='2'
                WHERE car.ID='$car_id' AND carspecs.ID='$car_spec_id'";
            $result = mysqli_query($db_server, $query);
            if ($result) {
                echo "success";
            }
            break;
        case "return":
            $car_id = $_POST['car_id'];
            $car_spec_id = $_POST['car_spec_id'];
            $query = "UPDATE car 
                INNER JOIN carspecs ON carspecs.ID = car.CarSpecsID
                SET car.status='1'
                WHERE car.ID='$car_id' AND carspecs.ID='$car_spec_id';";
            $result = mysqli_query($db_server, $query);
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
    // delete the session of the user
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}
