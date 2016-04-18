/**
 * Created by Md Ariful on 14/04/2016.
 */
$(document).ready(function() {
    $(document).on("blur","#inputEmail3",function(){
        checkEmail();
    });
    $(document).on("blur","#name",function(){
        var name = $('#name').val();
        console.log(name);
        if($.isNumeric(name) || name === ""){
            console.log("error");
            $('.name').addClass('has-error');
            $( "#submit" ).prop( "disabled", true );

        }else
        {
            console.log("ok");
            $('.name').removeClass('has-error');
            $( "#submit" ).prop( "disabled", false );
        }
    });

});
function checkEmail() {
    var email = $('#inputEmail3').val();
    console.log(email);
    $.ajax({
        cache: false,
        url: "checkmail.php/",
        type: "POST",
        data: {email: email}
    }).done(function (data) {
        console.log(data);
        var res = JSON.parse(data);
        console.log(res);
        if (res === false ) {

            console.log("Ok!");
            $('.email').removeClass('has-error');
            $( "#submit" ).prop( "disabled", false );
        }else{
            $('.email').addClass('has-error');
            console.log("Email already exist!");
            $( "#submit" ).prop( "disabled", true );
        }

    }).fail(function (data) {
        console.log(data);
    });

}