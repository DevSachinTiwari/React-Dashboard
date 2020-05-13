<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once '../../config/Database.php';
require_once '../../model/User.php';
$database = new Database();
$db = $database->getCon();
$user = new User($db);
$data = json_decode(file_get_contents("php://input"));
if (!empty($data->first_name) && !empty($data->last_name) && !empty($data->email) && !empty($data->password)) {
    if ($user->create($data)) {
        http_response_code(201);
        echo json_encode(array("message" => "User has been created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create user."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
}

