<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
require_once '../config/database.php';
require_once '../objects/user.php';
  
$database = new Database();
$connection = $database->getConnection();
$user = new User($connection);

$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

if($user->delete($id)){
  	http_response_code(200);
    echo json_encode(array("message" => "User was deleted."));
}
else{
  	http_response_code(503);
  	echo json_encode(array("message" => "Unable to delete user."));
}
?>