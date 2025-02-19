<?php
include 'db.php';

// Generate Rent Owner Code
include 'generateRentOwnerCode.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get form data
    $name = $_POST['name'];
    $cast = $_POST['cast'];
    $phone_number = $_POST['phone_number'];
    $cnic = $_POST['cnic'];
    $lead = $_POST['lead'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];
    $overseas = isset($_POST['overseas']) ? 1 : 0;
    $investor = isset($_POST['investor']) ? 1 : 0;
    $builder = isset($_POST['builder']) ? 1 : 0;

    // Insert into rent_owners table
    $query = "INSERT INTO rent_owners (rent_owner_code, name, cast, phone_number, cnic, lead, category, status, priority, overseas, investor, builder)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$rent_owner_code, $name, $cast, $phone_number, $cnic, $lead, $category, $status, $priority, $overseas, $investor, $builder]);
    $rent_owner_id = $conn->lastInsertId();

    // Insert into properties table
   
