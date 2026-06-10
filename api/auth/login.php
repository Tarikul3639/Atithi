<?php

session_start();

header("Content-Type: application/json");

require_once "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data['email'] ?? '');
$password = trim($data['password'] ?? '');

if(!$email || !$password){
    echo json_encode([
        "success" => false,
        "message" => "Email and password required"
    ]);
    exit;
}

$stmt = $pdo->prepare(
    "SELECT * FROM users
     WHERE email = :email"
);

$stmt->execute([
    ":email" => $email
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user){
    echo json_encode([
        "success" => false,
        "message" => "User not found"
    ]);
    exit;
}

if(!password_verify($password, $user['password'])){
    echo json_encode([
        "success" => false,
        "message" => "Wrong password"
    ]);
    exit;
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];

echo json_encode([
    "success" => true,
    "message" => "Login successful",
    "user" => [
        "id" => $user['id'],
        "name" => $user['name'],
        "email" => $user['email']
    ]
]);