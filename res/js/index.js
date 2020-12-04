$('.page-tab').click(function(){
    let pid = $(this).attr('pid');
    $('.card').each(function(index, el){
        $(el).hide();
    });
    $('.card-page-'+pid).each(function(index, el){
        $(el).show();
    });
});