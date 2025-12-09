<?php
require_once 'config.php';
$data = json_decode(file_get_contents("php://input"));

if(empty($data->name) || empty($data->email) || empty($data->password)) {
    http_response_code(400); die(json_encode(["error" => "All fields are required"]));
}

try {
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$data->email]);
    if($check->rowCount() > 0){
        http_response_code(409); die(json_encode(["error" => "Student email already exists"]));
    }

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    if($stmt->execute([$data->name, $data->email, password_hash($data->password, PASSWORD_DEFAULT)])) {
        http_response_code(201); echo json_encode(["message" => "Student registered successfully"]);
    }
} catch(Exception $e) {
    http_response_code(500); echo json_encode(["error" => $e->getMessage()]);
}
?>