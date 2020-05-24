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
$episode->name = htmlspecialchars(strip_tags($data->name));
$episode->serial_id = htmlspecialchars(strip_tags($data->serial_id));
$episode->season_num = htmlspecialchars(strip_tags($data->season_num));
$episode->episode_num = htmlspecialchars(strip_tags($data->episode_num));
$episode->date = htmlspecialchars(strip_tags($data->date));

if($episode->update($id)){
    http_response_code(200);
    echo json_encode(array("message" => "Episode was updated."));
}
else{
  	http_response_code(400);
 	echo json_encode(array("message" => "Unable to update episode."));
}
?>