<?php 
	require "db.php";
	//Убираем пользователя из залогиненных
	unset($_SESSION['logged_user']);
	header('Location: /');
?>