<?php
require_once 'config.php';
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $user_id = $_GET['user_id'] ?? null;
        if($user_id) {
            $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date ASC");
            $stmt->execute([$user_id]);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date, priority) VALUES (?, ?, ?, ?, ?)");
        if($stmt->execute([$data->user_id, $data->title, '', $data->due_date, $data->priority])) {
            echo json_encode(["message" => "Assignment Added"]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->completed)) {
            $stmt = $conn->prepare("UPDATE tasks SET completed = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$data->completed, $data->task_id, $data->user_id]);
        }
        echo json_encode(["message" => "Status Updated"]);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$data->task_id, $data->user_id]);
        echo json_encode(["message" => "Record Deleted"]);
        break;
}
?>