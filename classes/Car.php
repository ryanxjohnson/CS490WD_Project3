<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Car {

    private $db_connection = null;
    public $errors = array();
    public $messages = array();

    public function __construct() {
        // create a database connection, using the constants from config/db_connection.php (which we loaded in index.php)
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno)
            $this->errors[] = $this->db_connection->error;
    }

    // pre: no params. post: returns all cars
    public function get_all_cars() {
        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.CarSpecsID";
    }

    // pre: need $data from _POST['search_field']
    public function get_cars_by_search($data) {
        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.CarSpecsID 
        WHERE car.status = 1 AND (Make LIKE '%$data%' OR Model LIKE '%$data%'
        OR Year LIKE '%$data%' OR Color LIKE '%$data%' or Size LIKE '%$data%')";
    }

    // pre: no params. car status must be 1
    public function get_available_cars() {
        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.carspecsID WHERE car.status = 1";
    }

    // pre: status = 2
    public function get_rented_cars() {
        return "SELECT carspecs.Make, carspecs.Model, carspecs.Year, carspecs.Size, 
car.Color, car.ID, car.picture, car.picture_type, car.status, 
rental.ID as rentID, rental.rentDate as rentDate, 
rental.returnDate as returnDate, rental.status as rentStatus 
        FROM car 
        INNER JOIN carspecs on carspecs.ID = car.carspecsID 
        INNER JOIN rental on rental.ID = car.ID
        WHERE car.status = 2";
    }

    // pre: post: returns all cars that have been rented, then returned
    public function get_rental_history() {
        return "SELECT carspecs.Make, carspecs.Model, carspecs.Year, carspecs.Size, 
car.Color, car.ID, car.picture, car.picture_type, car.status, 
rental.ID as rentID, rental.rentDate as rentDate, 
rental.returnDate as returnDate, rental.status as rentStatus 
FROM carspecs
INNER JOIN car on car.CarSpecsID = carspecs.ID 
INNER JOIN rental on rental.carID = car.ID 
INNER JOIN customer on rental.CustomerID = customer.ID WHERE car.status= 1";
    }

    // pre: rent button was clicked.
    // parameter: car.ID of the car that button was clicked
    public function update_car_as_rented($ID) {
        return "UPDATE car SET status = 2 WHERE ID = 1";
    }

    // pre: return button was clicked
    // parameter: car.ID of the car that button was clicked
    public function update_car_as_available() {
        return "UPDATE car SET status = 1 WHERE ID = 2";
    }

    // triggered when car status has changed. 
    // when car is returned rental_history updates
    public function update_rental_history() {
        return "";
    }

    /*   */

    //pre: already queried. parameter: query and function
    public function print_results($query, $function) {
        $result = $this->get_result($query);
        $all_results = "";
        for ($j = 0; $j < mysqli_num_rows($result); ++$j) {
            $row = mysqli_fetch_array($result); //fetch the next row 
            $all_results.= $this->$function($row);
        }
        return $all_results;
    }

    // pre: need $query string
    public function get_result($query) {
        $result = mysqli_query($this->db_connection, $query);
        if (!$result) {
            die("Database access failed: " . mysqli_error());
        }
        return $result;
    }

    // pre: parameter is  $row variable TODO: This isn't classy
    // rename to build_available_car($row)
    public function build_searched_car($row) {
        $cars_found = "";
        $cars_found.= "<div class='search_item'>" . "<img src='data:" . $row['picture_type'] . ";base64," . base64_encode($row['picture']) . "'>"
                . "<div class='car_make_background'>" . "<div class='car_make'>" . $row['Make'] . "</div>"
                . "<div class='car_model'>" . $row['Model'] . " | " . $row['Year'] . "</div>" . "</div>" // end make_background
                . "<div class='car_size'>Size: " . $row['Size'] . "</div>" . "<div class='car_color'>Color: "
                . "<div class='" . $row['Color'] . "'>" . "</div>" . "</div>" // end car color
                . "<div class='car_rent'> Rent Car</div>"
                . "</div>"; // end search_item  
        return $cars_found;
    }

    public function build_tainted_car($row) {
        $cars_found = "";
        $current_status = $row['status'];
        if ($current_status == 1) {
            $event = "Returned";
            $show_button = "";
            $x_date = $row['returnDate'];
        } elseif ($current_status == 2) {
            $event = "Rented";
            $show_button = "<div class='return_car'>Return</div>";
            $x_date = $row['rentDate'];
        }

        $y_date=date_create($x_date);//    
        $z_date=date_format($y_date,"l, F d, Y ");
        
        $cars_found.="
                    <tr>
                <td class='img'>
                <img src='data:" . $row['picture_type'] . ";base64," . base64_encode($row['picture']) . "'>
                </td>
                <td class='car_details'>
                    <div>
                        <div class='car_title'>
                            <div class='car_make'>
                                " . $row['Make'] . " | " . $row['Model'] . " 
                                <div class='car_year'>
                                    " . $row['Year'] . "
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='car_size'>
                        Size: " . $row['Size'] . "
                    </div>
                    <div class='rental_ID'>
                        Rental#: " . $row['rentID'] . "
                    </div>
                    <div class='car_date'>
                        " . $event . " Date:  " . $z_date . "
                    </div>
                </td>
                <td>
                   " . $show_button . "
                </td>
            </tr>
        ";

        return $cars_found;
    }

}

// onclick='alert(" . $row['Model'] . ")'
