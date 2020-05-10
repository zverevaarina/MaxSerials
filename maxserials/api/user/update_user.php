<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 

include_once '../config/database.php';
include_once '../objects/user.php';

function randomFileName($extension = false)
{
  $extension = $extension ? $extension : '';
 do {
    $name = md5(microtime() . rand(0, 9999));
    $file = $name . $extension;
  } while (file_exists($file));
 
  return $file;
}


$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$jwt=isset($_POST["jwt"]) ? $_POST["jwt"] : "";

if($jwt){
    try {
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $ok_file = false;
        if(isset($_FILES['file']) && $_FILES['file']['name'] !== '' && $_FILES['file']['error'] == 0) {
        	
        		try {
        		    $fileTmpName = $_FILES['file']['tmp_name'];
        		    $fi = finfo_open(FILEINFO_MIME_TYPE);
        		    $mime = (string) finfo_file($fi, $fileTmpName);
        		    if (strpos($mime, 'image') === false) 
        		        die('Можно загружать только изображения с расширениями  .jpg, .jpeg, .png!');
        		    $image = getimagesize($fileTmpName);
        		    $extension = image_type_to_extension($image[2]);
        		    $name = randomFileName($extension);     
        		    $file = str_replace('jpeg', 'jpg', $name);
					if (!move_uploaded_file($fileTmpName, __DIR__ . '/upload/'.$file)) 
        		   		throw new Exception('При загрузке изображения произошла ошибка на сервере!');
        		   	$ok_file = true;
        		   	}   
        		catch (Exception $e) {
            		die($e->getMessage());
            	}
        	}
        }
        catch (Exception $e){
        http_response_code(401);
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()));
    	}
        if ($ok_file)
        	$user->photo = $file;
        else
        	$user->photo = $decoded->data->photo;
        $user->id = $decoded->data->id;

        $user->name = htmlspecialchars(strip_tags($_POST["name"]));
    	$user->email = htmlspecialchars(strip_tags($_POST["email"]));
    	$user->facts = htmlspecialchars(strip_tags($_POST["facts"]));
    	$user->password = htmlspecialchars(strip_tags($_POST["password"]));
    	
    	   if($user->update()){
    	   		$token = array(
    	   		   "iss" => $iss,
    	   		   "aud" => $aud,
    	   		   "iat" => $iat,
    	   		   "nbf" => $nbf,
    	   		   "data" => array(
    	   		       "id" => $user->id,
    	   		       "name" => $user->name,
    	   		       "facts" => $user->facts,
    	   		       "photo" => $user->photo,
    	   		       "email" => $user->email
    	   		   )
    	   		            );
    	   		$jwt = JWT::encode($token, $key);
    	   		http_response_code(200);
    	   		echo json_encode(
    	   		        array(
    	   		            "message" => "User was updated.",
    	   		            "jwt" => $jwt));
    	    }
  }     
    	
    
?>