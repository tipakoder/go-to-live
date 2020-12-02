$(document).ready(function(){
    $('.link').click(function(){
        $(location).attr('href', $(this).attr('href'));
    });
});