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
    
        public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    

    // pre: $id
    public function get_all_cars() {
        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.ID";
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

    public function update_status() {
        
    }

    // status = 1
    public function get_available_cars() {
        
    }

    // status = 2
    public function get_rented_cars() {
        
    }

}
