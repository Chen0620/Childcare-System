$(document).ready(function(){
    if($('.usertype').val() == "Admin"){
        $('.payroll').hide();
        $('.tuition').hide();
    }
    if($('.usertype').val() == "rec_treasurer"){
        $('.payroll').hide();
        $('.tuition').hide();
        $('.user_management').hide();
        $('.members').hide();
    }
}); 
