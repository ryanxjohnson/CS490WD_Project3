<?php

require_once 'connection.php';
include "sanitization.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * ID
 * Username
 * Full Name
 * 
 */

//if (isset($_POST['id'])) {
    $id = isset($_POST['id']) ? sanitizeMYSQL($_POST['id']) : "";
    
    $password = isset($_POST['password']) ? sanitizeMYSQL($_POST['password']) : "";
    $salt = "web";
    $encoded_password = $salt . md5($password) . $salt;
    $fname = isset($_POST['fname']) ? sanitizeMYSQL($_POST['fname']) : "";
    
    $SQL = "INSERT INTO customer (ID, Name, Password)
            VALUES('". $id . "', '". $fname . "', '". $encoded_password . "')";
    

    
    $result = mysqli_query($db_server,$SQL);
    
    echo "success";
    
//    if ($result) {
//    $return = $_POST;
//    $return["json"] = json_encode($messages);
//    echo json_encode($messages);
//    }
  
//}