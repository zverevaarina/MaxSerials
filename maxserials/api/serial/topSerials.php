<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
require_once '../objects/serial.php';
  
$database = new Database();
$connection = $database->getConnection();
$serial = new Serial($connection);
$ans_serials = $serial->getTop3Serial();
if($serial->ans_ex){
    http_response_code(200);
    echo $ans_serials;
}
else{
    http_response_code(404);
    echo json_encode(array("message" => "No serials found."));
}