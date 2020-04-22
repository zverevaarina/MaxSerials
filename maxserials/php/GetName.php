<?php 
require "db.php";
function GetName(){
	$id = $_SESSION['logged_user']->id;
	$book = R::findOne('user', 'id = ?', [$id]);
	$id = $_SESSION['logged_user']->id;
	$name="";
	if($book){
		$name = $book->name;
	}
	return $name;
}
?>

