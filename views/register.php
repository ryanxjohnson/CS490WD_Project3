<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}
?>

<html>
    <head>
        <title>Car Rental Registration</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <script type="text/javascript"  src='script/general/general.js'></script>
        <script type="text/javascript"  src='script/pages/login.js'></script>
    </head>
    <body>
        <div>
            <!-- register form -->
            <form method="post" action="register.php" name="registerform">

                <div class="item">
                    <!-- the user name input field uses a HTML5 pattern check -->
                    <label for="login_input_username">Username</label>
                    <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
                </div>
                <div class="item">
                    <label for="login_input_name">Name</label>
                    <input id="login_input_name" class="login_input" type="text" name="name" required />
                </div>
                <div class="item">
                    <!-- Need to do type check for phone number -->
                    <label for="login_input_phone_number">Phone Number</label>
                    <input id="login_input_phone_number" class="login_input" type="text" name="phone_number" />
                </div>
                 <div class="item">
                    <label for="login_input_address">Address</label>
                    <input id="login_input_address" class="login_input" type="text" name="address" />
                </div>
                <div class="item">
                    <label for="login_input_password_new">Password</label>
                    <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
                </div>
                <div class="item">
                    <label for="login_input_password_repeat">Password</label>
                    <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
                    <input class="button" type="submit"  name="register" value="Register" />
                </div>
            </form>
        </div>
    </body>
</html>

<!-- backlink -->
<a href="index.php">Back to Login Page</a>
