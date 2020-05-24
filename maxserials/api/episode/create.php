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
$data = json_decode( file_get_contents("php://input"));
if(
    !empty($data->name) &&
    !empty($data->date) &&
    !empty($data->serial_id) &&
    !empty($data->season_num) &&
    !empty($data->episode_num)){
    
    $episode->name = htmlspecialchars(strip_tags($data->name));
    $episode->date = htmlspecialchars(strip_tags($data->date));
    $episode->serial_id =  htmlspecialchars(strip_tags($data->serial_id));
    $episode->season_num = htmlspecialchars(strip_tags($data->season_num));
    $episode->episode_num = htmlspecialchars(strip_tags($data->episode_num));
    $episode->create();
    http_response_code(201);
  	echo json_encode(array("message" => "Episode was added."));
}
else{
  	http_response_code(400);
  	echo json_encode(array("message" => "Unable to add episode. Data is incomplete."));
}
?>