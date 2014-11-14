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

        if (!$this->db_connection->connect_errno);
    } // end constructor
   

    // pre: no params.
    public function get_all_cars() {
        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.CarSpecsID";
    }
    
    // pre: need $data from _POST['search_field']
    public function get_cars_by_search($data) {
    return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.CarSpecsID 
        WHERE Make LIKE '%$data%' OR Model LIKE '%$data%'
        OR Year LIKE '%$data%' OR Color LIKE '%$data%' or Size LIKE '%$data%' ";
    }

    // pre: carID 
    // TODO: JOIN car and carspec
    public function get_cars_by_car_id($carID) {
        return $this->query("SELECT ID, Make, Model FROM carspecs WHERE carspecs.ID=" . $carID);
    }

    // pre: customer.Name
    public function get_customer_id_by_name($name) {
        $name = $this->real_escape_string($name);
        $car = $this->query("SELECT ID FROM customer WHERE Name = '"
                . $name . "'");

        if ($car->num_rows > 0) {
            $row = $car->fetch_row();
            return $row[0];
        } else
            return null;
    }

    // pre: rent button was clicked
    public function updated_car_rented() {
        return "UPDATE car SET status = 2 WHERE ID = 1";
    }
    
      // pre: return button was clicked
    public function updated_car_available() {
        return "UPDATE car SET status = 1 WHERE ID = 2";
    }

    // pre: no params. car status must be 1
    public function get_available_cars() {
        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.ID WHERE car.status = 1";
    }

    // pre: status = 2
    public function get_rented_cars() {
        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.ID WHERE car.status = 2";
    }

}
