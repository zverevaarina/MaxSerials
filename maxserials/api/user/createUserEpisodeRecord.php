<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
require_once '../config/database.php';
require_once '../objects/user.php';
require_once '../objects/userepisode.php';

$database = new Database();
$connection = $database->getConnection();
$u = new UserEpisode($connection);
$data = json_decode(file_get_contents("php://input"));
$u->create($data->user_id, $data->episode_id);
?>