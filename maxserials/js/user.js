function showAccount(){

    clearResponse();
    $('#response').html('');
    var jwt = getCookie('jwt');
    $.post("http://localhost/prj1/api/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
        
        if(result.data.email!="admin@gmail.com"){
            var html = `
                <div class="container text-centre marg">
                    <div class="row ">
                        <div class="col"><img src="http://localhost/prj1/api/user/upload/` + result.data.photo + `" weight=300 height=300></div>
                        <div class="col">
                            <div><h2>` + result.data.name + `</h2></div>
                            <div><h2>` + result.data.email + `</h2></div>
                            <div><h3>` + result.data.facts + `</h3></div>
                            <div><a href="#" class="btn btn-secondary btn-lg active" id="update-account">Редактировать профиль</a></div>
                        </div>
                    </div>
                </div>`;
            

        
            let percent = new Array;
            $.post("http://localhost/prj1/api/user/getstatistics.php", JSON.stringify({ "user_id":result.data.id })).done(function(stat_list){
                percent = stat_list;

                $.post("http://localhost/prj1/api/user/getUserSerialList.php", JSON.stringify({ "id":result.data.id })).done(function(res_list){
                    if(!isEmpty(res_list)){
                        
                        html+=`
                            <div class="container marg">
                                <div class="row ">
                                    <div class"col"><h2>Мои сериалы</h2></div>
                                </div>
                            </div>
                        `;

                        var result_list = JSON.parse(res_list);
                        html+=`<div class="container marg">`;

                        $.each(result_list, function(key, val){
                            var p = getPercent(percent[key].percent);

                            html+=`
                                <div class="row">
                                    <div class="get-note col">
                                        <label><a href="http://localhost/prj1/pages/view.html?s=` + val.id +`/">` + val.name + `</a></label>
                                    </div>

                                    <div class="get-note col">
                                        <label>` + getStars(val.rating) + `</label>
                                    </div>

                                    <div class="get-note col">
                                        <label>` + val.genre + `</label>
                                    </div>

                                    <div class="get-note col">
                                        <label>` + val.year + `</label>
                                    </div>

                                    <div class="get-note col">
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: ` + p + `%" aria-valuenow="` + p + `" aria-valuemin="0" aria-valuemax="100">` + p + `%</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        html+=`</div>`;
                        clearResponse();
                        $('#content').html(html);
                    }else{
                        html+=`<h2>Ты еще не смотришь сериалы, присмотрись к лучшим</h2>`;
                        $.getJSON("http://localhost/prj1/api/serial/topSerials.php", function(data){

                            $.each(data, function(key, val){
                                html+=`
                                    <div class="get-note">
                                        <div>
                                        <a href="http://localhost/prj1/pages/view.html?s=` + val.id +`"><img src="http://localhost/prj1/api/serial/upload/` + val.photo + `" width="250" heigh="140"></a></div>
                                        <div><a href="http://localhost/prj1/pages/view.html?s=` + val.id +`">` + val.name + `</a>
                                        </div>
                                    </div>
                                `;
                            });
                            $('#content').html(html);
                        });
                    }
                })
                .fail(function(){
                    html+=`<h2>Ты еще не смотришь сериалы, присмотрись к лучшим</h2>`;
                    $.getJSON("http://localhost/prj1/api/serial/topSerials.php", function(data){

                        $.each(data, function(key, val){
                            html+=`
                                <div class="get-note">
                                    <div>
                                    <a href="http://localhost/prj1/pages/view.html?s=` + val.id +`"><img src="http://localhost/prj1/api/serial/upload/` + val.photo + `" width="250" heigh="140"></a></div>
                                    <div><a href="http://localhost/prj1/pages/view.html?s=` + val.id +`">` + val.name + `</a>
                                    </div>
                                </div>
                            `;
                        });


                        $('#content').html(html);
                    });
                });
            })
            .fail(function(){concole.log("sad");});
        }else{
            var html = `
                <div class="container text-centre marg">
                    <div class="row ">
                        <div class="col">
                            <div><h2>` + result.data.name + `</h2></div>
                            <div><h2>` + result.data.email + `</h2></div>
                        </div>
                    </div>
                </div>`

            $('#content').html(html);
        }
    })

    .fail(function(result){
        showLoginPage();
        $('#response').html("<div class='alert alert-danger'>Пожалуйста, авторизуйтесь</div>");
    });
}

$(document).on('click', '#update-account', function(e){
    showUpdateAccountForm();
});

$(document).on('submit', '#update_account_form', function(e){
    
    e.preventDefault();
    var form = $('#update_account_form')[0];
    var formData = new FormData(form);
    formData.append('file', $('#file').prop("files")[0]);
    var jwt = getCookie('jwt');
    formData.append('jwt', jwt);
    console.log(formData.getAll('jwt'));
    console.log(formData.getAll('name'));
    $.ajax({
        url: "http://localhost/prj1/api/user/update_user.php",
        type : "POST",
        contentType : false,
        processData: false,
        cache: false,
        data : formData,
        success : function(result) {
            setCookie("jwt", result.jwt, 1);
            showAccount();
        },
        error : function(xhr, resp, text){
            console.log(xhr, resp, text);
        }
    });

    return false;
});

function showUpdateAccountForm(){

    var jwt = getCookie('jwt');
    $.post("http://localhost/prj1/api/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {

        var html = `
            <h2>Редактирование профиля</h2>
            <form id='update_account_form'>
                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" class="form-control" name="name" id="name" autocomplete="off" required value="` + result.data.name + `" />
                </div>

                <div class="form-group">
                    <label for="facts">Факты обо мне</label>
                    <input type="text" class="form-control" name="facts" id="facts" autocomplete="off" required value="` + result.data.facts + `" />
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" autocomplete="off" required value="` + result.data.email + `" />
                </div>

               <div class="form-group">
                    <img src="http://localhost/prj1/api/user/upload/` + result.data.photo + `" width="300" height="300" class="marg">
                    <input type="file" class="form-control marg" name="file" id="file" />
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" name="password" id="password" autocomplete="off" required/>
                </div>
                <button type='submit' class='btn btn-success'>Сохранить изменения</button>
            </form>
        `;

        clearResponse();
        $('#content').html(html);
        })

    .fail(function(result){
        showLoginPage();
        $('#response').html("<div class='alert alert-danger'>Пожалуйста, авторизуйтесь.</div>");
    });
}

function getCookie(cname){
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' '){
            c = c.substring(1);
        }

        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getStars(rating){
    var html=``;
    for(let i = 0; i<rating; i++){
        html+=`<img src="http://localhost/prj1/icons/star.png" width="21" heigh="21">`
    }
    return html;
}

function getPercent(val){
    var p = 100-val;
    return p;
}

function isEmpty(obj) {
    if(obj.length<3){
        return true;
    }
    return false;
}