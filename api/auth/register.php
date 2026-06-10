<?php

header("Content-Type: application/json");

require_once "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$phone = trim($data['phone'] ?? '');
$password = trim($data['password'] ?? '');

if (!$name || !$email || !$phone || !$password) {
    echo json_encode([
        "success" => false,
        "message" => "All fields are required."
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email address."
    ]);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode([
        "success" => false,
        "message" => "Password must be at least 6 characters."
    ]);
    exit;
}

try {

    // Email already exists?
    $check = $pdo->prepare(
        "SELECT id FROM users WHERE email = :email"
    );

    $check->execute([
        ":email" => $email
    ]);

    if ($check->fetch()) {
        echo json_encode([
            "success" => false,
            "message" => "Email already exists."
        ]);
        exit;
    }

    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $stmt = $pdo->prepare(
        "INSERT INTO users (
            name,
            email,
            phone,
            password
        )
        VALUES (
            :name,
            :email,
            :phone,
            :password
        )"
    );

    $stmt->execute([
        ":name" => $name,
        ":email" => $email,
        ":phone" => $phone,
        ":password" => $hashedPassword
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Registration successful."
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}