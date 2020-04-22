<!DOCTYPE html>
<html>
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
                <a class="button_search" href="pages/search.php" >Найти</a>
                <a class="button_serials" href="pages/serials.php" >Сериалы</a>
                <a class="button_login" href="pages/log_in.php">Вход</a>
                <a class="button_signin" href="pages/sign_in.php">Регистрация</a>
        </header>
    </div>
    <form action = "scripts/registration.php" method = "POST">
         <p>
            <label for="name">Имя: </label>
            <input type = "text" autocomplete="off" name = "name" id = "name" required />
        </p>
        <p>
            <label for="email">Email: </label>
            <input type="email" autocomplete="off" placeholder="user@gmail.com" id="email" required name="email" />
        </p>
        <p>
            <label for="password">Пароль: </label>
            <input type = "password" name = "password" id ="password" required/>
        </p>
        <p>
           <button class= "button" type = "submit" name="registration">Регистрация</button>
        </p>
    </form>
    <div><footer>Контактная информация <a href="mailto:project.site@mail.ru">project.site@mail.ru</a></footer></div>
</body>
</html>