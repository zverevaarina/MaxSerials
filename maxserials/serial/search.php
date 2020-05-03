<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/serial.php';

$database = new Database();
$connection = $database->getConnection();
$serial = new Serial($connection);
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
$ans_serials = $serial->search($keywords);
if($serial->ans_ex){
    http_response_code(200);
    echo $ans_serials;
}
else{
  echo "";
}
?>