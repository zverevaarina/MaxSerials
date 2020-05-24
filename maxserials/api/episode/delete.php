<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
require_once '../config/database.php';
require_once '../objects/episode.php';
  
$database = new Database();
$connection = $database->getConnection();
$episode = new Episode($connection);

$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

if($episode->delete($id)){
  	http_response_code(200);
    echo json_encode(array("message" => "Episode was deleted."));
}
else{
  	http_response_code(503);
  	echo json_encode(array("message" => "Unable to delete episode."));
}
?>