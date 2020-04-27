<?php 
require_once "db.php";
function LogIn(){
	$data = $_POST;
	if (isset($data['do_login']) )
	{
		$errors = array();
		$user = R::findOne('user', 'email = ?', array($data['email'] ));
		$admin = R::findOne('admin', 'email = ?', array($data['email'] ));
	    if ($user)
		{
			if (password_verify($data['password'], $user->password))
			{
				$_SESSION['logged_user'] = $user;
				header('Location: /pages/profile_home.php');
			}
			else
			{
				$errors[] = 'Неверно введен пароль! Попробуйте снова.';
			}
		}
		elseif($admin)
		{

			//Если пароль совпадает с тем, что в базе данных (дешифрованный)
			if (password_verify($data['password'], $admin->password))
			{
				$_SESSION['logged_user'] = $admin;
				header('Location: /pages/admin.php"');
			}
			else
			{
				$errors[] = 'Неверно введен пароль! Попробуйте снова.';
			}
		}else{
			$errors[] = 'Такого пользователя нет!';
		}
		//Вывод ошибок
		if ( !empty($errors) )
		{
			echo array_shift($errors);
		}
	}
}
LogIn();
?>
	
		


