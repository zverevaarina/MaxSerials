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
if ($userserial->Exsist($data->user_id, $data->serial_id)){	
	$user->id= $data->user_id;
	$ok = $userserial->ExNote($data->user_id,$data->serial_id);
	$ans_user = $user->getNoteSerial($data->serial_id, $ok);
	http_response_code(200); 
	echo $ans_user;
}
else{
http_response_code(200);
echo "{\"note\": \"0\"}";}
?>