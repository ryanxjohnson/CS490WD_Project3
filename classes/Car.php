<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Car
 *
 * @author Ryan
 */
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

        if (!$this->db_connection->connect_errno) {
            $this->errors[] = $this->db_connection->error;
        }
    }

    /* SQL STATEMENTS */

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

        $order_by = " ORDER BY Year ";
        //$order_by = $this->check_order_by();

        return "SELECT * FROM car INNER JOIN carspecs on carspecs.ID = car.CarSpecsID 
        WHERE car.status = 1 AND ($LIKE) $order_by";
    }

    // pre: no params. car status must be 1
    public function get_available_cars() {
                return "SELECT car.CarSpecsID as carspecsID, carspecs.Make, carspecs.Model, carspecs.Year, carspecs.Size, 
                car.Color, car.ID as carID, car.picture, car.picture_type, car.status as carStatus, 
                rental.ID as rentID, rental.rentDate as rentDate, 
                rental.returnDate as returnDate, rental.status as rentStatus 
                FROM car 
                INNER JOIN carspecs on carspecs.ID = car.carspecsID 
                INNER JOIN rental on rental.ID = car.ID
                WHERE car.status= 1";
    }

    // pre: status = 2
    public function get_rented_cars() {
        return "SELECT car.CarSpecsID as carspecsID, carspecs.Make, carspecs.Model, carspecs.Year, carspecs.Size, 
                car.Color, car.ID as carID, car.picture, car.picture_type, car.status as carStatus, 
                rental.ID as rentID, rental.rentDate as rentDate, 
                rental.returnDate as returnDate, rental.status as rentStatus 
                FROM car 
                INNER JOIN carspecs on carspecs.ID = car.carspecsID 
                INNER JOIN rental on rental.ID = car.ID
                WHERE car.status= 2";
    }

    // pre: post: returns all cars that have been rented, then returned
    public function get_rental_history() {
        return "SELECT carspecs.Make, carspecs.Model, carspecs.Year, carspecs.Size, 
                car.Color, car.ID as carID, car.picture, car.picture_type, car.status as carStatus, car.CarSpecsID as carspecsID, 
                rental.ID as rentID, rental.rentDate as rentDate, 
                rental.returnDate as returnDate, rental.status as rentStatus 
                FROM carspecs
                INNER JOIN car on car.CarSpecsID = carspecs.ID 
                INNER JOIN rental on rental.carID = car.ID 
                INNER JOIN customer on rental.CustomerID = customer.ID 
                WHERE car.status= 1 ORDER BY rentID";
    }

    /*     * *** UPDATE SQL STATEMENTS **** */

    // pre: rent button was clicked.
    // parameter: car.ID of the car that button was clicked
    public function update_car_as_rented($carID, $carspecsID) {
        $query = "UPDATE car 
                INNER JOIN carspecs ON carspecs.ID = car.CarSpecsID
                SET car.status='2'
                WHERE car.ID='$carID' AND carspecs.ID='$carspecsID';";
        $this->get_result($query);
    }

    // pre: return button was clicked
    // parameter: car.ID of the car that button was clicked
    public function update_car_as_available($carID, $carspecsID) {
        $query = "UPDATE car 
                INNER JOIN carspecs ON carspecs.ID = car.CarSpecsID
                SET car.status='1'
                WHERE car.ID='$carID' AND carspecs.ID='$carspecsID';";
        $this->get_result($query);
    }

    // triggered when car status has changed. 
    // when car is returned rental_history updates
    public function update_rental_history() {
        return "";
        //date($format, $timestamp);
    }

    /* QUERY HELPERS */

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

    /* CHECK HELPERS */

    // pre: checks the value in the seach field variable. This is probably bad form to access POST like this.
    // post: returns query as string
    public function search_field_check() {
        //   $data=$_POST['search_field'];

        if (isset($_POST['search_field']) && trim($_POST['search_field']) != "") {
            echo "Showing results for the search '" . $_POST['search_field'] . "'";
            return $this->get_cars_by_search($_POST['search_field']);
        } elseif (!isset($_POST['search_field']) || trim($_POST['search_field']) == "" || trim($_POST['search_field']) == null) {
            echo "empty search returns all results";
            return $this->get_available_cars();
            //return $this->get_cars_by_search($_POST['search_field']);
        }
    }

    /* HTML BUILDERS */

    // Builds html for search_results
    // pre: parameter is $row variable
    public function build_searched_car($row) {
        $cars_found = "";
        $car_id=$row['carID'];
        $car_spec_id=$row['carspecsID'];
//        $car_id = 9;
//        $car_spec_id = 4; 
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
        <div id='rent' class='car_rent' onclick='rent_car(" . $car_id . "," . $car_spec_id . ")'> Rent Car
        </div>
    </div>";
    }

    public function build_tainted_car($row) {
        $cars_found = "";
        $car_id=$row['carID'];
        $car_spec_id=$row['carspecsID'];        
        $current_status = $row['carStatus'];
        if ($current_status == 1) {
            $event = "Returned";
            $show_button = "";
            $x_date = date_create($row['returnDate']);
        } elseif ($current_status == 2) {
            $event = "Rented";
            $show_button = "<td><div class='return_car' onclick='return_car(" . $car_id . "," . $car_spec_id . ")'>Return</div></td>";
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

    /*     * *** TOKENIZE SEARCH **** */

    function LIKE($column, $words) {
        $LIKE = "";
        $index = 0;
        foreach ($words as $word) {
            if ($index > 0) //the first time we don't want to add LIKE
                $LIKE.=" OR ";

            $LIKE.=" $column LIKE '%$word%' ";
            $index++;
        }
        return $LIKE;
    }

    function tokenize($data, $delimiter = ",") {

        $array = array();
        $token = strtok($data, $delimiter);
        while ($token !== false) {
            array_push($array, $token);
            $token = strtok($delimiter);
        }
        return $array;
    }

}
