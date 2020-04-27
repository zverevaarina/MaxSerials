<?php 
   require "scripts/personalnfUser.php";
    require "scripts/GetName.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>МаксимальноСериально</title>
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/profile.css">
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
                                <li><a href="../index.php">Выйти</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </header>
        </div>
        
        <table>
            <tr>
                <td rowspan="3">
               <?php echo GetPersonalInf();?>
            <tr>
                <td><a href="edit_profile.php" class="edit">Редактировать профиль</a></td>
            </tr>
        </table>
		
        <div><footer>Контактная информация <a href="mailto:project.site@mail.ru">project.site@mail.ru</a></footer></div>
    </body>
</html>