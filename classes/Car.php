<?php

class Car {

    private $db_connection = null;
    public $errors = array();
    public $messages = array();

    public function __construct() {
        // create a database connection, using the constants from config/db_connection.php (which we loaded in index.php)
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }

        if (!$this->db_connection->connect_errno)
            $this->errors[] = $this->db_connection->error;
        
    }

    /*     * *** SELECT SQL STATEMENTS **** */

    // pre: no params. post: returns all cars
    public function get_all_cars() {
        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.CarSpecsID";
    }

    // pre: need $data from _POST['search_field']
    public function get_cars_by_search($data) {
        $words = $this->tokenize($data, " ");
        $LIKE = "";
        $LIKE.=$this->LIKE("Make", $words);
        $LIKE.=" OR " . $this->LIKE("Model", $words);
        $LIKE.=" OR " . $this->LIKE("Color", $words);
        $LIKE.=" OR " . $this->LIKE("Size", $words);
        $LIKE.=" OR " . $this->LIKE("Year", $words);
        
        $order_by=" ORDER BY Year ";
        $order_by=$this->check_order_by();
        
        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.CarSpecsID 
        WHERE car.status = 1 AND ($LIKE) $order_by";

//        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.CarSpecsID 
//        WHERE car.status = 1 AND (Make LIKE '%$data%' OR Model LIKE '%$data%'
//        OR Year LIKE '%$data%' OR Color LIKE '%$data%' or Size LIKE '%$data%')";
    }

    // pre: no params. car status must be 1
    public function get_available_cars() {
        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.carspecsID WHERE car.status = 1";
    }

    // pre: status = 2
    public function get_rented_cars() {
        return "SELECT carspecs.Make, carspecs.Model, carspecs.Year, carspecs.Size, 
                car.Color, car.ID as carID, car.picture, car.picture_type, car.status, 
                rental.ID as rentID, rental.rentDate as rentDate, 
                rental.returnDate as returnDate, rental.status as rentStatus 
                FROM car 
                INNER JOIN carspecs on carspecs.ID = car.carspecsID 
                INNER JOIN rental on rental.ID = car.ID
                WHERE car.status = 2";
    }

    // pre: post: returns all cars that have been rented, then returned
    public function get_rental_history() {
        return "SELECT carspecs.Make, carspecs.Model, carspecs.Year, carspecs.Size, 
                car.Color, car.ID as carID, car.picture, car.picture_type, car.status, 
                rental.ID as rentID, rental.rentDate as rentDate, 
                rental.returnDate as returnDate, rental.status as rentStatus 
                FROM carspecs
                INNER JOIN car on car.CarSpecsID = carspecs.ID 
                INNER JOIN rental on rental.carID = car.ID 
                INNER JOIN customer on rental.CustomerID = customer.ID WHERE car.status= 1 ORDER BY rentID";
    }

    /*     * *** UPDATE SQL STATEMENTS **** */

    // pre: rent button was clicked.
    // parameter: car.ID of the car that button was clicked
    public function update_car_as_rented($ID) {
        return "UPDATE car SET status = 2 WHERE ID = $ID";
    }

    // pre: return button was clicked
    // parameter: car.ID of the car that button was clicked
    public function update_car_as_available($ID) {
        return "UPDATE car SET status = 1 WHERE ID = $ID";
    }

    // triggered when car status has changed. 
    // when car is returned rental_history updates
    public function update_rental_history() {
        return "";
        //date($format, $timestamp);
    }

    /*     * *** HELPER FUNCTIONS FOR VIEWS  **** */

    // Determine which html function to use by query and function
    //pre: already queried with instantiated object. 
    //parameters: query string and function
    public function print_results($query, $function) {
        $result = $this->get_result($query);
        $all_results = "";
        for ($j = 0; $j < mysqli_num_rows($result); ++$j) {
            $row = mysqli_fetch_array($result); //fetch the next row 
            $all_results.= $this->$function($row);
        }
        return $all_results;
    }

    // pre: need $query string
    public function get_result($query) {
        $result = mysqli_query($this->db_connection, $query);
        if (!$result) {
            die("Database access failed: " . mysqli_error());
        }
        return $result;
    }

    /*     * *** VIEW METHODS **** */

    // pre: checks the value in the seach field variable. This is probably bad form to access POST like this.
    // post: returns query as string
    public function search_field_check() {
        //$data=$_POST['search_field'];
        
        if (isset($_POST['search_field']) && trim($_POST['search_field']) != "") { 
            echo "Showing results for the search '" . $_POST['search_field'] . "'";
            return $this->get_cars_by_search($_POST['search_field']);
        } elseif (!isset($_POST['search_field']) || trim($_POST['search_field']) == "" || trim($_POST['search_field']) == null) {
            echo "empty search returns all results";
            return $this->get_available_cars();
        }
    }

    public function selector(){
        return 
        "<form method='post'>
           <select id='sortby' name='sortby'>
           <option value=''>Sort By</option>
           <option value='Make'>Make</option>
           <option value='Year'>Year</option>
           </select>
           <input type='submit' value='Sort'>
        </form>";
    }

    public function check_order_by() {
        //$order_by=$_POST["sortby"];       
        
        if (isset($_POST["sortby"]) && $_POST["sortby"] != "") {
            return $order_by.=" ORDER BY " . $_POST["sortby"];
        } else {
            return $order_by = "";
        }
    }

    /*     * *** HTML BUILDERS DYNAMIC VIEWS  **** */

    // Builds html for Find Car
    // pre: parameter is  $row variable
    public function build_searched_car($row) {
        $cars_found = "";
        echo $cars_found.=" 
        <div class='search_item'>
            <img src='data:" . $row['picture_type'] . ";base64," . base64_encode($row['picture']) . "'>
                 <div class='car_make_background'>
                <div class='car_make'>" . $row['Make'] . "
                </div>
                <div class='car_model'>" . $row['Model'] . " | " . $row['Year'] . "
                </div>
            </div> 
            <div class='car_size'>Size: " . $row['Size'] . "
            </div>
            <div class='car_color'>Color: 
                <div class='" . $row['Color'] . "'> 
            </div> 
        </div>
        <div class='car_rent' onclick='show_message()';'" 
                . $this->update_car_as_rented($row['ID']) . "';> Rent Car
        </div>
    </div>";
    }

    // builds html for Rented Cars and Rental History
    public function build_tainted_car($row) {
        $cars_found = "";
        $current_status = $row['status'];
        if ($current_status == 1) {
            $event = "Returned";
            $show_button = "";
            $x_date = date_create($row['returnDate']);
        } elseif ($current_status == 2) {
            echo "Showing all rented vehicles. Click 'Return Car' to return a vehicle to inventory";
            $event = "Rented";
            $show_button = "<td><div class='return_car' onclick='show_message()';" 
                    . $this->update_car_as_available($row['carID']) ."'>Return</div></td>";
            $x_date = date_create($row['rentDate']);
        }

        $z_date = date_format($x_date, "l, F d, Y "); // format the date to display

        echo $cars_found.="
            <tr>
                <td class='img'>
                <img src='data:" . $row['picture_type'] . ";base64," . base64_encode($row['picture']) . "'>
                </td>
                <td class='car_details'>
                    <div>
                        <div class='car_title'>
                            <div class='car_make'>
                                " . $row['Make'] . " | " . $row['Model'] . " 
                                <div class='car_year'>
                                    " . $row['Year'] . "
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='car_size'>
                        Size: " . $row['Size'] . "
                    </div>
                    <div class='rental_ID'>
                        Rental#: " . $row['rentID'] . "
                    </div>
                    <div class='car_date'>
                        " . $event . " Date:  " . $z_date . "
                    </div>
                </td>
                   " . $show_button . "                
            </tr>";
    }
    
    
    /***** TOKENIZE SEARCH *****/
    
    function LIKE($column,$words){
    $LIKE="";
    $index=0;
    foreach($words as $word){
        if($index>0) //the first time we don't want to add LIKE
        $LIKE.=" OR ";
        
        $LIKE.=" $column LIKE '%$word%' ";  
        $index++;
    }
    return $LIKE;
}

function tokenize($data,$delimiter=","){

    $array = array();
    $token = strtok($data, $delimiter);
    while($token!==false){
        array_push($array,$token);
         $token = strtok($delimiter);
    }
return $array;
}

}
