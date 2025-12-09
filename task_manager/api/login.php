<?php
require_once 'config.php';
$data = json_decode(file_get_contents("php://input"));

if(empty($data->email) || empty($data->password)) {
    http_response_code(400); die(json_encode(["error" => "Credentials required"]));
}

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$data->email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($data->password, $user['password'])) {
        unset($user['password']);
        echo json_encode(["message" => "Welcome to Campus Hub", "user" => $user]);
    } else {
        http_response_code(401); echo json_encode(["error" => "Invalid Student ID or Password"]);
    }
} catch(Exception $e) {
    http_response_code(500); echo json_encode(["error" => $e->getMessage()]);
}
?>