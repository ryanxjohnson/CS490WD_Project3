function ajaxObject() {
    var ajax;
    if (window.XMLHttpRequest)
        ajax = new XMLHttpRequest(); //non-IE browser
    else
        ajax = new ActiveXObject("Microsoft.XMLHTTP");//IE browser

    return ajax;
}

function $(id) {
    return document.getElementById(id);
}

function init() {
    make_search_field("search_field", "Type car make, model, year, color, etc.");
    show_info("name","username");
    show_info("search_field", $("search_field").value);
    show_info("rented_cars", "rented_cars");
    show_info("returned_cars", "returned_cars");

}

/* Logout is good */
function logout() {
    var data = new FormData();
    data.append("type", "logout");
    var ajax = ajaxObject();
    ajax.onreadystatechange = function () {
        if (ajax.readyState === 4 && ajax.status === 200) {
            if (ajax.responseText.trim() == "success")
            window.location.assign("index.html");
        }
    };
    ajax.open("POST", "cars.php");
    ajax.send(data); //send the data
}

function find_car() {
   
    var ajax = ajaxObject();
    var form = $("search_field");
    var data = new FormData(form);
    data.append("type", "search_results");
    data.append("search_field", $("search_field").value);
    
    $("find_car_loading").className = "loading";
    ajax.onreadystatechange = function () {
        if (ajax.readyState === 4 && ajax.status === 200) {
            $("search_results").innerHTML = ajax.responseText;
            //show_info("search_results", "search_results");
            $("find_car_loading").className = "loading_hidden";
        }
    };
    ajax.open("POST", "cars.php");
    ajax.send(data);
}

function show_info(type, id) {
    var data = new FormData();
    data.append("type", type);
    var ajax = ajaxObject();
    ajax.onreadystatechange = function () {
        if (ajax.readyState === 4 && ajax.status === 200) {
            $(id).innerHTML = ajax.responseText;
        }
    };
    ajax.open("POST", "cars.php");
    ajax.send(data); //send the data
}

function rent_car(car_id, car_spec_id) {
    var data = new FormData();
    data.append("type", "rent");
    data.append("car_id", car_id);
    data.append("car_spec_id", car_spec_id);

    var ajax = ajaxObject();
    ajax.onreadystatechange = function () {
        if (ajax.readyState === 4 && ajax.status === 200) {
            if (ajax.responseText.trim() == "success") 
                show_info("search_results", "search_results");
            show_info("rented_cars", "rented_cars");   
            show_info("returned_cars", "returned_cars");
            show_message();
            $("message").innerHTML = " Car has been rented ";
        }
    };
    ajax.open("POST", "cars.php");
    ajax.send(data); //send the data
}

function return_car(car_id, car_spec_id) {
    var data = new FormData();
    data.append("type", "return");
    data.append("car_id", car_id);
    data.append("car_spec_id", car_spec_id);
    var ajax = ajaxObject();
    ajax.onreadystatechange = function () {
        if (ajax.readyState === 4 && ajax.status === 200) {
            if (ajax.responseText.trim() == "success") //if everything goes well
                show_info("search_results", "search_results");
            show_info("rented_cars", "rented_cars"); // refresh
            show_info("returned_cars", "returned_cars");
            show_message();
            $("message").innerHTML = " Car has been returned ";
        }
    };
    ajax.open("POST", "cars.php"); //cars.php
    ajax.send(data); //send the data
}

function close_message() {
    $("background").style.display = "none";
    $("message_box").style.display = "none";
    $("message").innerHTML = "";
}

function show_message() {
    $("background").style.display = "block";
    $("message_box").style.display = "block";
}

function send_data(ajax, link, data) {
    ajax.open("POST", link, true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var request = "";
    var first_key = true;

    for (var key in data) {
        if (!first_key)
            request += " & ";
        request += key + "=" + data[key];
        first_key = false;
    }
    ajax.send(request);
}

function view_students_key(event) {
    if (event.keyCode == 13) //ENTER KEY
        view_students();
}