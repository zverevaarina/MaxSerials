<?php
require_once "db.php";
$data = $_POST;
if (isset($data['registration']) )
{
	$errors = array();
	if (trim($data['email']) == '')
	{
		$errors[] = 'Введите email!';
	}

	if (trim($data['password']) == '')
	{
		$errors[] = 'Введите пароль!';
	}

	if (trim($data['name']) == '')
	{
		$errors[] = 'Введите имя!';
	}
	if (R::count('user', "email=?", array($data['email'])))
	{
		$errors[] = 'Пользователь с таким email уже зарегистрирован!';
	}
	if (empty($errors))
	{
		$user = R::dispense('user');
		$user->email = $data['email'];
		$user->password = password_hash($data['password'], PASSWORD_DEFAULT);
		$user->name = $data['name'];
		$user->facts = "Немного о себе...";
		$user->photo = "noavatar.png";
		R::store($user);
		$_SESSION['logged_user'] = $user;
		header("Location:/pages/profile_home.php");
	}
	else
	{
		echo array_shift($errors);
	}
}
?>
