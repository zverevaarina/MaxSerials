<?php 
require_once "rb.php";
$connection = mysqli_connect('localhost', 'f0432740_MAX_BD', 'MAXBD', 'f0432740_MAX_BD');
R::setup ('mysql:host=localhost; dbname=f0432740_MAX_BD','f0432740_MAX_BD','MAXBD');
if ( !R::testConnection() )
{
        exit ('Нет соединения с базой данных');
}
@session_start();
?>