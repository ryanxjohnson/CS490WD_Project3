/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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

function validate_students_key(event) {
    if (event.keyCode == 13) //ENTER KEY
        validate_student();
}

function validate_user() {
    $("success").innerHTML = "Inserted Successully";
    var ajax = ajaxObject();
    var form = $("register");
    var data = new FormData(form);
    data.append("register",$("register").value);
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4 && ajax.status === 200){       
            if (ajax.responseText = "success"){
                 window.location.assign("index.html");
            //var msg = JSON.parse(ajax.responseText.trim());
                $("success").innerHTML = "Inserted Successully";
            }

        }
    };
    ajax.open("POST", "register.php");
    ajax.send(data);
}