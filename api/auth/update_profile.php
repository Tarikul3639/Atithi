<?php
session_start();
header("Content-Type: application/json");
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

// 1. Read data from the raw request body or POST key
$raw = file_get_contents("php://input");

if (empty($raw) && !empty($_POST)) {
    $raw = array_key_first($_POST);
}

// 2. Clean the raw input
$clean_raw = trim($raw, " =\r\n\t");

// 3. Decode the JSON payload
$input = json_decode($clean_raw, true);

// 4. Validate the required fields
if (!$input || !isset($input["name"]) || !isset($input["phone"])) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Name and phone are required.",
        "received_data" => $clean_raw
    ]);
    exit;
}

$name = trim($input["name"]);
$phone = trim($input["phone"]);

// Check if a new password was provided
$password = !empty($input["password"]) ? trim($input["password"]) : null;

// 5. Update the user profile in the database
try {
    if ($password) {
        // Update the profile including the new password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            UPDATE users
            SET
                name = :name,
                phone = :phone,
                password = :password
            WHERE id = :id
        ");

        $stmt->execute([
            ":name" => $name,
            ":phone" => $phone,
            ":password" => $hashedPassword,
            ":id" => $_SESSION["user_id"]
        ]);
    } else {
        // Update only the profile information without changing the password
        $stmt = $pdo->prepare("
            UPDATE users
            SET
                name = :name,
                phone = :phone
            WHERE id = :id
        ");

        $stmt->execute([
            ":name" => $name,
            ":phone" => $phone,
            ":id" => $_SESSION["user_id"]
        ]);
    }

    echo json_encode([
        "success" => true,
        "message" => "Profile updated successfully."
    ]);
} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
?>