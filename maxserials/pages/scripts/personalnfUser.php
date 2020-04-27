<?php 
require_once "db.php"; 
function GetPersonalInf(){
	$id = $_SESSION['logged_user']->id;
	$ans = "";
	$book = R::findOne('user', 'id = ?', [$id]);
	if($book){
		$name=$book->name;
		$fact = $book->facts;
		$photo = $book->photo;
		$ans = "<img src='uploads/$photo' width='300' height='300'></td><tr><td>Логин: $name</td></tr>
		<tr><td>О себе: $fact</td></tr>";
	}
	return $ans; 
}
?>


