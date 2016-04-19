/**
 * Created by Md Ariful on 18/04/2016.
 */
$(document).ready(function(){
    $('#saveform').submit( function(){
        userInsert();
    });

    $('#userform').submit(function(){
        userUpdate();
        return false;
    });

    $('.delete').on('click', function(elem){
        var result = confirm("Want to delete?");
        if (result) {
            console.log(elem.target);
            var userid = $(elem.target).attr("id");
            console.log(userid);
            userDelete(userid);
        }else{
            return false;
        }


    });

    $('.view').on('click', function(elem){
        console.log(elem.target);
        var viewid=$(elem.target).attr("viewid");
        console.log(viewid);
        getUser(viewid);
    });


});
function userInsert(){
    var username = $('#username').val();
    var name = $('#name').val();
    var privilege = $('#privilege').val();
    var active = $('#active').val();
    var email = $('#email').val();
    var password = $('#password').val();
    if(password<6 && username === "" && name === ""){
        $('.alert-danger').html("Field not valid");
    }else{

        $.ajax({
            cache: false,
            url: "ajax_user_controller.php/",
            method: "POST",
            data: {type: "insert", username: username, name: name, privilege: privilege,active: active,email: email,password: password}
        }).done(function (data) {
            var res = JSON.parse(data);
            console.log(res);
            if(res === true ){

                console.log("ok");
            }else{
                location.reload();
                console.log("Error");
            }

        }).fail(function (data) {
            console.log(data);
        });
    }


}
function userUpdate() {
    var id = $('#id1').val();
    var name = $('#name1').val();
    var privilege = $('#privilege1').val();
    var username = $('#username1').val();
    var email = $('#email1').val();
    var active = $('#active1').val();
        $.ajax({
            cache: false,
            url: "ajax_user_controller.php/",
            method: "POST",
            data: {type: "update",id: id, name: name, privilege: privilege,username:username,email:email, active:active}
        }).done(function (data) {
            var res = JSON.parse(data);
            console.log(res);
            console.log("ok")

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
        console.log("delete");
        location.reload();

    }).fail(function (data) {
        console.log("error");
    });
}


function getUser(viewid){
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        method: "POST",
        data: {type: "get", id: viewid}

    }).done(function (data) {
        var res = JSON.parse(data);
        console.log(res);
        $("#userform .id1").val(res.data.id);
        $("#userform .username1").val(res.data.username);
        $("#userform .email1").val(res.data.email);
        $("#userform .name1").val(res.data.name);
        $("#userform .privilege1").val(res.data.privilege);
        $("#userform .active1").val(res.data.active);


    }).fail(function (data) {
        console.log("error");
    });




}