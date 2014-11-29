<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Register
 *
 * @author Ryan
 */
class Register {
        private $db_connection = null;
 
    public $errors = array();
 
    public $messages = array();

    public function __construct(){
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    private function registerNewUser()
    {
                if($this->validate_fields())
            {
                
                // TODO: Move db connection to constructor (or superclass)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
            if (!$this->db_connection->connect_errno) {
                
                
// refactor set_fields() aka dump_POST
                $user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
                $name = $this->db_connection->real_escape_string(strip_tags($_POST['name'], ENT_QUOTES));
                $phone_number = $this->db_connection->real_escape_string(strip_tags($_POST['phone_number'], ENT_QUOTES));
                $address = $this->db_connection->real_escape_string(strip_tags($_POST['address'], ENT_QUOTES));
                $user_password = $_POST['user_password_new'];
                $user_password_hash = md5($user_password); //password_hash($user_password, PASSWORD_DEFAULT);

                $sql = "SELECT * FROM customer WHERE ID = '" . $user_name . "';";
                $query_check_user_name = $this->db_connection->query($sql);

                
                if ($query_check_user_name->num_rows == 1) {
                    $this->errors[] = "Sorry, that username / email address is already taken.";
                } else {
                    // write new user's data into database             
                    $sql = "INSERT INTO `customer` (ID, Name, Password, phone, address)
                            VALUES('" . $user_name . "', '" .$name . "' , '" . $user_password_hash . "', '" .$phone_number . "' , '" . $address . "');";

                    $query_new_user_insert = $this->db_connection->query($sql);
                    
                    if ($query_new_user_insert) {
                        // if user has been added successfully
                        $this->messages[] = "account has been created successfully.";
                    } else {
                        $this->errors[] = "registration failed.";
                    }
                }
            } else {
                $this->errors[] = "no database connection.";
            }
        } else {
            $this->errors[] = "unknown error occurred.";
        }
    }
    
    public function validate_fields() {
                   if (!empty($_POST['user_name'])
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        )
                       return true;      
        
    }
    
        public function sanitizeString($var) {

        if (get_magic_quotes_gpc()) //get rid of unwanted slashes using magic_quotes_gpc
            $var = stripslashes($var);

        $var = htmlentities($var, ENT_COMPAT, 'UTF-8'); //get rid of html entities e.g. &lt;b&gt;hi&lt;/b&gt; = <b>hi</b>
        $var = strip_tags($var); //get rid of html tags e.g. <b>
        return $var;
    }

    public function sanitizeMYSQL($var) {
        $var = mysqli_real_escape_string($this->db_connection,$var); //Escapes special characters in a string for use in an SQL statement
        $var = $this->sanitizeString($var);
        return $var;
    }
}
