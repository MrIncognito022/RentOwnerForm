<?php
// delete-lead.php
include '../db_connection.php'; // Adjust the path as needed

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['Id'])) {
    $leadId = intval($data['Id']); // Sanitize input

    // Prepare a statement to delete the lead
    $stmt = $conn->prepare("DELETE FROM lead WHERE Id = ?");
    $stmt->bind_param("i", $leadId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Lead deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete lead."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "No lead ID provided."]);
}

$conn->close();
?>
