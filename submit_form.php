<?php
// Enable error reporting (for debugging purposes)
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
print_r($_POST);
// Function to handle image upload
function uploadImage($fileInputName, $uploadDir = 'uploads/') {
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES[$fileInputName]['tmp_name'];
        $fileName = basename($_FILES[$fileInputName]['name']);
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedExtensions)) {
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

    // Process file uploads (ensure your HTML form has enctype="multipart/form-data")
    $ownerPhotoPath = uploadImage('owner_photo');
    $projectPhotoPath = uploadImage('project_photo');

    // OPTIONAL: Loop through POST data for debugging
    /*
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    */

    // Collect form data (ensure your form uses these exact name attributes)
    $name             = $_POST['name'] ?? 'Unknown';
    $cast             = $_POST['cast'] ?? null;
    $cell             = $_POST['cell'] ?? null;  // Must be provided (NOT NULL)
    $cnic             = $_POST['CNIC'] ?? null;
    $lead_id          = $_POST['lead'] ?? null;
    $category_id      = $_POST['category'] ?? null;
    $prop_type_id     = $_POST['prop_type'] ?? null;
    $status_id        = $_POST['status'] ?? null;
    $priority_id      = $_POST['priority'] ?? null;
    $overseas         = isset($_POST['overseas']) ? 1 : 0;
    $investor         = isset($_POST['investor']) ? 1 : 0;
    $builder          = isset($_POST['builder']) ? 1 : 0;

    // Features
    $bedrooms         = $_POST['bedrooms'] ?? 0;
    $bathrooms        = $_POST['bathrooms'] ?? 0;
    $floor            = $_POST['floor'] ?? null;
    $block            = $_POST['block'] ?? null;
    $square_feet      = $_POST['square_feet'] ?? null;
    $drawing          = isset($_POST['drawing']) ? 1 : 0;
    $roof             = isset($_POST['roof']) ? 1 : 0;
    $separate_gate    = isset($_POST['separate_gate']) ? 1 : 0;
    $dining           = isset($_POST['dining']) ? 1 : 0;
    $store            = isset($_POST['store']) ? 1 : 0;
    $basement         = isset($_POST['basement']) ? 1 : 0;
    $common           = isset($_POST['common']) ? 1 : 0;
    $mezzanine        = isset($_POST['mezzanine']) ? 1 : 0;
    $west_open        = isset($_POST['west_open']) ? 1 : 0;
    $back             = isset($_POST['back']) ? 1 : 0;
    $gas              = isset($_POST['gas']) ? 1 : 0;
    $corner           = isset($_POST['corner']) ? 1 : 0;
    $front            = isset($_POST['front']) ? 1 : 0;
    $water            = isset($_POST['water']) ? 1 : 0;

    // Possession Details
    $possession           = $_POST['possession'] ?? null;
    $possession_in_words  = $_POST['possession_in_words'] ?? null;
    $document_charges     = $_POST['document_charges'] ?? 0.00;
    $flat_maintenance     = $_POST['flat_maintenance'] ?? 0.00;
    $deposit              = $_POST['deposit'] ?? 0.00;
    $rent                 = $_POST['rent'] ?? 0.00;
    $project_entry_fee    = $_POST['project_entry_fee'] ?? 0.00;
    $office_charges       = $_POST['office_charges'] ?? 0.00;
    $key_available        = isset($_POST['key_available']) ? 1 : 0;

    // Project Information
    $project_id           = $_POST['project'] ?? null;
    $plot_no              = $_POST['plot_no'] ?? null;
    $project_features     = $_POST['project_features'] ?? null;
    $location             = $_POST['location'] ?? null;
    $area                 = $_POST['area'] ?? null;
    $project_bank_loan    = isset($_POST['project_bank_loan']) ? 1 : 0;
    $project_completion_certificate = isset($_POST['project_completion_certificate']) ? 1 : 0;
    $builder_name         = $_POST['builder_name'] ?? null;

    // Tenant Information
    $tenant_name          = $_POST['tenant_name'] ?? null;
    $tenant_cnic          = $_POST['tenant_cnic'] ?? null;
    $tenant_cell          = $_POST['tenant_cell'] ?? null;
    $tenant_note          = $_POST['tenant_note'] ?? null;

    // Reference Details
    $reference_name       = $_POST['reference_name'] ?? null;
    $reference_cnic       = $_POST['reference_cnic'] ?? null;
    $reference_cell       = $_POST['reference_cell'] ?? null;
    $reference_remarks    = $_POST['reference_remarks'] ?? null;

    // Prepare SQL query (matching your table columns)
    $sql = "INSERT INTO rent_owners (
                name, cast, cell, cnic, lead_id, category_id, prop_type_id, status_id, priority_id,
                overseas, investor, builder, owner_photo,
                bedrooms, bathrooms, floor, block, square_feet, drawing, roof, separate_gate, dining, store, basement, common, mezzanine, west_open, back, gas, corner, front, water,
                possession, possession_in_words, document_charges, flat_maintenance, deposit, rent, project_entry_fee, office_charges, key_available,
                project_id, plot_no, project_features, location, area, project_bank_loan, project_completion_certificate, builder_name, project_photo,
                tenant_name, tenant_cnic, tenant_cell, tenant_note,
                reference_name, reference_cnic, reference_cell, reference_remarks
            ) VALUES (
                :name, :cast, :cell, :cnic, :lead_id, :category_id, :prop_type_id, :status_id, :priority_id,
                :overseas, :investor, :builder, :owner_photo,
                :bedrooms, :bathrooms, :floor, :block, :square_feet, :drawing, :roof, :separate_gate, :dining, :store, :basement, :common, :mezzanine, :west_open, :back, :gas, :corner, :front, :water,
                :possession, :possession_in_words, :document_charges, :flat_maintenance, :deposit, :rent, :project_entry_fee, :office_charges, :key_available,
                :project_id, :plot_no, :project_features, :location, :area, :project_bank_loan, :project_completion_certificate, :builder_name, :project_photo,
                :tenant_name, :tenant_cnic, :tenant_cell, :tenant_note,
                :reference_name, :reference_cnic, :reference_cell, :reference_remarks
            )";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':cast' => $cast,
            ':cell' => $cell,
            ':cnic' => $cnic,
            ':lead_id' => $lead_id,
            ':category_id' => $category_id,
            ':prop_type_id' => $prop_type_id,
            ':status_id' => $status_id,
            ':priority_id' => $priority_id,
            ':overseas' => $overseas,
            ':investor' => $investor,
            ':builder' => $builder,
            ':owner_photo' => $ownerPhotoPath,
            ':bedrooms' => $bedrooms,
            ':bathrooms' => $bathrooms,
            ':floor' => $floor,
            ':block' => $block,
            ':square_feet' => $square_feet,
            ':drawing' => $drawing,
            ':roof' => $roof,
            ':separate_gate' => $separate_gate,
            ':dining' => $dining,
            ':store' => $store,
            ':basement' => $basement,
            ':common' => $common,
            ':mezzanine' => $mezzanine,
            ':west_open' => $west_open,
            ':back' => $back,
            ':gas' => $gas,
            ':corner' => $corner,
            ':front' => $front,
            ':water' => $water,
            ':possession' => $possession,
            ':possession_in_words' => $possession_in_words,
            ':document_charges' => $document_charges,
            ':flat_maintenance' => $flat_maintenance,
            ':deposit' => $deposit,
            ':rent' => $rent,
            ':project_entry_fee' => $project_entry_fee,
            ':office_charges' => $office_charges,
            ':key_available' => $key_available,
            ':project_id' => $project_id,
            ':plot_no' => $plot_no,
            ':project_features' => $project_features,
            ':location' => $location,
            ':area' => $area,
            ':project_bank_loan' => $project_bank_loan,
            ':project_completion_certificate' => $project_completion_certificate,
            ':builder_name' => $builder_name,
            ':project_photo' => $projectPhotoPath,
            ':tenant_name' => $tenant_name,
            ':tenant_cnic' => $tenant_cnic,
            ':tenant_cell' => $tenant_cell,
            ':tenant_note' => $tenant_note,
            ':reference_name' => $reference_name,
            ':reference_cnic' => $reference_cnic,
            ':reference_cell' => $reference_cell,
            ':reference_remarks' => $reference_remarks,
        ]);

        echo "Record added successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
