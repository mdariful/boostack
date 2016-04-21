/**
 * Created by Md Ariful on 18/04/2016.
 */
$(document).ready(function () {


    $(".nav-tabs #activeuser").on("click",function(elem){
        console.log(elem);
        var activeid=$(elem.target).attr('active');
        console.log(activeid);
        $('.elemtoremove').remove();
        activeUser(activeid);

    });
    $(".nav-tabs #inactiveuser").on("click",function(elem){
        console.log(elem);
        var activeid=$(elem.target).attr('active');
        console.log(activeid);
        $('.elemtoremove').remove();
        activeUser(activeid);

    });
    $('#getUsers').on('click', function () {
        clearForm();
    });

    $('#save').on('click', function () {
        userInsert();
        $(".modal").modal('hide');
        return false;
    });

    $(document).submit('#userform', function () {
        userUpdate();
        $(".modal").modal('hide');
        return false;
    });

    $(document).on('click', '.delete', function (elem) {
        var result = confirm("Want to delete?");
        if (result) {
            var userid = $(elem.target).attr("id");
            userDelete(userid);
        } else {
            return false;
        }
    });

    $(document).on('click', '.view', function (elem) {
        var viewid = $(elem.target).attr("viewid");
        console.log(viewid);
        getUser(viewid);

    });


});
function userInsert() {

    var username = $('#username').val();
    var name = $('#name').val();
    var privilege = $('#privilege').val();
    var active = $('#active').val();
    var email = $('#email').val();
    var password = $('#password').val();
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        method: "POST",
        data: {
            type: "insert",
            username: username,
            name: name,
            privilege: privilege,
            active: active,
            email: email,
            password: password
        }
    }).done(function (data) {
        var res = JSON.parse(data);
        console.log(res);
        if (res.status === true) {
            var elem = $('.elemtocopy').clone();
            $(elem).removeClass('hidden elemtocopy');
            $('.username', elem).html(res.data.username);
            $('.email', elem).html(res.data.email);
            $('.name', elem).html(res.data.name);
            $('.view', elem).attr('viewid', res.data.id);
            $('.delete', elem).attr('id', res.data.id);
            $(elem).addClass('user' + res.data.id);
            $(elem).appendTo('.myelem');


            console.log("ok");
        } else {
            console.log("Error");
        }

    }).fail(function (data) {
        console.log(data);
    });


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
        data: {
            type: "update",
            id: id,
            name: name,
            privilege: privilege,
            username: username,
            email: email,
            active: active
        }
    }).done(function (data) {
        var res = JSON.parse(data);
        console.log(res);
        if (res.status === true) {

            $('.user' + res.data.id + ' ' + '.name').html(res.data.name);

            console.log("ok");
        } else {
            console.log("error");
        }


    }).fail(function (data) {
        console.log(data);

    });

}
function userDelete(userid) {
    $('.ajax-loader').show();

    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        type: "POST",
        data: {type: "delete", id: userid}
    }).done(function (data) {
        console.log("delete");
        var res = JSON.parse(data);
        if (res.status === true) {
            $('.user' + userid).remove();
            $('.ajax-loader').hide();
        } else {
            console.log("Errore");
        }
    }).fail(function (data) {
        console.log("error");
    });
}


function getUser(viewid) {
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        method: "POST",
        data: {type: "viewUser", id: viewid}

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
/*function  allUser() {
 $.ajax({
 cache: false,
 url: "ajax_user_controller.php/",
 method: "POST",
 data: {type: "allUser"}

 }).done(function (data) {
 var res = JSON.parse(data);
 console.log(res);
 $.each(res.data, function(i, key){
     if(key.active==="0"){
         $(".user").append("<td>" + key.username + "</td><td>" + key.email + "</td><td>"+key.name+"</td>");
     }else if(key.active==="1"){
         $(".user").append("<td>" + key.username + "</td><td>" + key.email + "</td><td>"+key.name+"</td>");
     }else{
         console.log(key);
     }

 })

 }).fail(function (data) {
 console.log("error");
 });
 }*/

function clearForm() {
    $('#saveform #username').val('');
    $('#saveform #name').val('');
    $('#saveform #email').val('');
    $('#saveform #password').val('');

}
function activeUser(activeid){
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        method: "POST",
        data: {type: "activeUser", activeid: activeid}

    }).done(function (data) {
        var res = JSON.parse(data);
        console.log(res);
        $.each(res.data, function(i, key){
            console.log(key.username);
            if(key.active==="1"){
                var elem1 = $('.elemtocopy1').clone();
                $(elem1).removeClass('hidden elemtocopy1');
                $('.username', elem1).html(key.username);
                $('.email', elem1).html(key.email);
                $('.name', elem1).html(key.name);
                $('.view', elem1).attr('viewid', key.id);
                $('.delete', elem1).attr('id', key.id);
                $(elem1).addClass('user' + key.id);
                $(elem1).appendTo('.myelem1');
                $(elem1).addClass('elemtoremove');
            }else{
                var elem2 = $('.elemtocopy2').clone();
                $(elem2).removeClass('hidden elemtocopy2');
                $('.username', elem2).html(key.username);
                $('.email', elem2).html(key.email);
                $('.name', elem2).html(key.name);
                $('.view', elem2).attr('viewid', key.id);
                $('.delete', elem2).attr('id', key.id);
                $(elem2).addClass('user' + key.id);
                $(elem2).appendTo('.myelem2');
                $(elem2).addClass('elemtoremove');
            }

        })


    }).fail(function (data) {
        console.log("error");
    });
}