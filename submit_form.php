<?php
// Database configuration
$host = 'localhost';
$db   = 'rentownerdb';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// DSN and connection
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Function to handle image upload
function uploadImage($fileInputName, $uploadDir = 'uploads/') {
    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES[$fileInputName]['tmp_name'];
        $fileName    = basename($_FILES[$fileInputName]['name']);
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed file extensions
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedExtensions)) {
            // Create a unique name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                return $destPath;
            } else {
                return null; // Error moving file
            }
        } else {
            return null; // Invalid file type
        }
    }
    return null; // No file uploaded
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process file uploads
    $ownerPhotoPath = uploadImage('owner_photo');  // Image upload field name
    $projectPhotoPath = uploadImage('project_photo'); // Image upload field name

    // Collect form data (use defaults if necessary)
    foreach ($_POST as $key => $value) {
        // You can process each key-value pair
        echo "Key: $key, Value: $value<br>";}
    $name = $_POST['name'] ?? 'Unknown';  // Default name if not provided
    $cast = $_POST['cast'] ?? null;
    $cell = $_POST['Cell'] ?? null;
    $cnic = $_POST['CNIC'] ?? null;
    $lead = $_POST['lead'] ?? null;
    $category = $_POST['category'] ?? null;
    $prop_type = $_POST['prop_type'] ?? null;
    $status = $_POST['status'] ?? null;
    $priority = $_POST['priority'] ?? null;
    $overseas = isset($_POST['overseas']) ? 1 : 0;
    $investor = isset($_POST['investor']) ? 1 : 0;
    $builder = isset($_POST['builder']) ? 1 : 0;

    // Features and other data
    $bedrooms = $_POST['bedrooms'] ?? 0;
    $bathrooms = $_POST['bathrooms'] ?? 0;
    $floor = $_POST['floor'] ?? null;
    $block = $_POST['block'] ?? null;
    $square_feet = $_POST['square_feet'] ?? null;

    // Possession Details
    $possession = $_POST['possession'] ?? null;
    $document_charges = $_POST['document_charges'] ?? 0.00;
    $flat_maintenance = $_POST['flat_maintenance'] ?? 0.00;
    $deposit = $_POST['deposit'] ?? 0.00;
    $rent = $_POST['rent'] ?? 0.00;
    $project_entry_fee = $_POST['project_entry_fee'] ?? 0.00;
    $office_charges = $_POST['office_charges'] ?? 0.00;
    $key_available = isset($_POST['key_available']) ? 1 : 0;

    // Project Information
    $project = $_POST['project'] ?? null;
    $plot_no = $_POST['plot_no'] ?? null;
    $location = $_POST['location'] ?? null;
    $area = $_POST['area'] ?? null;

    // Prepare SQL query with placeholders
    $sql = "INSERT INTO rent_owners (
                    name, cast, cell, cnic, lead, category, prop_type, status, priority,
                    overseas, investor, builder, owner_photo,
                    bedrooms, bathrooms, floor, block, square_feet,
                    possession, document_charges, flat_maintenance, deposit, rent, project_entry_fee, office_charges, key_available,
                    project, plot_no, location, area, project_photo
                ) VALUES (
                    :name, :cast, :cell, :cnic, :lead, :category, :prop_type, :status, :priority,
                    :overseas, :investor, :builder, :owner_photo,
                    :bedrooms, :bathrooms, :floor, :block, :square_feet,
                    :possession, :document_charges, :flat_maintenance, :deposit, :rent, :project_entry_fee, :office_charges, :key_available,
                    :project, :plot_no, :location, :area, :project_photo
                )";

    // Prepare and execute the query
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':cast' => $cast,
            ':cell' => $cell,
            ':cnic' => $cnic,
            ':lead' => $lead,
            ':category' => $category,
            ':prop_type' => $prop_type,
            ':status' => $status,
            ':priority' => $priority,
            ':overseas' => $overseas,
            ':investor' => $investor,
            ':builder' => $builder,
            ':owner_photo' => $ownerPhotoPath,
            ':bedrooms' => $bedrooms,
            ':bathrooms' => $bathrooms,
            ':floor' => $floor,
            ':block' => $block,
            ':square_feet' => $square_feet,
            ':possession' => $possession,
            ':document_charges' => $document_charges,
            ':flat_maintenance' => $flat_maintenance,
            ':deposit' => $deposit,
            ':rent' => $rent,
            ':project_entry_fee' => $project_entry_fee,
            ':office_charges' => $office_charges,
            ':key_available' => $key_available,
            ':project' => $project,
            ':plot_no' => $plot_no,
            ':location' => $location,
            ':area' => $area,
            ':project_photo' => $projectPhotoPath,
        ]);

        echo "Record added successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}

?>
