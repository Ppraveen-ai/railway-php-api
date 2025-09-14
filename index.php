<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    "status" => "ok",
    "message" => "PHP API is running",
    "endpoints" => [
        "POST /api.php" => "Insert complaint data into complaints_table"
    ]
]);
