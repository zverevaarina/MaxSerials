$(document).ready(function(){

    readOne();
});

function getGET(name) {
    var s = window.location.search;
    s = s.match(new RegExp(name + '=([^&=]+)'));
    return s ? s[1] : false;
}

$(document).on('submit', '#get-note-form', function(e){
    e.preventDefault();
    var tt = JSON.stringify($(this).serializeArray());
    $.ajax({
        url : "http://localhost/prj1/api/user/updateNoteSerial.php",
        type : "POST",
        contentType : 'application/json',
        data : JSON.stringify($(this).serializeArray()),
        success : function(){},
        error: function(xhr, resp, text){
            console.log(xhr, resp, text);
        }
    });
    
});

var userserial_id;
function readOne(){
    
    var id = getGET('s');
    var jwt = getCookie('jwt');
    
    $.post("http://localhost/prj1/api/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result){
        
        
            $.post("http://localhost/prj1/api/user/getratingserial.php", JSON.stringify({ "id": result.data.id, "serial_id":  id})).done(function(data){
                
                userserial_id=data.id;
                if(result.data.email!="admin@gmail.com"){
                var html=`
                    <div class="container text-centre">
                        <div class="row"><h2>` + data.name + `</h2></div>
                        <div class="row"><img src="http://localhost/prj1/api/serial/upload/` + data.photo + `" width="533" height="300" align="left"></div>
                        <div class="row"><p>` + data.description + `</p></div>
                        <div class="row"><p>` + data.fun_facts + `</p></div>
                    </div>
                    <div><button id='showClick' class='btn btn-success marg'>Смотрю</button>
                    <button id='noShowClick' class='btn btn-secondary marg'>Не смотрю</button></div>
                `;

                $.post("http://localhost/prj1/api/user/clickshow.php", JSON.stringify({"user_id" : result.data.id, "serial_id" : id})).done(function(res_list){
                    
                    if(res_list.note==1){
                        html+=`
                            <form id="get-note-form">
                            <button type='submit' id='save-note' class='btn btn-success marg'>Сохранить изменения</button>
                        `;

                        $.each(res_list, function(key, val){
                            if(key!="note"){
                            html+=`
                                <div>
                                    <div class="get-note">
                                        <input type="checkbox" id="checkbox_check` + val.id + `" name="` + val.id + `" value="1" ` + getChecked(val.note) + `></div>
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
                            `;}
                        });

                        html+=stars(data.ratingU);
                    }

                    $('#content').html(html);
                })
                .fail(function(xhr, resp, text){console.log(xhr, resp, text);});
                $('#content').html(html);
            }else{
                var html=`
                    <div class="container text-centre">
                        <div class="row"><h2>` + data.name + `</h2></div>
                        <div class="row"><img src="http://localhost/prj1/api/serial/upload/` + data.photo + `" width="533" height="300" align="left"></div>
                        <div class="row"><p>` + data.description + `</p></div>
                        <div class="row"><p>` + data.fun_facts + `</p></div>
                    </div>`;
                $('#content').html(html);
            }
        });
        showLoggedInMenu();
    })
        
    .fail(function(){
        
        //var user_rating;
        $.getJSON("http://localhost/prj1/api/serial/readOne.php?s=" + id, function(result){

            var html=`
                    <div class="container text-centre">
                        <div class="row"><h2>` + result.name + `</h2></div>
                        <div class="row"><img src="http://localhost/prj1/api/serial/upload/` + result.photo + `" width="533" height="300" align="left"></div>
                        <div class="row"><p>` + result.description + `</p></div>
                        <div class="row"><p>` + result.fun_facts + `</p></div>
                    </div>
            `;
            $('#content').html(html);
        }); 
        showLoggedOutMenu();
    });
    
}

function stars(val){
    var html=`<div>`;
    let i;
    for(i = 1; i<=val; i++){
        html+=`<button type='button' id="rating-` + i  + `" class='btn'><img src="http://localhost/prj1/icons/star.png" width="21" heigh="21"></button>`;
    }
    for(i; i<=5; i++){
        html+=`<button type='button' id="rating-` + i  + `" class='btn'><img src="http://localhost/prj1/icons/empty_star.png" width="21" heigh="21"></button>`;
    }
    html+=`</div>`;
    return html;
}

$(document).on('click','#rating-1', function(){
    
    var id = getGET('s');
    
    $.post("http://localhost/prj1/api/user/updateratingserial.php", JSON.stringify({"id":userserial_id, "serial_id":id,"ratingU":"1"})).done(function(){
        readOne();
    });
    
});

$(document).on('click','#rating-2', function(){
    
    var id = getGET('s');
    
    $.post("http://localhost/prj1/api/user/updateratingserial.php", JSON.stringify({"id":userserial_id, "serial_id":id,"ratingU":"2"})).done(function(){
        readOne();
    });
    
});

$(document).on('click','#rating-3', function(){
    
    var id = getGET('s');
    
    $.post("http://localhost/prj1/api/user/updateratingserial.php", JSON.stringify({"id":userserial_id, "serial_id":id,"ratingU":"3"})).done(function(){
        readOne();
    });
    
});

$(document).on('click','#rating-4', function(){
    
    var id = getGET('s');
    
    $.post("http://localhost/prj1/api/user/updateratingserial.php", JSON.stringify({"id":userserial_id, "serial_id":id,"ratingU":"4"})).done(function(){
        readOne();
    });
    
});

$(document).on('click','#rating-5', function(){
    
    var id = getGET('s');
    
    $.post("http://localhost/prj1/api/user/updateratingserial.php", JSON.stringify({"id":userserial_id, "serial_id":id,"ratingU":"5"})).done(function(){
        readOne();
    });
    
});

$(document).on('click','#showClick', function(){
    
    var id = getGET('s');
    var jwt = getCookie('jwt');
    $.post("http://localhost/prj1/api/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(data){
    
    var ttt=JSON.stringify({"user_id":data.data.id ,"serial_id":id});
        $.ajax({
            url : "http://localhost/prj1/api/user/clickyes.php",
            type : "POST",
            contantData : 'application/json',
            data : JSON.stringify({"user_id":data.data.id ,"serial_id":id}),
            success : function(){
                readOne();
            },
            error : function(xhr, resp, text){console.log(xhr, resp, text);}
        });
    });
});

$(document).on('click','#noShowClick', function(){
    
    var id = getGET('s');
    var jwt = getCookie('jwt');
    $.post("http://localhost/prj1/api/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(data){
    
    var ttt=JSON.stringify({"user_id":data.data.id ,"serial_id":id});
        $.ajax({
            url : "http://localhost/prj1/api/user/clickno.php",
            type : "POST",
            contantData : 'application/json',
            data : JSON.stringify({"user_id":data.data.id ,"serial_id":id}),
            success : function(){
                readOne();
            },
            error : function(xhr, resp, text){console.log(xhr, resp, text);}
        });
    });
});

function getChecked(val){
    if(val==1){return "checked";}
    return "";
}

