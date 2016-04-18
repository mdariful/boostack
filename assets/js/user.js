/**
 * Created by Md Ariful on 18/04/2016.
 */
$(document).ready(function(){
    $('#save').click( function(){
        userInsert();
    });
    $('#update').click( function(){
        userUpdate();
    });
    $('#delete').click( function(){
        userDelete();
    });
});
function userInsert(){
    var username = $('#username').val();
    var name = $('#name').val();
    var privilege = $('#privilege').val();
    var active = $('#active').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(username === "" && name === "" && !test.regex(email) && password === ""){
        console.log("Error");
    }else{
        $.ajax({
            cache: false,
            url: "ajax_user_controller.php/",
            type: "insert",
            data: {username: username, name: name, privilege: privilege,active: active,email: email,password: password}
        }).done(function (data) {
            console.log(data)

        }).fail(function (data) {
            console.log(data);
        });
    }
}
function userUpdate(){
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        type: "update",
        data: {id: id}
    }).done(function (data) {
        console.log(data)

    }).fail(function (data) {
        console.log(data);
    });
}
function userDelete(){
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        type: "delete",
        data: {id: id}
    }).done(function (data) {
        console.log(data)

    }).fail(function (data) {
        console.log(data);
    });
}