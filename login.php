<?php
require_once 'db.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $logonSuccess = (carDB::getInstance()->verify_authentication($_POST['name'], $_POST['password']));
if ($logonSuccess == true) {
        session_start();
        $_SESSION['user'] = $_POST['user'];
        header('Location: cars.php');
        exit;
    }    
    
}











?>

