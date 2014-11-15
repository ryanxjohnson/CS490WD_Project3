<?php
require_once("/../classes/Car.php");

$rental_history = new Car();

//$query = $rental_history->get_rental_history();
//$rental_history_results = $rental_history->print_results($query, $rental_history);

$rental_history_view = "Rental History View";

?>

<html>
    <head>
        
    </head>
    
    <body>
        <div class="search_item">        
            Rental History View
        <?php
        $rental_history_view;
        ?>
        </div>
        
    </body>
    
    
</html>

