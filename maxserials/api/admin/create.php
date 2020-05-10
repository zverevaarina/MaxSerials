<?php
header("Access-Control-Allow-Origin: http://localhost/prj/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
require_once '../config/database.php';
require_once '../objects/admin.php';
 
$database = new Database();
$db = $database->getConnection();
$admin = new Admin($db);
$ok = $admin->create();
http_response_code(200);
echo json_encode(
    array("message" => "Admin create.")
);
?>