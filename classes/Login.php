<?php 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author Ryan
 */
//class Login {
//
//    private $db_connection = null;
//    public $errors = array();
//    public $messages = array();
//
//    public function __construct() {
//        session_start();
//        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
//        if (!$this->db_connection->set_charset("utf8")) {
//            $this->errors[] = $this->db_connection->error;
//        }
//        if (isset($_GET["logout"])) {
//            $this->logout();
//        } elseif (isset($_POST["login"])) {
//            $this->login_with_post();
//        }
//    }
//
//    private function login_with_post() {
//        if ($this->validate_form() == true) {
//            $username = sanitizeMYSQL($_POST['name']);
//            $password=md5(sanitizeMYSQL($_POST['password']));
//            $query = $this->get_user_by_username($username);
//            $result = $this->db_connection->query($query);
//            $text="";
//            if ($result->num_rows == 1) {
//                $row = $result->fetch_object();
//
//                if ($password == $row->Password) {
//                    ini_set('session.gc_maxlifetime', 60 * 5); //the life time of the session is 5 minutes
//                    $_SESSION['user_name'] = $row->ID;
//                    $_SESSION['name'] = $row->Name;
//                    $_SESSION['user_login_status'] = 1;
//                     $text="success";
//                } // else wrong password
//            }  //else no user
//        }// else form invalid
//    }
//
//    // pre: need userID
//    public function get_user_by_username($username) {
//        return "SELECT ID, Name, Password
//                        FROM customer
//                        WHERE ID = '" . $username . "'";
//    }
//
//    // could call from index.html?
//    public function isUserLoggedIn() {
//        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
//            return true;
//        }
//        return false;
//    }
//
//    function is_session_active() {
//        return isset($_SESSION) && count($_SESSION) > 0;
//    }
//
//    public function logout() {
//        // delete the session of the user
//        $_SESSION = array();
//        if (ini_get("session.use_cookies")) {
//            $params = session_get_cookie_params();
//            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
//            );
//        }
//        session_destroy();
//        $this->messages[]= "You have been logged out.";
//    }
//
//    public function validate_form() {
//        // check login form contents
//        if (empty($_POST['user_name'])) {
//            $this->errors[] = "Username field was empty.";
//        } elseif (empty($_POST['user_password'])) {
//            $this->errors[] = "Password field was empty.";
//        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {
//
//            return true;
//        }
//        return false;
//    }
//
//    // pre: need $query string
//    public function get_result($query) {
//        $result = mysqli_query($this->db_connection, $query);
//        if (!$result) {
//            die("Database access failed: " . mysqli_error());
//        }
//        return $result;
//    }
//
//    public function sanitizeString($var) {
//
//        if (get_magic_quotes_gpc()) //get rid of unwanted slashes using magic_quotes_gpc
//            $var = stripslashes($var);
//
//        $var = htmlentities($var, ENT_COMPAT, 'UTF-8'); //get rid of html entities e.g. &lt;b&gt;hi&lt;/b&gt; = <b>hi</b>
//        $var = strip_tags($var); //get rid of html tags e.g. <b>
//        return $var;
//    }
//
//    public function sanitizeMYSQL($var) {
//        $var = mysqli_real_escape_string($this->db_connection,$var); //Escapes special characters in a string for use in an SQL statement
//        $var = $this->sanitizeString($var);
//        return $var;
//    }
//
//}
