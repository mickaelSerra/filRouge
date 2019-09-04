$(document).ready(function(){

    $('.deleteSecurity').on('click', function() {
       $('.deleteSecurityModal').fadeIn();
    });

    $('.closeModal').on('click', function() {
        $('.deleteSecurityModal').fadeOut();
    });

});