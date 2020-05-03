<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
require_once '../config/database.php';
require_once '../objects/serial.php';

$database = new Database();
$connection = $database->getConnection();
$serial = new Serial($connection);
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
$ans_serials = $serial->readOne($keywords);
if($serial->ans_ex){
    http_response_code(200);
    echo $ans_serials;
}
else{
   echo "";
}
?>