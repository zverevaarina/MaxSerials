$(document).on('submit', '#search-serial-form', function(){
    
    var keywords = $(this).find(":input[name='keywords']").val();

    $.getJSON("http://localhost/prj1/api/serial/search.php?s=" + keywords, function(data){
        showSerialList(data);
 
    });
        return false;
});

$(document).on('click', '#sign_up', function(){

    var html = `
        <h2>Регистрация</h2>
        <form id='sign_up_form'>
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" class="form-control" name="name" id="name" autocomplete="off" required />
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" autocomplete="off" required />
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" name="password" id="password" required />
            </div>

            <button type='submit' class='btn btn-success'>Зарегистрироваться</button>
        </form>
        `;

    clearResponse();
    $('#content').html(html);
});

$(document).on('submit', '#sign_up_form', function(){

    var sign_up_form=$(this);
    var form_data=JSON.stringify(sign_up_form.serializeObject());

    $.ajax({
        url: "http://localhost/prj1/api/user/create_user.php",
        type : "POST",
        contentType : 'application/json',
        data : form_data,
        success : function(result) {
            $('#response').html("<div class='alert alert-success'>Регистрация прошла успешно. Пожулауйста, авторизуйтесь</div>");
            sign_up_form.find('input').val('');
        },
        error: function(xhr, resp, text){
            $('#response').html("<div class='alert alert-danger'>Ошибка регистрации</div>");
        }
    });

    return false;
});

$(document).on('click', '#login', function(){
    showLoginPage();
});

$(document).on('submit', '#login_form', function(){

    var login_form=$(this);
    var form_data=JSON.stringify(login_form.serializeObject());

    $.ajax({
        url: "http://localhost/prj1/api/login.php",
        type : "POST",
        contentType : 'application/json',
        data : form_data,
        success : function(result){
            setCookie("jwt", result.jwt, 1);
            showLoggedInMenu();
            showAccount();
        },
        error: function(xhr, resp, text){
        $('#response').html("<div class='alert alert-danger'>Email или пароль указаны неверно.</div>");
        login_form.find('input').val('');
    }
    });

    return false;
});

$(document).on('click', '#account', function(){
    showAccount();
});


$(document).on('click', '#logout', function(){
    showLoginPage();
});

function showLoginPage(){

    setCookie("jwt", "", 1);

    var html = `
        <h2>Авторизация</h2>
        <form id='login_form'>
            <div class='form-group'>
                <label for='email'>Email</label>
                <input type='email' class='form-control' id='email' name='email' autocomplete="off">
            </div>

            <div class='form-group'>
                <label for='password'>Пароль</label>
                <input type='password' class='form-control' id='password' name='password' autocomplete="off">
            </div>

            <button type='submit' class='btn btn-success'>Войти</button>
        </form>
    `;

    $('#content').html(html);
    clearResponse();
    showLoggedOutMenu();
}


function showLoggedOutMenu(){

    $("#login, #sign_up").show();
    $("#account").hide();
    $("#logout").hide();
}

function showLoggedInMenu(){

    $("#login, #sign_up").hide();
    $("#logout").show();
    $("#account").show();
}

$.fn.serializeObject = function(){

    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function clearResponse(){
    $('#response').html('');
}