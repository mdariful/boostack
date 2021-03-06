/**
 * Created by Md Ariful on 18/04/2016.
 */
$(document).ready(function () {

    //Fill the table with all user
    allUser();
    //Fill the user table on active click button on the tab
    $(document).on('click','active',function(){
        allUser();
        //remove old user from the dom
        $('.insertusertoremove').remove();
    });
    //Active the user
    $(document).on('click', '.activate', function (elem) {
        var activate = $(elem.target).attr('activate');
        console.log(activate);
        activateUser(activate);
    });
    //Disactive the user
    $(document).on('click', '.disactivate', function (elem) {
        var disactivate = $(elem.target).attr('disactivate');

        disactivateUser(disactivate);
    });
    //view the active user
    $(".nav-tabs #activeuser").on("click", function (elem) {

        var activeid = $(elem.target).attr('active');

        $('.elemtoremove').remove();
        activeUser(activeid);

    });
    //view the inactive user
    $(".nav-tabs #inactiveuser").on("click", function (elem) {

        var activeid = $(elem.target).attr('active');

        $('.elemtoremove').remove();
        activeUser(activeid);

    });
    //Clear the form from insert new user modal form
    $('#getUsers').on('click', function () {
        clearForm();
    });
    // Save the user
    $('#save').on('click', function () {
        userInsert();
        return false;
    });
    //Control if email already exist
    $('#saveform').on("blur","#email",function(){
        userExist();
    });

    //update the user
    $(document).submit('#userform', function () {
        userUpdate();
        $(".modal").modal('hide');
        return false;
    });
    //delete the user on confirm
    $(document).on('click', '.delete', function (elem) {
        var result = confirm("Want to delete?");
        if (result) {
            var userid = $(elem.target).attr("id");
            userDelete(userid);
        } else {
            return false;
        }
    });
    //view the user
    $(document).on('click', '.view', function (elem) {
        var viewid = $(elem.target).attr("viewid");

        getUser(viewid);

    });
    $(document).on('click', '.alert-close', function() {
        $('.container #message').hide();
    });

});

//Insert the user from the modal form add new user
function userInsert() {
    $('.ajax-loader').show();
    var username = $('#username').val();
    var name = $('#name').val();
    var privilege = $('#privilege').val();
    var active = $('#active').val();
    var email = $('#email').val();
    var password = $('#password').val();
    if(name !='' && username!='' && password!=''){
        if(name =='' && username =='' ){
            $('.modal-header .alert').addClass('alert-warning');
            $('.modal-header .alert').html('<p>Invalid username, name or password</p>');

            return false;
        }
        if(password!='' && password.length<8){
            $('.modal-header .alert').addClass('alert-warning');
            $('.modal-header .alert').html('<p>Password must contain at least 8 characters!</p>');

            return false;
        }
        if(password == username){
            $('.modal-header .alert').addClass('alert-warning');
            $('.modal-header .alert').html('<p>Password must be different from username</p>');

            return false;
        }
    }else{
        $('.modal-header .alert').addClass('alert-warning');
        $('.modal-header .alert').html('<p>Fill all the field</p>');
        $( "#save" ).prop( "disabled", false );
    }

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
            $('.ajax-loader').hide();

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
                $(elem).addClass('insertusertoremove');
                $(".container #message").show();
                $('.container #message').addClass('alert-success');
                $('.container #message').html('<button type="button" class="close alert-close">&times;</button><p>User added successfully</p>');
                $(".modal").modal('hide');
            } else {
                console.log("Error");
            }

        }).fail(function (data) {
            $('.ajax-loader').show();
            console.log(data);
        });

}
//Update the user from the modal update form
function userUpdate() {
    $('.ajax-loader').show();
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
        $('.ajax-loader').hide();
        if (res.status === true) {

            $('.user' + res.data.id + ' ' + '.name').html(res.data.name);
            $(".container #message").show();
            $('#alerts').addClass('alert-success');
            $('#alerts').html('<button type="button" class="close alert-close">&times;</button><p>User update successfully</p>');

        } else {
            console.log("error");
        }


    }).fail(function (data) {
        console.log(data);
        $('.ajax-loader').show();
    });

}
//delete the user when the delete button pressed
function userDelete(userid) {
    $('.ajax-loader').show();
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        type: "POST",
        data: {type: "delete", id: userid}
    }).done(function (data) {

        var res = JSON.parse(data);
        if (res.status === true) {
            $('.user' + userid).remove();
            $('.ajax-loader').hide();
            $(".container #message").show();
            $('.container #message').addClass('alert-warning');
            $('.container #message').html('<button type="button" class="close alert-close">&times;</button><p>Delete successfully</p>');
        } else {
            console.log("Errore");
        }
    }).fail(function (data) {
        console.log("error");
    });
}

