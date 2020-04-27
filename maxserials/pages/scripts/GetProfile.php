<?php 
require_once "db.php"; 

	$id = $_SESSION['logged_user']->id;
	$ans = "";
	$book = R::findOne('user', 'id = ?', [$id]);
	$name = "";
	$fact = "";
	$email = "";
	if($book){
		$name=$book->name;
		$fact = $book->facts;
		$email = $book->email;
		$photo = $book->photo;//надо изменить
		$ans = "<img src='../icons/$photo' width='300' height='300'></td>";
	}
	

?>