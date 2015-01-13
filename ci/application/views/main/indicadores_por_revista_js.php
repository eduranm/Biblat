$(document).ready(function() {
    location.hash && 
    $(location.hash).collapse('show') &&
    $('html, body').animate({
        scrollTop: $(location.hash).parent().offset().top
    }, 1000);
});