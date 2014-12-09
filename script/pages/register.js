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

function validate_student() {   
    var form=$("add_customer");
    var data = new FormData(form);
    
    var ajax = ajaxObject();
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4 && ajax.status === 200) {
            var messages = JSON.parse(ajax.responseText);
            console.log(messages);
            for (var key in messages) {
                $(key).innerHTML = messages[key];
            }
        }
    };
    ajax.open("POST", "register.php");
    ajax.send(data); //send the data
}