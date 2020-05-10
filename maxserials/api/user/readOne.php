<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
require_once '../config/database.php';
require_once '../objects/user.php';

$database = new Database();
$connection = $database->getConnection();
$user = new User($connection);
$data = json_decode(file_get_contents("php://input"));
$ans_user = $user->readOne($data->id);
if($user->ans_ex){
    http_response_code(200);
    echo $ans_user;
}
else{
   http_response_code(404);
    echo json_encode(
        array("message" => "No user found.")
    );
}
?>