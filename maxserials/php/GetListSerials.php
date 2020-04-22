<?php 
require "db.php"; 
function GetListSerials(){
	$book= R::findAll('serial');
	$ans = "";
	if($book){
		$ans = "<table><tr>Название<th>Рейтинг</th><th>Жанр</th><th>Год выпуска</th></tr>";
		foreach ($book as $bean) {
			$name=$bean->name;
			$year=$bean->year;
			$genre=$bean->genre;
			$rating = $bean->rating;
			$ans .= "<tr><td>$name</td><td>$rating</td><td>$genre</td><td>$year</td></tr>";
		}
	}
	return $ans; 
}
?>