<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); // Ensure response is JSON

include '../db_connection.php';

// Get the incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);
$propTypeName = $data['name'] ?? '';

if (!$propTypeName) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'PropType name is required']);
    exit;
}

// Insert into the correct table name (`proptype`)
$sql = "INSERT INTO proptype (name) VALUES (?)"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $propTypeName);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500); 
    echo json_encode(['error' => 'Failed to insert PropType: ' . $stmt->error]);
}

// Close connection
$stmt->close();
$conn->close();
?>
