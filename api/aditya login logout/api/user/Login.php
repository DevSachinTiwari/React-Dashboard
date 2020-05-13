<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
require_once '../../config/Database.php';
require_once '../../model/User.php';
$database = new Database();
$db = $database->getCon();
$user = new User($db);
$user_email = isset($_GET['email']) ? $_GET['email'] : die();
$password = isset($_GET['password']) ? md5($_GET['password']) : die();
if ($data = $user->checkUserValid($user_email, $password)) {
    http_response_code(200);
    echo json_encode($data);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "User does not exist."));
}