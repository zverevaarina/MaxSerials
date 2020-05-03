function showSerialList(data){
    var jwt = getCookie('jwt');
    $.post("http://localhost/prj1/api/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result){
        showLoggedInMenu();
        if(result.data.email=="admin@gmail.com"){
            showAdminList(data); 
        }
        else{
            showList(data);
        }
        
    })
    .fail(function(result){
        showLoggedOutMenu();
        showList(data);
    });
}

function showAdminList(data){
    var read_serials_html =`
        <table>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <a href="#" id='create-serial'>Создать сериал</a>
                </td>

            </tr>
        `;
        $.each(data, function(key, val){
            read_serials_html+=`
            <tr>
                <td><a href="http://localhost/prj1/pages/view.html?s=` + val.id +`">` + val.name + `</a></td>
                <td>` + val.genre + `</td>
                <td>` + val.year + `</td>
                <td><a href="#" id='update-serial' data-id='` + val.id + `'>Редактировать сериал</a></td>
                <td><a href="#" id='delete-serial' data-id='` + val.id + `'>Удалить сериал</a></td>

            </tr>`;
        });

        read_serials_html+=`</table>`;
        $("#content").html(read_serials_html);
        $('#response').html('');
}
    
function showList(data){
    var read_serials_html=``;
            $.each(data, function(key, val){
                read_serials_html+=`

                    <div class="container">
                      <div class="row">
                        <div class="col">
                          <a href="http://localhost/prj1/pages/view.html?s=` + val.id +`">` + val.name + `</a>
                        </div>
                        <div class="col">
                          ` + getStars(val.rating) + `
                        </div>
                        <div class="col">
                          ` + val.genre + `
                        </div>
                        <div class="col">
                          ` + val.year + `
                        </div>
                      </div>
                    </div>
                `;
            });
            $("#content").html(read_serials_html);
            $('#response').html('');
}
$(document).on('click', '#update-serial', function(){

    var id = $(this).attr('data-id');
    $.getJSON("http://localhost/prj1/api/serial/readOne.php?s=" + id, function(result){

        var update_serial=`
            <form id='update-serial-form' >
                <div class="form-group marg">
                    <label>Название</label>
                    <input type="text" class="form-control" name="name" id="name" autocomplete="off" required value="` + result.name + `" />
                </div>
                <div class="form-group marg">
                    <label>Год</label>
                    <input type="text" class="form-control" name="year" id="year"      autocomplete="off" required value="` + result.year + `" />
                </div>
                <div class="form-group marg">
                    <label>Жанр</label>
                    <input type="text" class="form-control" name="genre" id="genre" autocomplete="off" required value="` + result.genre + `" />
                </div>
                <div class="form-group marg">
                    <label>Страна</label>
                    <input type="text" class="form-control" name="country" id="country" autocomplete="off" required value="` + result.country + `" />
                </div>
                <div class="form-group marg">
                    <label>Описание</label>
                    <input type="text" class="form-control" name="description" id="description" autocomplete="off" required value="` + result.description + `" />
                </div>
                <div class="form-group marg">
                    <label>Интересный факт</label>
                    <input type="text" class="form-control" name="fun_facts" id="fun_facts" autocomplete="off" required value="` + result.fun_facts + `" />
                </div>
                <div class="form-group" hidden>
                    <label>id</label>
                    <input type="text" class="form-control" name="id" id="id" required value="` + result.id + `" />
                </div>
               <div class="form-group">
                    <img src="http://localhost/prj1/api/serial/upload/` + result.photo + `" width="533" height="300" class="marg">
                    <input type="file" class="form-control marg" name="file" id="file" />
                </div>
                
                <button type='submit' class='btn btn-success marg'>Сохранить изменения</button>
            </form>
            <button id="create-episode"  class='btn btn-success marg'>Добавить серию</button>
        `;

        $('#content').html(update_serial);
    });

});

$(document).on('submit', '#update-serial-form', function(e){
    
    e.preventDefault();
    var form = $('#update-serial-form')[0];
    var formData = new FormData(form);
    formData.append('file', $('#file').prop("files")[0]);
    console.log(formData.getAll("year"));
    $.ajax({
        url: "http://localhost/prj1/api/serial/update.php",
        type : "POST",
        contentType : false,
        processData: false,
        cache: false,
        data : formData,
        success : function(result) {
             $.getJSON("http://localhost/prj1/api/serial/read.php", function(data){
                showSerialList(data);
             });
        },
        error : function(xhr, resp, text){console.log(xhr, resp, text);}
    });
    return false;
});

