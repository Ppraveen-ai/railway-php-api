<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=utf-8');

// Railway MySQL credentials
$DB_HOST = "metro.proxy.rlwy.net";   // Railway host
$DB_PORT = 30156;                    // Railway port
$DB_USER = "root";                   // Railway user
$DB_PASS = "VCVTsPvazINDiVuBsmzicmrxFhuZddNW";  // Railway password
$DB_NAME = "railway";                // Railway database name

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // collect POST values
    $serial     = $_POST['serial'] ?? '';
    $problem    = $_POST['problem'] ?? '';
    $unit       = $_POST['unit'] ?? '';
    $department = $_POST['department'] ?? '';
    $name       = $_POST['name'] ?? '';
    $phone      = $_POST['phone'] ?? '';

    if (!$serial || !$problem || !$unit || !$department || !$name || !$phone) {
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
}
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // return all rows
    $res = $conn->query("SELECT * FROM complaints_table ORDER BY id DESC");
    $rows = [];
    while ($r = $res->fetch_assoc()) {
        $rows[] = $r;
    }
    echo json_encode($rows);
}
else {
    echo json_encode(["error" => "Only GET and POST allowed"]);
}

$conn->close();
?>
