<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");

include_once 'db.php';

// Pull method from request received by server
$method = $_SERVER['REQUEST_METHOD'];

// Fetch all tasks on a GET request
if ($method === 'GET') {
    $result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    exit;
}

// Pull body from request and store in a php array
$data = json_decode(file_get_contents("php://input"), true);

// POST new task into the database
if ($method === 'POST' && isset($data['task'])) {
    $stmt = $conn->prepare("INSERT INTO tasks (task) VALUES (?)");
    $stmt->bind_param("s", $data['task']);
    $stmt->execute();
    echo json_encode(["message" => "Task added successfully"]);
    exit;
}
// PUT updated status when task is completed
if ($method === 'PUT' && isset($data['id'])) {
    $stmt = $conn->prepare("UPDATE tasks SET status = 'completed' WHERE id = ?");
    $stmt->bind_param("i", $data['id']);
    $stmt->execute();
    echo json_encode(["message" => "Task marked as completed"]);
    exit;
}

// DELETE task from database
if ($method === 'DELETE' && isset($data['id'])) {
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $data['id']);
    $stmt->execute();
    echo json_encode(["message" => "Task deleted"]);
    exit;
}
?>
