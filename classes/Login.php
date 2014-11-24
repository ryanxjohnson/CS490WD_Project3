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

        // start the database connection... is it bad to connect here?
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }
        if (isset($_GET["logout"])) {
            $this->Logout();
        } elseif (isset($_POST["login"])) {
            $this->loginWithPostData();
        }
    }

    private function loginWithPostData() {
        if ($this->validate_form() == true) {
            if (!$this->db_connection->connect_errno) {

                // dump the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);
                $user_password_hash = md5($_POST['user_password']);

                $query = $this->get_user_by_username($user_name);
                $result_for_login_check = //$this->get_result($query);
                        
                        $this->db_connection->query($query);

                // if the user exists in db
                if ($result_for_login_check->num_rows == 1) {

                    $row = $result_for_login_check->fetch_object();

                    // load SESSION variable so we know who does stuff
                    if ($user_password_hash == $row->Password) {
                        $_SESSION['user_name'] = $row->ID;
                        $_SESSION['name'] = $row->Name;
                        $_SESSION['user_login_status'] = 1;
                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } 
                
                else {
                    $this->errors[] = "This user does not exist.";
                }
            } 
            else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }

    
    public function Logout() {
        // delete the session of the user
        $_SESSION = array();
                if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        $this->messages[] = "You have been logged out.";
    }

    public function isUserLoggedIn() {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        return false;
    }
//    function is_session_active() {
//        return isset($_SESSION) && count($_SESSION) > 0;
//    }
    
    

    // pre: need userID
    public function get_user_by_username($user_name) {
        return "SELECT ID, Name, Password
                        FROM customer
                        WHERE ID = '" . $user_name . "'";
    }

    public function validate_form() {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            return true;
        }
        return false;
    }
    
 
            // pre: need $query string
    public function get_result($query) {
        $result = mysqli_query($this->db_connection, $query);
        if (!$result) {
            die("Database access failed: " . mysqli_error());
        }
        return $result;
    }
  

}
