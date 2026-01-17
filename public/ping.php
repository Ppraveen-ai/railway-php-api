<?php
$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");
$db   = getenv("DB_NAME");
$port = getenv("DB_PORT") ?: 3306;

$maxTries = 5;
$delaySeconds = 2;

for ($i = 1; $i <= $maxTries; $i++) {
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = @new mysqli($host, $user, $pass, $db, $port);

    if (!$conn->connect_error) {
        $conn->query("SELECT 1");
        echo "OK";
        $conn->close();
        exit;
    }

    sleep($delaySeconds);
}

http_response_code(503);
echo "DB_STILL_SLEEPING";
