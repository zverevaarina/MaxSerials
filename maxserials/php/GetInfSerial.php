<?php 
require "db.php"; 
function GetPersonalInf(){
	$id = $_SESSION['logged_user']->id;
	$ans = "";
	$book = R::findOne('user', 'id = ?', [$id]);
	if($book){
		$name=$book->name;
		$fact = $book->facts;
		$photo = $book->photo;
		$email = $book->email;
		$ans = "<div><p><span>Логин:</span> $name</p>
		<p><textarea>О себе: $facts</textarea></p>
		<p><span>Email:</span> $email</p></div>";
		return $ans; 
	}
}
?>