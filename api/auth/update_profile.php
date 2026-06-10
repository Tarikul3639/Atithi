<?php

session_start();

header("Content-Type: application/json");

require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);

    exit;
}

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$name = trim($data['name'] ?? '');
$phone = trim($data['phone'] ?? '');

if (!$name || !$phone) {

    echo json_encode([
        "success" => false,
        "message" => "Name and phone are required."
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare(
        "UPDATE users
         SET
            name = :name,
            phone = :phone
         WHERE id = :id"
    );

    $stmt->execute([
        ":name" => $name,
        ":phone" => $phone,
        ":id" => $_SESSION['user_id']
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Profile updated successfully."
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}