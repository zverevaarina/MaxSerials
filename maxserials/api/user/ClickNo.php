<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
require_once '../config/database.php';
require_once '../objects/userserial.php';


$database = new Database();
$connection = $database->getConnection();
$userserial = new UserSerials($connection);
$data = json_decode(file_get_contents("php://input"));
$userserial->NoteNo($data->user_id, $data->serial_id);
http_response_code(200);
echo json_encode(array("message" => "click good."));
?>