//Fill the modal form with the user data
function getUser(viewid) {
    $('.ajax-loader').show();
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        method: "POST",
        data: {type: "viewUser", id: viewid}

    }).done(function (data) {
        var res = JSON.parse(data);
        $('.ajax-loader').hide();
        $("#userform .id1").val(res.data.id);
        $("#userform .username1").val(res.data.username);
        $("#userform .email1").val(res.data.email);
        $("#userform .name1").val(res.data.name);
        $("#userform .privilege1").val(res.data.privilege);
        $("#userform .active1").val(res.data.active);


    }).fail(function (data) {
        console.log("error");
        $('.ajax-loader').show();
    });
}
//Get all the user one the current document & when the all user tab button
function allUser() {
    $('.ajax-loader').show();
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        method: "POST",
        data: {type: "allUser"}

    }).done(function (data) {
        var res = JSON.parse(data);
        $('.ajax-loader').hide();
        $.each(res.data, function (i, key) {

            var elem1 = $('.elemtocopy').clone();
            $(elem1).removeClass('hidden elemtocopy');
            $('.username', elem1).html(key.username);
            $('.email', elem1).html(key.email);
            $('.name', elem1).html(key.name);
            $('.view', elem1).attr('viewid', key.id);
            $('.delete', elem1).attr('id', key.id);
            $('.activate', elem1).attr('activate', key.id);
            $('.disactivate', elem1).attr('disactivate', key.id);
            $(elem1).addClass('user' + key.id);
            $(elem1).appendTo('.myelem');


        })

    }).fail(function (data) {
        console.log("error");
        $('.ajax-loader').show();
    });
}
//clear the modal form when the add new user button clicked
function clearForm() {
    $('#saveform #username').val('');
    $('#saveform #name').val('');
    $('#saveform #email').val('');
    $('#saveform #password').val('');

}

