/**
 * Created by Md Ariful on 18/04/2016.
 */
$(document).ready(function(){
    $('#saveform').submit( function(){
        userInsert();
        return false;
    });
    $('#update').click( function(){
        userUpdate();
    });
    $('#updatedelete').submit( function(elem){
        console.log(elem.target);
        var userid = $(elem.target).attr("userid");
        console.log(userid);
        userDelete(userid);
        return false;
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
            type: "POST",
            data: {type: "insert", username: username, name: name, privilege: privilege,active: active,email: email,password: password}
        }).done(function (data) {
            var res = JSON.parse(data);
            if(res === true){

                console.log("ok");
            }else{
                console.log("Error");
            }

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
function userDelete(userid){
    var id = $('#id').val();
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        type: "POST",
        data: {type: "delete", id: userid}
    }).done(function (data) {
        console.log("delete")

    }).fail(function (data) {
        console.log("error");
    });
}