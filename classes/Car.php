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

    // pre: no params.
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
        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.carspecsID WHERE car.status = 2";
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

    // pre: what do we need
    public function get_rental_history() {
        return "SELECT * FROM rental";
    }
    
    public function update_rental_history() {
        
    }
    
    public function print_results($query, $object) {
        $result = $object->get_result($query);
        $all_results = "";
        for ($j = 0; $j < mysqli_num_rows($result); ++$j) {
            $row = mysqli_fetch_array($result); //fetch the next row 
            $all_results.= $object->build_car($row);
        }
        return $all_results;
    }
    
    public function print_rental_history() {
        
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
    public function build_car($row) {
        $cars_found = "";
        $current_status = $row['status'];
        if ($current_status == 1) {
            $event = "Rent";
        } elseif ($current_status == 2) {
            $event = "Return";
        }
        $cars_found.= "<div class='search_item'>" . "<img src='data:" . $row['picture_type'] . ";base64," . base64_encode($row['picture']) . "'>"
                . "<div class='car_make_background'>" . "<div class='car_make'>" . $row['Make'] . "</div>"
                . "<div class='car_model'>" . $row['Model'] . " | " . $row['Year'] . "</div>" . "</div>" // end make_background
                . "<div class='car_size'>Size: " . $row['Size'] . "</div>" . "<div class='car_color'>Color: "
                . "<div class='" . $row['Color'] . "'>" . "</div>" . "</div>" // end car color
                . "<div class='car_rent'>" . $event . " Car</div>" 
                . "</div>"; // end search_item  
        return $cars_found;
    }

}
// onclick='alert(" . $row['Model'] . ")'