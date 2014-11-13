<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Car {

    //private $db_connection = null;

    public $errors = array();

    public $messages = array();
    
    
   
    
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
    
    // status = 1
    public function get_available_cars() {
        
    }
    
    // status = 2
    public function get_rented_cars(){
        
    }
}
