var sel_did = null;
var sel_tid = null;
var date = null;

function get_opiniontimes()
{
    if(sel_did != null && sel_tid != null && date != null && date != '')
    {
        $.ajax({
            url: '/write/timeoption/',
            method: 'POST',
            data: {did: sel_did, date: date},
            success: function(data){
                var json = JSON.parse(data); 
                $('.options').each(function( index, element ) {
                    $( element ).prop('disabled', true);
                });
    
                $(Object.values(json)).each(function(index, el)
                {
                    $('.option-'+el).removeAttr('disabled');
                });
            },
            error: alert
        });
        $('#option_sel').removeAttr('disabled');
    }
}

$(document).ready(function(){
    $('#date_sel').change(function(){
        date = $(this).val();
        get_opiniontimes();
    });

    $('#type_sel').change(function(){
        sel_tid = $(this).val();
        $('.doctor-types').each(function( index, element ) {
            $( element ).hide();
        });
        $('.doctor-type-'+sel_tid).each(function( index, element ) {
            $( element ).show();
        });
        $('#doctor_sel').removeAttr('disabled');
        get_opiniontimes();
    });

    $('#doctor_sel').change(function(){
        sel_did = $(this).val();
        date = $('#date_sel').val();
        get_opiniontimes();
    });

    $('.form-action.write').submit(function(e) {

        e.preventDefault();
    
        var form = $(this);
        var url = form.attr('action');
        var errors = false;

        var doctor_sel = $('#doctor_sel').val();
        var option_sel = $('#option_sel').val();
        
        if(doctor_sel == null && !errors)
        {
            alert('Выберите доктора');
            errors = true;
        }

        if(option_sel == null && !errors)
        {
            alert('Выберите время записи');
            errors = true;
        }

        if(!errors)
        {
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(data)
                {
                    if(data == 'success')
                    {
                        $(location).attr('href', '/profile/');
                    }
                    else
                    {
                        alert(data);
                    }
                }
            });
        }
    });

    $('.write').each(function(index, el){
        var wid = $(this).attr('wid');
        var date1 = new Date();
        var date2 = new Date($(el).find('.date').text() + ' ' + $(el).find('.time').text());

        var diff = date2 - date1;
        var days = Math.ceil(diff / 1000 / 60 / 60 / 24);

        if(days <= 0)
        {
            $(el).addClass('past-w');
        }
        else
        {
            $(el).addClass('future-w');
        }

        if(days <= 1)
        {
            $(el).find('.action').hide();
        }
        else
        {
            $(el).find('.action').click({wid: wid}, function(e){
                $.ajax({
                    type: "POST",
                    url: '/write/cancel/',
                    data: {wid: e.data.wid},
                    success: function(data)
                    {
                        if(data == 'success')
                        {
                            $(location).attr('href', '/profile/');
                        }
                        else
                        {
                            alert(data);
                        }
                    }
                });
            });
        }
    });

    $('#tab_future').click(function(){
        $('.past-w').each(function( index, element ) {
            $( element ).hide();
        });
        $('.future-w').each(function( index, element ) {
            $( element ).show();
        });
    });
    $('#tab_past').click(function(){
        $('.past-w').each(function( index, element ) {
            $( element ).show();
        });
        $('.future-w').each(function( index, element ) {
            $( element ).hide();
        });
    });
    $('#tab_all').click(function(){
        $('.write').each(function( index, element ) {
            $( element ).show();
        });
    });
});