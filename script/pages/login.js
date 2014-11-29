/* This file is good */


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

function maybe_login(event){
    if (event.keyCode == 13) //ENTER KEY
        login();
}

function login() {
    var ajax = ajaxObject();
    var form = $("login_form");
    var formData = new FormData(form);
    $("loading").className="loading";
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4 && ajax.status === 200) {
          if(ajax.responseText.trim()=="success")
              window.location.assign("cars.html");
          else{
            $("loading").className="loading_hidden";
            $("login_feedback").innerHTML = ajax.responseText;
        }
        }
    };
    ajax.open("POST", "login_session.php"); //login_session.php
    ajax.send(formData);
}




