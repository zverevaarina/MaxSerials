<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
require_once '../config/database.php';
require_once '../objects/admin.php';

$database = new Database();
$connection = $database->getConnection();
$admin = new Admin($connection);
$data = json_decode(file_get_contents("php://input"));
$ans_admin = $admin->readOne($data->id);
if($admin->ans_ex){
    http_response_code(200);
    echo $ans_admin;
}
else{
   http_response_code(404);
    echo json_encode(
        array("message" => "No admin found.")
    );
}
?>