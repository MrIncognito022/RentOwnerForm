<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); 

include '../db_connection.php';


if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}


$data = json_decode(file_get_contents('php://input'), true);
$statusId = isset($data['id']) ? $data['id'] : null;


if (!$statusId) {
    http_response_code(400);
    echo json_encode(['error' => 'Status ID is required']);
    exit;
}

// SQL query to delete the status by ID
$sql = "DELETE FROM status WHERE id = ?";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Bind the status ID parameter
$stmt->bind_param("i", $statusId);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        echo json_encode(['message' => 'Status deleted successfully']);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Status not found']);
    }
} else {

    http_response_code(500);
    echo json_encode(['error' => 'Failed to delete status: ' . $stmt->error]);
}


$stmt->close();
$conn->close();
?>