$(document).on('click', '#delete-serial', function(){
    var json_id = JSON.stringify({ id: $(this).attr('data-id') });
    bootbox.confirm({
        message : "Удалить сериал?",
        buttons : {
            confirm : {
                label : 'Да',
                className : 'btn-success'
            },
            cancel : {
                label : 'Нет',
                className : 'btn-primery'
            }
        },
        callback : function(result){
            if(result){
                $.ajax({
                    url : "http://localhost/prj1/api/serial/delete.php",
                    type : "POST",
                    contentType : 'application/json',
                    data : json_id,
                    success : function(res){
                        $.getJSON("http://localhost/prj1/api/serial/read.php", function(data){
                            showSerialList(data);
                        });
                    },
                    error : function(xhr, resp, text){
                        console.log(xhr, resp, text);
                    } 
                });
            }
        }

    });
});

$(document).on('click', '#create-serial', function(){
    var create_serial=`
        <h2>Создание сериала</h2>
        <form id='create-serial-form' action='#' method='post'>
            <div class="form-group">
                <label>Название</label>
                <input type="text" class="form-control" name="name" autocomplete="off" required />
            </div>

            <div class="form-group">
                <label>Год</label>
                <input type="text" class="form-control" name="year" id="year" autocomplete="off" required />
            </div>

            <div class="form-group">
                <label>Описание</label>
                <input type="text" class="form-control" name="description" id="description" autocomplete="off" required />
            </div>

            <div class="form-group">
                <label>Интересный факт</label>
                <input type="text" class="form-control" name="fun_facts" id="fun_facts" autocomplete="off" required />
            </div>

            <div class="form-group">
                <label>Страна</label>
                <input type="text" class="form-control" name="country" id="country" required autocomplete="off" />
            </div>

            <div class="form-group">
                <label for="genre">Жанр</label>
                <input type="text" class="form-control" name="genre" id="genre" autocomplete="off" required />
            </div>
           <div class="form-group">
                <label>Фото</label>
                <input type="file" class="form-control" name="file" id="file" required />
            </div>

            <button type='submit' class='btn btn-success'>Добавить</button>
        </form>

    `;

    clearResponse();
    $("#content").html(create_serial);
});

$(document).on('submit', '#create-serial-form', function(e){
    
    e.preventDefault();
    
    var form = $('#create-serial-form')[0];
    var formData = new FormData(form);
    formData.append('file', $('#file').prop("files")[0]);
    console.log(formData.getAll('file'));
    $.ajax({
        url: "http://localhost/prj1/api/serial/create.php",
        type : "POST",
        contentType : false,
        processData: false,
        cache: false,
        data : formData,
        success : function(result) {
            //console.log("yes");
             $.getJSON("http://localhost/prj1/api/serial/read.php", function(data){
                showSerialList(data);
             });
        },
        error : function(xhr, resp, text){
            console.log(xhr, resp, text);
        }
    });

    return false;
});

$(document).on('click', '#create-episode', function(){
    
    var html =`
        <h2>Добавление серии</h2>
        <form id='create-episode-form' action='#' method='post'>
            <div class="form-group">
                <label>Сезон</label>
                <input type="text" class="form-control" name="season_num" id="season_num" autocomplete="off" required />
            </div>
            <div class="form-group">
                <label>Серия</label>
                <input type="text" class="form-control" name="episode_num" id="episode_num" autocomplete="off" required />
            </div>
            <div class="form-group">
                <label>Название</label>
                <input type="text" class="form-control" name="name" id="name" autocomplete="off" required />
            </div>
            <div class="form-group">
                <label>Дата выхода</label>
                <input type="date" class="form-control" name="date" id="date" autocomplete="off" required />
            </div>
            <div class="form-group" hidden>
                <label>id</label>
                <input type="text" class="form-control" name="serial_id" id="serial_id" required value="` + $('#id').val() + `" />
            </div>
            <div>
                <button type='submit' class='btn btn-success marg'>Добавить серию</button>
            </div>
        </form>
    `;
    
    clearResponse();
    $('#content').append(html);
});

$(document).on('submit', '#create-episode-form', function(){
    
    var form_data=JSON.stringify($(this).serializeObject());
    $.ajax({
        url: "http://localhost/prj1/api/episode/create.php",
        type : "POST",
        contentType : 'application/json',
        data : form_data,
        success : function(result){
            alert("Серия добавлена");
        },
        error : function(xhr, resp, text){
            console.log(xhr, resp, text);
        }
    });
    return false;
});