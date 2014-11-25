/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function init() {
    make_search_field("search_field", "Type car make, model, year, color, etc.");
//    $("username").innerHTML = "$_SESSION['real_name']";
//    show_info("username", "username");
//    show_info("search_results","search_results");
//    show_info("rented_cars", "rented_cars");
//    show_info("returned_cars", "returned_cars");

}

function logout(){
    var data = new FormData();
    data.append("type", "logout"); 
    var ajax = ajaxObject();
    ajax.onreadystatechange = function() { 
        if (ajax.readyState === 4 && ajax.status === 200) { 
            if(ajax.responseText.trim()=="success")
              window.location.assign("index.html");           
        }
    };
    ajax.open("POST", "cars.php");
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
    $("message").innerHTML = " Showing a message ";
}

// edit this!
function rent_car(carID){// carID
    var data = new FormData();
    data.append("type", "drop"); // type. rent || return
    data.append("carID", carID); // carID, carID
    
    var ajax = ajaxObject();
    ajax.onreadystatechange = function() { 
        if (ajax.readyState === 4 && ajax.status === 200) { 
            if(ajax.responseText.trim()=="success") //if everything goes well
              show_info("find_car","find_car"); //refresh the enrolled courses  // findcars, findcars
        }
    };
    ajax.open("POST", "cars.php"); //cars.php
    ajax.send(data); //send the data
}

function return_car(carID) {
    
}

function show_info(type,id) {
    
    var data = new FormData();
    data.append("type", type); 
    var ajax = ajaxObject();
    ajax.onreadystatechange = function() { 
        if (ajax.readyState === 4 && ajax.status === 200) { 
            $(id).innerHTML = ajax.responseText;            
        }
    };
    ajax.open("POST", "account.php"); 
    ajax.send(data); //send the data
}


// edit this!
function rent_car(car_id){
    var data = new FormData();
    data.append("type", "rent");
    data.append("car_id", car_id);
    var ajax = ajaxObject();
    ajax.onreadystatechange = function() { 
        if (ajax.readyState === 4 && ajax.status === 200) { 
            
            if(ajax.responseText.trim()=="success") //if everything goes well
                            
              show_info("search_results","search_results");
              show_info("rented_cars","rented_cars"); // refresh
        }
    };
    ajax.open("POST", "cars.php");
    ajax.send(data); //send the data
}
// refactor this 
function return_car(car_id) {
    var data = new FormData();
    data.append("type", "return"); 
    data.append("car_id", car_id);
    var ajax = ajaxObject();
    ajax.onreadystatechange = function() { 
        if (ajax.readyState === 4 && ajax.status === 200) { 
            if(ajax.responseText.trim()=="success") //if everything goes well
              show_info("rented_cars","rented_cars"); // refresh
          //show_info("returned_cars", "returned_cars");
        }
    };
    ajax.open("POST", "cars.php"); //cars.php
    ajax.send(data); //send the data
}

function show_info(type,id) {
    var data = new FormData();
    data.append("type", type); 
    var ajax = ajaxObject();
    ajax.onreadystatechange = function() { 
        if (ajax.readyState === 4 && ajax.status === 200) { 
            $(id).innerHTML = ajax.responseText;            
        }
    };
    ajax.open("POST", "cars.php"); 
    ajax.send(data); //send the data
}