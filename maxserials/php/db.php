<?php 
require_once "rb.php";
$connection = mysqli_connect('127.0.0.1', 'root', '', 'maxserialsdb');
R::setup ('mysql:host=localhost;dbname=maxserialsdb','mysql','mysql');
if ( !R::testConnection() )
{
        exit ('Нет соединения с базой данных');
}
@session_start();
?>