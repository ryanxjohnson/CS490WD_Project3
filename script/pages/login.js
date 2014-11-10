function maybe_login(event){
    if (event.keyCode == 13) //ENTER KEY
        login();
}

function login() {
    var ajax = ajaxObject();
    var form = $("login_form");
    var formData = new FormData(form);
    var failure_message = "Invalid username or password";
    $("loading").className="loading";
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4 && ajax.status === 200) {
            var data = JSON.parse(ajax.responseText);
            if (data["rows"] != 1)
                $("login_feedback").innerHTML = failure_message;
            else
                window.location.assign("cars.html");
            $("loading").className="loading_hidden";
        }
    };
    ajax.open("POST", "car_rental/pages/login.php");
    ajax.send(formData);
}