//View the user on the specified Active or Inactive Tab.
function activeUser(activeid) {
    $('.ajax-loader').show();
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        method: "POST",
        data: {type: "activeUser", activeid: activeid}

    }).done(function (data) {
        var res = JSON.parse(data);
        $('.ajax-loader').hide();
        $.each(res.data, function (i, key) {

            if (key.active === "1") {
                var elem1 = $('.elemtocopy1').clone();
                $(elem1).removeClass('hidden elemtocopy1');
                $('.username', elem1).html(key.username);
                $('.email', elem1).html(key.email);
                $('.name', elem1).html(key.name);
                $('.view', elem1).attr('viewid', key.id);
                $('.delete', elem1).attr('id', key.id);
                $('.disactivate', elem1).attr('disactivate', key.id);
                $(elem1).addClass('user' + key.id + ' ' + 'u' + key.id);
                $(elem1).appendTo('.myelem1');
                $(elem1).addClass('elemtoremove');
            } else {
                var elem2 = $('.elemtocopy2').clone();
                $(elem2).removeClass('hidden elemtocopy2');
                $('.username', elem2).html(key.username);
                $('.email', elem2).html(key.email);
                $('.name', elem2).html(key.name);
                $('.view', elem2).attr('viewid', key.id);
                $('.delete', elem2).attr('id', key.id);
                $('.activate', elem2).attr('activate', key.id);
                $(elem2).addClass('user' + key.id + ' ' + 'u' + key.id);
                $(elem2).appendTo('.myelem2');
                $(elem2).addClass('elemtoremove');
            }

        })


    }).fail(function (data) {
        $('.ajax-loader').show();
        console.log("error");
    });
}
//active the user when the active button pressed
function activateUser(activate) {
    $('.ajax-loader').show();
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        method: "POST",
        data: {type: "activateUser", id: activate}

    }).done(function (data) {
        var res = JSON.parse(data);
        if (res.status === true) {
            $('.u' + activate).remove();
            $(".container #message").show();
            $('.container #message').addClass('alert-success');
            $('.container #message').html('<button type="button" class="close alert-close">&times;</button><p>User now is activeted</p>');
            $('.ajax-loader').hide();
        }


    }).fail(function (data) {
        console.log("error");
    });

}
//Disactive the user when the disactive button pressed
function disactivateUser(disactivate) {
    $('.ajax-loader').show();
    $.ajax({
        cache: false,
        url: "ajax_user_controller.php/",
        method: "POST",
        data: {type: "disactivateUser", id: disactivate}

    }).done(function (data) {
        var res = JSON.parse(data);

        if (res.status === true) {
            $('.u' + disactivate).remove();
            $(".container #message").show();
            $('.container #message').addClass('alert-success');
            $('.container #message').html('<button type="button" class="close alert-close">&times;</button><p>User now is disactiveted</p>');
            $('.ajax-loader').hide();
        }


    }).fail(function (data) {
        console.log("error");
    });

}
//Controll the email existing on the new user creation modal
function userExist(){
    var email = $('#email').val();
    if(email==''){
        $('.modal-header .alert').addClass('aler-warning');
        $('.modal-header .alert').html('<p>Email field need to be filled</p>');

    }else{
        $.ajax({
            cache: false,
            url: "ajax_user_controller.php/",
            type: "POST",
            data: {type:"userExist", email: email}
        }).done(function (data) {

            var res = JSON.parse(data);
            console.log(res);
            if (res.status === false ) {

                $('.email').removeClass('has-error');
                $('.modal-header .alert').removeClass('alert-warning');
                $( "#save" ).prop( "disabled", false );
                return true;
            }else{
                $('.modal-header .alert').addClass('alert-warning');
                $('.modal-header .alert').html('<p>Choose another email</p>');
                $('.email').addClass('has-error');

                $( "#save" ).prop( "disabled", true );
            }

        }).fail(function (data) {
            console.log(data);
        });
    }

}
function controlInsert(){
    var username = $('#username').val();
    var name = $('#name').val();
    var privilege = $('#privilege').val();
    var active = $('#active').val();
    var email = $('#email').val();
    var password = $('#password').val();
    if(name !='' && username!='' && password!=''){
    if(name =='' && username =='' ){
        $('.modal-header .alert').addClass('alert-warning');
        $('.modal-header .alert').html('<p>Invalid username, name or password</p>');
        $( "#save" ).prop( "disabled", true );
        return false;
    }
    if(password!='' && password.length<8){
        $('.modal-header .alert').addClass('alert-warning');
        $('.modal-header .alert').html('<p>Password must contain at least 8 characters!</p>');
        $( "#save" ).prop( "disabled", true );
        return false;
    }
    if(password == username){
        $('.modal-header .alert').addClass('alert-warning');
        $('.modal-header .alert').html('<p>Password must be different from username</p>');
        $( "#save" ).prop( "disabled", true );
        return false;
    }
    }else{
        $('.modal-header .alert').addClass('alert-warning');
        $('.modal-header .alert').html('<p>Fill all the field</p>');
        $( "#save" ).prop( "disabled", true );
    }
    return true;
}