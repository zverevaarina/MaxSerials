<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
require_once '../config/database.php';
require_once '../objects/user.php';
require_once '../objects/userepisode.php';
require_once '../objects/userserial.php';
require_once '../objects/episode.php';
require_once '../objects/serial.php';

$database = new Database();
$connection = $database->getConnection();
$episodes = new Episode($connection);
$serial = new Serial($connection);
$userserial = new UserSerials($connection);
$user = new User($connection);
$userepisode = new UserEpisode($connection);
$data = json_decode(file_get_contents("php://input"));
$arr_user_serials = $userserial->readAll($data->user_id);
$f_arr = array();
for ($row = 0; $row <count($arr_user_serials); $row++){
	$arr_s = json_decode($serial->readOne($arr_user_serials[$row]['serial_id']));
	$c = $episodes->Count($arr_user_serials[$row]['serial_id']);
	$user->id= $data->user_id;
    $c_not = $user->Count($arr_user_serials[$row]['serial_id']); 
    $percent = 0;
    if (!$c == 0)
    	$percent = intval($c_not/$c*100);

	$f_el = array(
		'name'  => $arr_s->name,
		 'general_count' => $c,
		 'count_not_user' => $c_not, 
		 'percent' =>$percent
	);
	array_push($f_arr, $f_el);
}
$str_ = json_encode($f_arr, JSON_FORCE_OBJECT);
$ans = $user->jsonEncodeCyr($str_);
echo $ans;
?>