<?php

include "sanitization.php";
include "connection.php";

$valid = false;
//array for the error messages
$messages = array("id_error" => "", "name_error" => "", "password_error" => "", "address_error" => "",
    "phone_error" => "", "success" => "", "insertion_error" => "");

if (isset($_POST['id'])) {
    $id = isset($_POST['id']) ? sanitizeMYSQL($_POST['id']) : "";
    $messages["id_error"] = validate_id($id);

    $name = isset($_POST['name']) ? sanitizeMYSQL($_POST['name']) : "";
    $messages["name_error"] = validate_name($name);

    $password = isset($_POST['password']) ? sanitizeMYSQL($_POST['password']) : "";
    $messages["password_error"] = validate_password($password);
    $encodedPassword = md5(sanitizeMYSQL($_POST['password']));

    $address = isset($_POST['address']) ? sanitizeMYSQL($_POST['address']) : "";
    $messages["address_error"] = validate_address($address);

    $phone = isset($_POST['phone']) ? sanitizeMYSQL($_POST['phone']) : "";
    $messages["phone_error"] = validate_phone($phone);

    $valid = $messages["id_error"] == "" && $messages["name_error"] == "" && $messages["password_error"] == "" && $messages["address_error"] == "" && $messages["phone_error"] == "";
    if ($valid) {
        $SQL = "INSERT INTO customer(ID,Name,Password,address,phone) VALUES(";
        $SQL.="'" . $id . "', '" . $name . "', '" . $encodedPassword . "', '" . $address . "', '" . $phone . "' )";

        $result = mysqli_query($db_server, $SQL);

        if (!$result) {
            $valid = false;
            $messages["insertion_error"] = "An error occured while attempting to insert a new customer in the database.";
        } else {
            $messages["success"] = "You have successfully created a new account. Please return to the login page to sign in.";
        }
    } else {
        $messages["insertion_error"] = "A new account could not be created. Please try again.";
    }
    echo json_encode($messages);
    mysqli_close($db_server);
}

function validate_id($id) {
    if (trim($id) == "")
        return "ID is required";

    $SQL = "SELECT * FROM customer WHERE ID='$id'"; //make sure the ID is  unique
    $result = mysqli_query($db_server, $SQL);

    if (mysqli_num_rows($result) >= 1)
        return "The ID already exists";

    if (strlen($password) > 10)
        return "Password can't be more than 10 characters";

    return ""; //it is valid
}

function validate_name($name) {
    if (trim($name) == "")
        return "Name is required";
    if (preg_match('/\d/', $name))
        return "Name must not contain digits";
    if (strlen($name) < 2 || strlen($name) > 150)
        return "The length of the name must be >=1 and <=150";

    return ""; //it is valid
}

function validate_password($password) {
    if (trim($password) == "")
        return "Password is required";
    $message = "";
    $contains_digits = preg_match('/\d/', $password);
    $contains_lowercase = preg_match('/[a-z]/', $password);
    $contains_uppercase = preg_match('/[A-Z]/', $password);

    if (!$contains_digits || !$contains_lowercase || !$contains_uppercase) {
        $message = "Password must contain: ";

        if (!$contains_digits)
            $message.="digits |";

        if (!$contains_lowercase)
            $message.=" lowercase letters |";

        if (!$contains_uppercase)
            $message.=" uppercase letters |";

        return $message;
    }
    if (strlen($password) < 8 || strlen($password) > 10)
        return "Password must be >=8 and <=10";

    return ""; //valid
}

function validate_address($address) {
    if (trim($address) == "")
        return "Address is required";
    $message = "";
    $contains_digits = preg_match('/\d/', $address);
    $contains_lowercase = preg_match('/[a-z]/', $address);
    $contains_uppercase = preg_match('/[A-Z]/', $address);

    if (!$contains_digits || !$contains_lowercase || !$contains_uppercase) {
        $message = "Address must contain: ";

        if (!$contains_digits)
            $message.="digits |";

        if (!$contains_lowercase)
            $message.=" lowercase letters |";

        if (!$contains_uppercase)
            $message.=" uppercase letters |";

        return $message;
    }

    return ""; //it is valid
}

function validate_phone($phone) {
    if (trim($phone) == "")
        return "Phone is required";
    $contains_digits = preg_match('/\d/', $phone);
    $contains_lowercase = preg_match('/[a-z]/', $phone);
    $contains_uppercase = preg_match('/[A-Z]/', $phone);

    if ($contains_lowercase || $contains_uppercase)
        return "Phone number can't contain letters";

    if (!$contains_digits)
        return "Phone number must contain digits";

    if (strlen($phone) != 12)
        return "Phone number must contain 10 digits and 2 dashes in this format:XXX-XXX-XXXX";

    return ""; //valid
}
?>