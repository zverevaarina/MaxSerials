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
    <link rel="stylesheet" href="../css/log_in.css">
</head>
<body>
    <div>
        <header>
            <a  href="../index.html"><img src="../icons/max.png" alt="МаксимальноСериально" width="216.52" heigh="84"></a>
            <input class="search_input" placeholder="Поиск">
            <a class="button_search" href="search.php" >Найти</a>
            <a class="button_serials" href="serials.php" >Сериалы</a>
            <a class="button_login" href="log_in.php">Вход</a>
            <a class="button_signin" href="sign_in.php">Регистрация</a>
        </header>
    </div>
   <form action="scripts/login.php" method="POST">
            <div class="">
                <p><label for="email" ></label></p>
                <input type="email" id ="email" name="email" placeholder="Введите email" value="<?php echo @$data['email']; ?>">

                <p><label for="password" ></label></p>
                <input type="password" id="password" name="password" placeholder="Введите пароль">

                <p><button class="dws-submit" type="submit" name="do_login">Войти</button></p>
            </div>
    </form>
    <a href="admin_home.html">Имитация входа админа</a>


    <div><footer>Контактная информация <a href="mailto:project.site@mail.ru">project.site@mail.ru</a></footer></div>
</body>
</html>