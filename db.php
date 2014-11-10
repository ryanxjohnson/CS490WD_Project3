<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class carDB extends mysqli {

    private static $instance = null;
    private $db_hostname = 'localhost';
    private $db_database = "cars";
    private $db_username = "root";
    private $db_password = "";

        //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
        // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    private function __construct() {
        parent::__construct($this->$db_hostname, $this->$db_username, $this->$db_password, $this->$db_database);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }
    
    // pre: username, password
    public function verify_authentication(){
        
    }
    
    // pre: $id
    public function get_all_cars(){
        return $this->query("SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.ID");
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

        if ($car->num_rows > 0){
            $row = $car->fetch_row();
            return $row[0];
        } else
            return null;
    }
    
    public function update_status(){
        
    }
    
}
