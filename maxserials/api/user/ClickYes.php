<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
require_once '../config/database.php';
require_once '../objects/user.php';
require_once '../objects/userepisode.php';
require_once '../objects/userserial.php';
require_once '../objects/episode.php';

$database = new Database();
$connection = $database->getConnection();
$episodes = new Episode($connection);
$userserial = new UserSerials($connection);
$user = new User($connection);
$userepisode = new UserEpisode($connection);
$data = json_decode(file_get_contents("php://input"));
if (!$userserial->Exsist($data->user_id, $data->serial_id))
	$userserial->create($data->user_id, $data->serial_id);
$episode_arr = $episodes->readAll($data->serial_id);
for ($row = 0; $row <count($episode_arr); $row++){
	if (!$userepisode->Exsist($data->user_id, $episode_arr[$row]['id']))
		$userepisode->create($data->user_id, $episode_arr[$row]['id']);
}
$userserial->NoteYes($data->user_id, $data->serial_id);
http_response_code(200);
echo json_encode(array("message" => "click good."));
?>