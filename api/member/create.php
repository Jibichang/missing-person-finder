<?php
// header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/memberObject.php';

$database = new Database();
$db = $database->getConnection();

$member = new Member($db);

$data = json_decode(file_get_contents("php://input"));

$member->guest_name = $data->name;
$member->guest_email = $data->email;
$member->guest_pass = $data->password;

$email_exists = $member->emailExists();

if(!$email_exists){
  if ($member->create()) {
    // set response code
    http_response_code(200);

    // display message: user was created
    echo json_encode(array("message" => "User was created."));
  }else {
    // set response code
    http_response_code(400);
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
  }
}

// message if unable to create user
else{
  // set response code
  http_response_code(422);
  // display message: unable to create user
  echo json_encode(array("message" => "user not unique."));

}
?>
