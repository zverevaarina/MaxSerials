<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../objects/serial.php';

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
$connection = $database->getConnection();
$serial = new Serial($connection);
if(
    !empty($_POST["name"]) &&
    !empty($_POST["year"]) &&
    !empty($_POST["description"]) &&
    !empty($_POST["fun_facts"]) &&
    !empty($_POST["country"]) &&
    !empty($_POST["genre"] ))
{
    if(isset($_FILES['file'])) {
        if ($_FILES['file']['name'] !== '' && $_FILES['file']['error'] == 0) {
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
            
        if (!move_uploaded_file($fileTmpName, __DIR__ . '/upload/'.$file)) {
           throw new Exception('При загрузке изображения произошла ошибка на сервере!');}
            $serial->name = htmlspecialchars(strip_tags($_POST["name"]));
            $serial->year = htmlspecialchars(strip_tags($_POST["year"]));
            $serial->description =  htmlspecialchars(strip_tags($_POST["description"]));
            $serial->fun_facts = htmlspecialchars(strip_tags($_POST["fun_facts"]));
            $serial->country = htmlspecialchars(strip_tags($_POST["country"]));
            $serial->photo = $file;
            $serial->genre = htmlspecialchars(strip_tags($_POST["genre"]));
            $serial->create();
            http_response_code(201);
            echo json_encode(array("message" => "Serial was added."));
        }   
        catch (Exception $e) {
            die($e->getMessage());}
        }
    }
}
else{
  	http_response_code(400);
  	echo json_encode(array("message" => "Unable to add serial. Data is incomplete."));
}
?>