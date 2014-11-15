<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login {
    private $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct() {
        session_start();
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    private function dologinWithPostData() {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            //TODO: Move db connection to constructor (or superclass)
            // create a database connection, using the constants from config/db_connection.php (which is loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
            if (!$this->db_connection->connect_errno) {

                // dump the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);
                $sql = $this->get_user_by_id($user_name);                
                $result_of_login_check = $this->db_connection->query($sql);

                // if the user exists in db
                if ($result_of_login_check->num_rows == 1) {
                    $result_row = $result_of_login_check->fetch_object();

                    $user_password_hash = md5($_POST['user_password']);
                    
                    if ( $user_password_hash == $result_row->Password) {
                    $_SESSION['user_name'] = $result_row->ID;
                        $_SESSION['name'] = $result_row->Name;
                        
                        $_SESSION['user_login_status'] = 1;
                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }

    /**
     * perform the logout
     */
    public function doLogout() {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        $this->messages[] = "You have been logged out.";
    }


    public function isUserLoggedIn() {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        return false;
    }
    
    // pre: need userID
    public function get_user_by_id($user_name) {
        return "SELECT ID, Name, Password
                        FROM customer
                        WHERE ID = '" . $user_name . "'";
    }

}
