<?php 
  $db_hostname = 'localhost';
  $db_database = "cars";
  $db_username = "root";
  $db_password = "";
  
  $db_server = mysqli_connect($db_hostname, $db_username,$db_password);
mysqli_select_db($db_server,$db_database) or die("Unable to select db: " . mysqli_errno());

if (!$db_server)
    die("Unable to connect to MySQL: " . mysqli_error());
?>

