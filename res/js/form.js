$(document).ready(function(){
    $('.form-action.reg').submit(function(e) {

        e.preventDefault();
        //определение осн. переменных запроса
        let form = $(this);
        let url = form.attr('action');
        //переменные для всевозможных проверок
        var formData = new FormData();
        let firstname = $('[name="firstname"]').val();
        formData.append('firstname', firstname);
        let lastname = $('[name="lastname"]').val();
        formData.append('lastname', lastname);
        let middlename = $('[name="middlename"]').val();
        formData.append('middlename', middlename);
        let email = $('[name="email"]').val();
        formData.append('email', email);
        let password = $('[name="password"]').val();
        let passwordR = $('[name="passwordR"]').val();
        formData.append('password', password);
        let photo = $('[name="photo"]');
        formData.append('photo', $(photo).prop('files')[0]);
        console.log(formData);
        let error = false;
        //паттерны регулярных выражений
        let reg_rgx_name = new RegExp('^[?!,.а-яА-ЯёЁ0-9\s]+$');
        let reg_rgx_email = new RegExp('[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+');
        let reg_egx_passwd = new RegExp('[a-zA-Z]+');
        //проврека ФИО на содержание только кириллицы и знаков препинания
        if(!reg_rgx_name.test(firstname) && !reg_rgx_name.test(lastname) && !reg_rgx_name.test(middlename) && !error)
        {
            alert("ERROR: ФИО должны содержать только кириллицу и знаки препинания."); 
            error = true;
        }
        //проврека email на валидность
        if(!reg_rgx_email.test(email) && !error)
        {
            alert("ERROR: Введите валидный email.");
            error = true;
        }
        //проврека пароля на валидность
        if(!reg_egx_passwd.test(password) && !error)
        {
            alert("ERROR: Пароль должен содержать символы только латинской раскладки."); 
            error = true;
        }
        //проврека пароля на валидность
        if(password.length < 6 && !error)
        {
            alert("ERROR: Пароль должен содержать 6 и более символов."); 
            error = true;
        }
        //проверка на совпадение пароля
        if(password != passwordR && !error)
        {
            alert("ERROR: Пароли не совпадают."); 
            error = true;
        }
        //отправка ajax запроса
        if(!error)
        {
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
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

    $('.form-action.login').submit(function(e) {

        e.preventDefault();
    
        var form = $(this);
        console.log(form.serialize());
        var url = form.attr('action');
        
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
    
    });
});