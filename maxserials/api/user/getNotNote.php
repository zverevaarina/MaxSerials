<?php

require_once '../config/database.php';
require_once '../objects/user.php';
require_once '../objects/userepisode.php';
  
$database = new Database();
$connection = $database->getConnection();
$user = new User($connection);
$data = json_decode(file_get_contents("php://input"));
$user->id = $data->id;
$ans_u = $user->getNotNote();
if($user->ans_ex){
  	http_response_code(200);
  	echo $ans_u;
   
}
else{
  	http_response_code(503);
  	echo json_encode(array("message" => "Unable to get user's notes of serial."));
}
?>