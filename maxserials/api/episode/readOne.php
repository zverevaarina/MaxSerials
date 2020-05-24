<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
require_once '../config/database.php';
require_once '../objects/episode.php';

$database = new Database();
$connection = $database->getConnection();
$episode = new Episode($connection);
$data = json_decode(file_get_contents("php://input"));
$ans_episode = $episode->readOne($data->id);
if($episode->ans_ex){
    http_response_code(200);
    echo $ans_episode;
}
else{
   http_response_code(404);
    echo json_encode(
        array("message" => "No episode found.")
    );
}
?>