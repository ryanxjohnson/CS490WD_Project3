/*
 * CS490_Project 3  - Ryan, Jose, Anthony, Alicia
 */

function ajaxObject() {
    var ajax;
    if (window.XMLHttpRequest)
        ajax = new XMLHttpRequest(); //non-IE browser
    else
        ajax = new ActiveXObject("Microsoft.XMLHTTP");//IE browser

    return ajax;
}

function view_cars(event) {
    alert(event);
    if (event.keyCode === 13) //ENTER KEY
        find_car();
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
    ajax.send(data);
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
            //var cars = ajax.responseText;
            
            $("search_results").innerHTML = ajax.responseText;
            $("find_car_loading").className = "loading_hidden";
        }
    };
    ajax.open("POST", "cars.php");
    ajax.send(data);
}
function sort(type){
    var divs = $("search_results");
    var cars = document.getElementsByClassName("search_item");
    var info = document.getElementsByClassName(type);
    var sortme = []; // container to sort divs
   
   for(var i = 0; i < cars.length; i++){
        
        var detail = info[i].innerHTML;//information to sort by
       if(type === "car_model"){ // if sorting by year we only want the year
           var modelAndYear = detail.toString();
           var year = [];
           year = modelAndYear.split('|'); //split model and year
           detail = parseInt(year[1]);
       }
        sortme.push([detail, cars[i]]);
       
   } 
   sortme.sort(function(a, b){
       var A = a[0].toString();
       var B = b[0].toString();
       if(A === B)
           return 0;
       if(A > B)
           return 1;
       else
           return -1;
       
   });
   //append the page with sorted divs
   for (var i = 0; i < info.length; i++){
       divs.appendChild(sortme[i][1]);    
   }
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
    ajax.send(data);
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
            find_car();
            show_message();
            $("message").innerHTML =  " Car has been rented ";
        }
    };
    ajax.open("POST", "cars.php");
    ajax.send(data);
}

function return_car(car_id, car_spec_id) {
    var data = new FormData();
    data.append("type", "return");
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
            $("message").innerHTML =  " Car has been returned ";                
            

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


