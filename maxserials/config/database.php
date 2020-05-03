<?php
require_once "rb.php";
class Database{
	public function getConnection(){
		$connection = mysqli_connect('localhost', 'root', '', 'maxserialsbd');
		R::setup ('mysql:host=localhost;dbname=maxserialsbd','root','');
		if ( !R::testConnection() )
		{
		    exit ('Нет соединения с базой данных');
		}
		return $connection;
    }
}
//@session_start();
?>