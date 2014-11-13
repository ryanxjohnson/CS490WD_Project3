<?php

/**
 * Class registration
 * handles the user registration
 */
class Registration
{

    private $db_connection = null;
 
    public $errors = array();
 
    public $messages = array();

    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    private function registerNewUser()
    {
       
//        if (empty($_POST['user_name'])) {
//            $this->errors[] = "Empty Username";
//        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
//            $this->errors[] = "Empty Password";
//        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
//            $this->errors[] = "Password and password repeat are not the same";
//        } elseif (strlen($_POST['user_password_new']) < 6) {
//            $this->errors[] = "Password has a minimum length of 6 characters";
//        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
//            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
//        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
//            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
//        } elseif (empty($_POST['user_email'])) {
//        } else
            
            if (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) 
            {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
            if (!$this->db_connection->connect_errno) {

                $user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
                $name = $this->db_connection->real_escape_string(strip_tags($_POST['name'], ENT_QUOTES));
                $phone_number = $this->db_connection->real_escape_string(strip_tags($_POST['phone_number'], ENT_QUOTES));
                $address = $this->db_connection->real_escape_string(strip_tags($_POST['address'], ENT_QUOTES));
                $user_password = $_POST['user_password_new'];
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

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
}
