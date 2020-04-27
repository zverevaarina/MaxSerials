<?php 
require_once "db.php";
	$data = $_POST;
	$id = $_SESSION['logged_user']->id;
	$book = R::load('user', $id);
	if (isset($data['save']) ){
		$book->name = $data['name'];
		$book->email = $data['email'];
		$book->facts = $data['fact'];
		R::store($book);
		header("Location:/../pages/profile.php");
}?>
