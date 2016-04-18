$(document).ready(function(){
    $(function() {

        $("#datepicker").datepicker({ dateFormat: "dd-mm-yy" }).val()
    });


    $('#profileform').on('submit',function(){
        //Initial declartion of the variable id of the form
        var first_name = $('.first_name').val();
        var last_name = $('.last_name').val();
        var tel = $('.tel').val();
        var cell = $('.cell').val();
        var date = $('.date').val();

        if(validateAll(first_name,last_name,tel,cell,date)) {

            return true;
        }else{
            return false;
        }

    });




    function validateField(first_name,last_name)
    {
        if($.isNumeric(first_name)|| $.isNumeric(last_name) || first_name === "" || last_name === ""){

            console.log("Field can't be empty or numeric");
            $('.alert-danger').html("Field not valid");
            return false;
        }else{
            console.log("The field is valid");
            return true;
        }
    }


    function validateTel(tel)
    {

        /*var num = /^([+]39)?((3[\d]{2})([ ,\-,\/]){0,1}([\d, ]{6,9}))|(((0[\d]{1,4}))([ ,\-,\/]){0,1}([\d, ]{5,10}))$/;
        var filter=num.test(tel);
        var res1=filter.replace("+","");*/

        if($.isNumeric(tel) && tel.length>8){
            console.log("The tel numbers are valid");
            return true;
        }else{
            console.log("Tel not valid");
            $('.alert-danger').html("Tel numbers is not valid!");
            return false;
        }

    }
    function validateCell(cell)
    {

        var num = /^([+]39)?((3[\d]{2})([ ,\-,\/]){0,1}([\d, ]{6,9}))|(((0[\d]{1,4}))([ ,\-,\/]){0,1}([\d, ]{5,10}))$/;


        if(num.test(cell)){
            console.log("The cell numbers are valid");
            return true;
        }else{
            console.log("cell not valid");
            $('.alert-danger').html("Cell numbers is not valid!");
            return false;
        }

    }
    
    function validateDate(date) {
        if(date === ""){
            console.log("Birthday date is not valid");
            return false;
        }else{
            console.log("Birthday date is valid");
            return true;
        }
    }
    
    function validateAll(first_name,last_name,tel,cell,date)
    {
        if(validateField(first_name,last_name) && validateTel(tel) && validateCell(cell) && validateDate(date)){
            $('.alert-danger').html("Update successfully");
            console.log("Form can be sent.");
            return true;
        }else{
            console.log("Form can't be sent");
            return false;
        }


    }
});
