<?php 
    require "scripts/GetName.php";
    require "scripts/GetMyList.php";
?>
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
        <link rel="stylesheet" href="../css/view.css">
    </head>
    <body>
        <div>
             <header>
            <a href="/"><img src="../icons/max.png" alt="МаксимальноСериально" width="216.52" heigh="84"></a>
            <input class="search_input" placeholder="Поиск">
            <a class="button_search" href="pages/search.php" >Найти</a>
            <a class="button_serials" href="pages/serials.php" >Сериалы</a>
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
        
        <table class="info">
            <tr>
                <td><h1>Детство Шелдона</h1></td>
                <td></td>
            </tr>
            <tr>
                <td><img src="../icons/sheldon.jpg" width="533" heigh="299"></td>
                <td><h3>Описание</h3>Главный герой «Детства Шелдона» — девятилетний Шелдон Купер, один из персонажей ситкома «Теория большого взрыва». Мальчик живет в Восточном Техасе, ходит в обычную школу и пытается вписаться в окружающий его мир. Но из-за высоких интеллектуальных способностей Шелдону не удается нормально взаимодействовать со сверстниками.</td>
            </tr>
            <tr>
                <td></td>
                <td><h3>Интересный факт</h3>Актриса Зои Перри, которая играет мать молодого Шелдона на самом деле является дочерью актрисы Лори Меткаф, которая играет мать взрослого Шелдона Купера в сериале «Теория большого взрыва»</td>
            </tr>
        </table>
        
		
        <div><footer>Контактная информация <a href="mailto:project.site@mail.ru">project.site@mail.ru</a></footer></div>
    </body>
</html>