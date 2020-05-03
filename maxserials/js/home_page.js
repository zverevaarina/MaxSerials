$(document).ready(function(){
    //if(check()){showHomePage();}
    showHomePage();
});
//
//function check(){
//    if(window.location=="http://localhost/prj1/"||
//       window.location=="http://localhost/prj1/#"||
//       window.location=="http://localhost/prj1/index.html"||
//       window.location=="http://localhost/prj1/index.html/#"){return true;}
//    return false;
//}

$(document).on('click', '#home', function(){
    showHomePage();
    clearResponse();
});

$(document).on('submit', '#get-note-form', function(){
    
    $.ajax({
        url : "http://localhost/prj1/api/user/updateNoteSerial.php",
        type : "POST",
        contentType : 'application/json',
        data : JSON.stringify($(this).serializeArray()),
        success : function(){
            alert("yess");
        },
        error: function(xhr, resp, text){
            console.log(xhr, resp, text);
        }
    });
    
});

function showHomePage(){
    
    var jwt = getCookie('jwt');
    $.post("http://localhost/prj1/api/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
        if(result.data.email=="admin@gmail.com"){$('#content').html("<h2>Настройки администратора</h2>");}
        else{
            $.ajax({
                url : "http://localhost/prj1/api/user/getNotNote.php",
                type : "POST",
                contentType : 'application/json',
                data : JSON.stringify({"id":result.data.id}),
                success : function(res){
                    var json_parse = JSON.parse(res);
                    var html=`<form id='get-note-form'>
                        <button type='submit' class='btn btn-success marg'>Сохранить изменения</button>`;
                    $.each(json_parse, function(key, val){
                            html+=`
                                <div class="marg">
                                    <div class="get-note">
                                        <input type="checkbox" name="` + val.id + `" value="1">
                                    </div>
                                    <div class="get-note">
                                        <label>` + val.serial_name + `</label>
                                    </div>
                                    <div class="get-note">
                                        <label>S` + val.season_num + `E` + val.episode_num + `</label>
                                    </div>
                                    <div class="get-note">
                                        <label>` + val.name + `</label>
                                    </div>
                                    <div class="get-note">
                                        <label>` + val.date + `</label>
                                    </div>
                                </div>
                            `;
                    });
                    html+=`</form>`;
                    $('#content').html(html);
                },
                error : function(){
                    var html=`<h2>Новых серий нет</h2>`;
                    $.getJSON("http://localhost/prj1/api/serial/topSerials.php", function(data){
                        html+=`<h2>Сериалы с лучшим рейтингом</h2>`;
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
            });
        }
        showLoggedInMenu();
    })
    .fail(function(result){
        var html = `
            <div class="text-center row marg">
                <div class="col"><img src="icons/do-list.png" width="70" heigh="70" valign=middle> Составляй свой список сериалов</div>
                <div class="col"><img src="icons/star.png" width="70" heigh="70" valign=middle> Оценивай и комментируй</div>
                <div class="w-100"></div>
                <div class="col"><img src="icons/list.png" width="70" heigh="70" valign=middle> Отмечай просмотренные серии</div>
                <div class="col"><img src="icons/calendar.png" width="70" heigh="70" valign=middle> Отслеживай даты выхода серий</div>
            </div>
            <div class="text-center marg">
                <div><a class="btn btn-success btn-sm" href="#" id='sign_up'>Регистрируйся!</a></div>
                <div>Уже с нами?<a href="#" id='login'>Войти</a></td></tr></div>
            </div>
        `;
        $.getJSON("http://localhost/prj1/api/serial/topSerials.php", function(data){
            html+=`<div class="text-center marg"><h2>Сериалы с лучшим рейтингом</h2>`;
            $.each(data, function(key, val){
                html+=`

                    <div class="get-note">
                        <div><a href="http://localhost/prj1/pages/view.html?s=` + val.id +`"><img src="http://localhost/prj1/api/serial/upload/` + val.photo + `" width="250" heigh="140"></a></div>
                        <div><a href="http://localhost/prj1/pages/view.html?s=` + val.id +`">` + val.name + `</a>
                        </div>
                    </div>
                `;
            });

            html+=`</div>`;
            $('#content').html(html);
        });
        
    });
    showLoggedOutMenu();

    $('#response').html('');
}
