<?php
require_once("/../classes/Car.php");

$rental_history = new Car();

$query = $rental_history->get_rental_history();
//$rental_history_results = $rental_history->print_results($query, $rental_history);

$result=$rental_history->get_result($query);

while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>" . $row['CustomerID'] . " " . "</td>";
                 echo "<td>" . $row['carID'] . " "  . "</td>";
                  echo "<td>" . $row['status'] . " "  . "</td>";
                echo "<td>" . $row['rentDate'] . " "  . "</td>";
                echo "<td>" . $row['returnDate'] . " "  . "</td></tr><br>";
            }
            
            
$rental_history_view = "Rental History View";

?>

<html>
    <head>
        
    </head>
    
    <body>
        <div class="search_item">
        <?php
        //echo $rental_history_view;
        ?>
        </div>
        
    </body>
    
    
</html>

