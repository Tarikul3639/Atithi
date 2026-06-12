<?php
header("Content-Type: application/json");
require_once "../config/db.php";

// 1. Sanitize input
$id = intval($_GET['id'] ?? 0);

if(!$id){
    echo json_encode(["success" => false, "message" => "Valid Room ID required"]);
    exit;
}

try {
    // 2. Correct way to execute prepared statement
    $query = "SELECT * FROM rooms WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $id]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$room) {
        echo json_encode([
            "success" => false,
            "message" => "Room not found"
        ]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "room" => $room
    ]);
} catch (PDOException $e) {
    // 3. Hide actual DB error in production for security
    echo json_encode([
        "success" => false,
        "message" => "Database error occurred" 
    ]);
}
?>