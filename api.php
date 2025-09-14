<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=utf-8');

// Railway MySQL credentials
$host = "mysql://root:VCVTsPvazINDiVuBsmzicmrxFhuZddNW@metro.proxy.rlwy.net:30156/railway";   // e.g. containers-us-west-xx.railway.app
$port = "3306";           // e.g. 12345
$user = "root";       // from Railway
$pass = "VCVTsPvazINDiVuBsmzicmrxFhuZddNW";       // from Railway
$db   = "railway";       // from Railway

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serial     = $_POST['serial'] ?? '';
    $problem    = $_POST['problem'] ?? '';
    $unit       = $_POST['unit'] ?? '';
    $department = $_POST['department'] ?? '';
    $name       = $_POST['name'] ?? '';
    $phone      = $_POST['phone'] ?? '';

    if (empty($serial) || empty($problem) || empty($unit) || empty($department) || empty($name) || empty($phone)) {
        echo json_encode(["error" => "All fields are required"]);
        exit;
    }

    $sql = "INSERT INTO complaints_table (serial, problem, unit, department, name, phone)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $serial, $problem, $unit, $department, $name, $phone);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Data inserted successfully"]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Only POST requests are allowed"]);
}

$conn->close();
?>
