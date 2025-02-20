<?php
// delete-propType.php
include '../db_connection.php'; // Adjust the path as needed

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $priorityId = intval($data['id']); // Sanitize input

    // Prepare a statement to delete the PropType
    $stmt = $conn->prepare("DELETE FROM priority WHERE id = ?");
    $stmt->bind_param("i", $priorityId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "priority deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete priority."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "No priority ID provided."]);
}

$conn->close();
?>
