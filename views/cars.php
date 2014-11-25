<html>
    <head>
        <title>My Account</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style/general.css">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <script type="text/javascript"  src='script/general/general.js'></script>
        <script type="text/javascript"  src='script/pages/cars.js'></script>
    </head>
    <body class="body" onload="init();">
        <div class="container">
            <div class="account">

                <div class="welcome">
                    <!--                    <a onclick="logout();">Logout</a>-->
                    <a href="index.php?logout">Log Out</a>
                    <a href="" id="username">Hi, <?php echo $_SESSION['name']; ?></a> 
                    <img id="user_loading" class="user_loading_hidden" src="images/loading.gif">
                </div>

                <img src="images/car.PNG">
                <p>Rent a Car</p>

            </div>
            <div  class="tabs" id="tabs">
                <div onclick="show_tab(this)" class="tab_pressed"> Find Car
                    <div class="tab_detail"> 
                        <div class="search_bar">
                            <form method="post">
                                <input  id="search_field" name="search_field" class="search_field" type="text">
                                <button class="search_button" value="submit" type="submit" > 
                                    <img src="images/glass.png">
                                </button>

                            </form>
                        </div>
                        <img id="find_car_loading" class="loading_hidden" src="images/loading.gif">
                        <div id="search_results">
                            <!-- TODO: Moved this form to car class -->
                            <form method="post">
                                <select id="sortby" name="sortby" onchange="showUser(this.value)">
                                    <option value="">Sort By</option>
                                    <option value="Make">Make</option>
                                    <option value="Year">Year</option>
                                </select>
                                <input type="submit" value="Sort">
                            </form>
                            <?php
                            require_once("find_car.php");
                            ?>
                        </div>
                    </div>
                </div>
                <div onclick="show_tab(this)" class="tab"> Rented Cars

                    <div class="tab_detail_hidden"> 
                        <img id="rented_car_loading" class="loading_hidden" src="images/loading.gif">
                        <div id="rented_cars">
                            <table>
                                <th>Picture</th>
                                <th>Details</th>
                                <?php
                                include("rented_cars.php");
                                ?>
                            </table>
                        </div>

                    </div>
                </div>
                <div onclick="show_tab(this)" class="tab"> Rental History
                    <div class="tab_detail_hidden"> 
                        <img id="returned_car_loading" class="loading_hidden" src="images/loading.gif">
                        <div id="returned_cars">
                            <table>
                                <th>Picture</th>
                                <th>Details</th>
                                <?php
                                include("rental_history.php");
                                ?>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>



        <div id="background" class="msg_box_background">
        </div>
        <div id="message_box" class="message_box">
            <img onclick="close_message()" src="images/close_icon.png">
            <div class="message" id="message"></div>
            <img id="message_loading" class="loading_hidden" src="images/loading.gif">
            <div onclick="close_message()" class="close_button">Ok</div>
        </div>
    </body>
</html>