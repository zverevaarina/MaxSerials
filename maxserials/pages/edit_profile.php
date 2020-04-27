<?php require_once "scripts/GetProfile.php"; 
      require_once "scripts/personalnfUser.php";
      require_once "scripts/GetName.php";?>
<!DOCTYPE html>
<html>
<!— Yandex.Metrika counter —>
<script type="text/javascript" >
(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

ym(62333434, "init", {
clickmap:true,
trackLinks:true,
accurateTrackBounce:true,
webvisor:true
});
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/62333434" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!— /Yandex.Metrika counter —>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>МаксимальноСериально</title>
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/add_serial.css">
    </head>
    <body>
        <div>
            <header>
                <a  href="profile_home.php"><img src="../icons/max.png" alt="МаксимальноСериально" width="216.52" heigh="84"></a>
                <input class="search_input" placeholder="Поиск">
                <a class="button_search" href="search.php" >Найти</a>
                <a class="button_serials" href="serials.php" >Сериалы</a>
                <div class="select">
                    <ul>
                        <li>
                            <span><?php echo GetName();?>&#9660</span>
                            <ul>
                                <li><a href="profile.php">Профиль</a></li>
                                <li><a href="profile_serials.php">Мои сериалы</a></li>
                                <li><a href="statistics.php">Статистика</a></li>
                                <li><a href="scripts/logout.php">Выйти</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </header>
        </div>
        
        <h2>Редактирование профиля</h2>
        <div class="b1">
            <form method="post" action="scripts/UpdataProfile.php" enctype="multipart/form-data">
            <table>
                <tr>
                    <?php echo $ans;?>
                    <td><input type ="file" name = "image">Загрузить новый аватар</input></td>
                </tr>
                <tr>
                    <td>Имя</td>
                    <td><input class="inp" name = "name"value =<?php echo $name;?>></td>
                </tr>
                <tr>
                    <td>Почта</td>
                    <td><input class="inp" name = "email" value =<?php echo $email;?>></td>
                </tr>
                <tr>
                    <td>Изменить пароль</td>
                    <td></td>
                </tr>
               <tr>
                    <td>Новый пароль</td>
                    <td><input type = "password" class="inp"name = "password" id ="password"/>
                </tr>
                <tr>
                    <td>Повторите пароль</td>
                    <td><input type = "password" class="inp" name = "password2" id ="password"/>
                </tr>
                
                 <tr>
                    <td>О себе</td>
                    <td><textarea class="inp" name = "fact"><?php echo $fact;?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><div> <button class= "button" type = "submit" name="save">Сохранить</button></div></td>
                </tr>
            </table>
        </div>
      
     
		  </form>
        <div><footer>Контактная информация <a href="mailto:project.site@mail.ru">project.site@mail.ru</a></footer></div>
    </body>
</html>