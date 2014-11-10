<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'connection.php';
require_once("db.php");

$query = "SELECT * FROM car";
$result = mysqli_query($db_server, $query);

if (!$result) {
    die("Database access failed: " . mysqli_error());
}
    
$search_results="";

$row_count = mysqli_num_rows($result);

    for ($j = 0; $j < $row_count; ++$j) {
        $row = mysqli_fetch_array($result); //fetch the next row     
        $search_results.="<p>" . $row['ID'] . $row['Color'] . "</p>";
    }





$logonSuccess = false;

// verify user's credentials
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $logonSuccess = (carDB::getInstance()->verify_authentication($_POST['name'], $_POST['password']));
    if ($logonSuccess == true) {
        session_start();
        $_SESSION['name'] = $_POST['name'];
        header('Location: cars.php');
        exit;
    }
}







mysqli_close($db_server);
?>
