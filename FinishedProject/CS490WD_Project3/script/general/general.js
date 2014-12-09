/*
 * CS490_Project 3  - Ryan, Jose, Anthony, Alicia
 */

function ajaxObject(){
    var ajax;
    if (window.XMLHttpRequest)
        ajax=new XMLHttpRequest();
    else
        ajax=new ActiveXObject("Microsoft.XMLHTTP");
    
    return ajax;
}

function send_data(ajax,link,data){
    ajax.open("POST",link,true);
    ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var request="";
    var first_key=true;
    
    for (var key in data) {
        if(!first_key)
            request+=" & ";
        request+=key+"="+data[key];
        first_key=false;
    }
    ajax.send(request);
}

function $(id){
    return document.getElementById(id);
}

function show_tab(tab){
    var tabs=document.getElementsByClassName("tab_pressed");
    var pressed_tab=tabs[0];
    pressed_tab.className="tab";
    pressed_tab.firstElementChild.className="tab_detail_hidden";
    tab.className="tab_pressed";
    tab.firstElementChild.className="tab_detail";
}

// a function that makes a field look like a search box
function make_search_field(key, initial_text){
    
    var element=$(key);
    element.value=initial_text;
    element.style.color="gray";
    
    element.onmouseover=function(){
        if(element.value===initial_text)
        element.style.color="lightgray";
    };
    
    element.onmouseout=function(){
        if(element.value===""){
            element.value=initial_text;
            element.style.color="gray";
        }
        if(element.value===initial_text)
            element.style.color="gray";
    };
    
    element.onfocus=function(){
        if(element.value===initial_text)
            element.value="";
    };
    
    element.onkeydown=function(){
        if(element.value===initial_text)
            element.value="";
        element.style.color="black";
    };
    
}