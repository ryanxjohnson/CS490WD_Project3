
<html>
    <head>
        <title>Car Rental System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <script type="text/javascript"  src='script/general/general.js'></script>
        <script type="text/javascript"  src='script/pages/login.js'></script>
    </head>
    <body>
        <div class="login">
            <!-- login form box -->
            <form method="post" action="index.php" name="loginform">
                <div class="item">
                    <label for="login_input_username">Username</label>
                    <input id="login_input_username" class="input" type="text" name="user_name" required />
                </div>
                <div class="item">
                    <label for="login_input_password">Password</label>
                    <input id="login_input_password" class="input" type="password" name="user_password" autocomplete="off" required />
                </div>
                <div class="item">
                    <img id="loading" class="loading_hidden" src="images/loading.gif">
                    <!--                    <div class="button" type="submit" name="login">Login</div>-->
                    <input class="button" type="submit"  name="login" value="Login" />
                </div>
            </form
            <div id="login_feedback" class="feedback">
                <?php
                //feedback (from login object)
                if (isset($login)) {
                    if ($login->errors) {
                        foreach ($login->errors as $error) {
                            echo $error;
                        }
                    }
                    if ($login->messages) {
                        foreach ($login->messages as $message) {
                            echo $message;
                        }
                    }
                }
                ?>
                <!-- for testing database and login -->
                <br><br><a href="register.php">Register new account</a>
            </div>

        </div> 

    </body>

</html>
