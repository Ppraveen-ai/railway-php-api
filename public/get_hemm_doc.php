<?php
header('Content-Type: application/json; charset=utf-8');

$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");
$db   = getenv("DB_NAME");
$port = getenv("DB_PORT") ?: 3306;

// Read parameters (GET or POST)
$hemm_id  = $_REQUEST['hemm_id']  ?? null;
$doc_type = $_REQUEST['doc_type'] ?? null;
$lang     = $_REQUEST['lang']     ?? null;

if (!$hemm_id || !$doc_type || !$lang) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Missing parameters"
    ]);
    exit;
}

// Retry logic (important for Railway free plan)
$maxTries = 5;
$conn = null;

for ($i = 1; $i <= $maxTries; $i++) {
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = @new mysqli($host, $user, $pass, $db, $port);
    if (!$conn->connect_error) {
        break;
    }
    sleep(2);
}

if ($conn->connect_error) {
    http_response_code(503);
    echo json_encode([
        "status" => "error",
        "message" => "Database not available"
    ]);
    exit;
}

// Prepare query
$sql = "
    SELECT pdf_url
    FROM hemm_docs
    WHERE hemm_id = ?
      AND doc_type = ?
      AND lang = ?
    ORDER BY id DESC
    LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $hemm_id, $doc_type, $lang);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "status" => "success",
        "pdf_url" => $row['pdf_url']
    ]);
} else {
    http_response_code(404);
    echo json_encode([
        "status" => "not_found",
        "message" => "Document not found"
    ]);
}

$stmt->close();
$conn->close();
