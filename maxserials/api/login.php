<?php
header("Access-Control-Allow-Origin: http://localhost/prj/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once 'config/database.php';
include_once 'objects/user.php';
include_once 'objects/admin.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$admin = new Admin($db);
$data = json_decode(file_get_contents("php://input"));//здесь придут данные 
$user->email = $data->email;
$email_exists1 = $user->emailExists();
$admin->email = $data->email;
$email_exists2 = $admin->emailExists();
 
require_once  'config/core.php';
require_once  'libs/php-jwt-master/src/BeforeValidException.php';
require_once  'libs/php-jwt-master/src/ExpiredException.php';
require_once  'libs/php-jwt-master/src/SignatureInvalidException.php';
require_once  'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

if($email_exists1 && password_verify($data->password, $user->password)){
 
    $token = array(
       "iss" => $iss,
       "aud" => $aud,
       "iat" => $iat,
       "nbf" => $nbf,
       "data" => array(
           "id" => $user->id,
           "name" => $user->name,
           "email" => $user->email,
           "photo" => $user->photo,
           "facts" => $user->facts
       )
    );
 	http_response_code(200);
 	$jwt = JWT::encode($token, $key);
    echo json_encode(
            array(
                "message" => "Successful login user.",
                "jwt" => $jwt,
                "data" => $token
            )
        );
}
else if ($email_exists2 && password_verify($data->password, $admin->password))
{
  $token = array(
       "iss" => $iss,
       "aud" => $aud,
       "iat" => $iat,
       "nbf" => $nbf,
       "data" => array(
           "id" => $admin->id,
           "name" => $admin->name,
           "email" => $admin->email
       )
    );
  http_response_code(200);
  $jwt = JWT::encode($token, $key);
    echo json_encode(
            array(
                "message" => "Successful login admin.",
                "jwt" => $jwt
            )
        );
}
else{
 	http_response_code(401);
 	echo json_encode(array("message" => "Login failed."));
}
?>