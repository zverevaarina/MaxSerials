<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
require_once '../config/database.php';
require_once '../objects/user.php';
require_once '../objects/userepisode.php';

$database = new Database();
$connection = $database->getConnection();
$u = new UserEpisode($connection);
$data = json_decode(file_get_contents("php://input"));
$ok = $u->delete($data->id);
if($ok){
  	http_response_code(200);
  	echo json_encode(array("message" => "Delete user-episode record "));
}
else{
  	http_response_code(503);
  	echo json_encode(array("message" => "Don't delete user-episode record "));
}
?>