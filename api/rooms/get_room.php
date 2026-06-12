<?php
header("Content-Type: application/json");
require_once "../config/db.php";

// ❌ VULNERABLE: সরাসরি $_GET['id'] ব্যবহার, কোনো sanitization বা prepared statement নেই
// $id = $_GET['id'] ?? '0';

// ✅ SAFE (commented): intval() ব্যবহার করে integer conversion
$id = intval($_GET['id'] ?? 0);
if(!$id){
    echo json_encode(["success" => false, "message" => "Room ID required"]);
    exit;
}

// ❌ VULNERABLE QUERY – direct concatenation (SQL injection possible)
// $query = "SELECT * FROM rooms WHERE id = $id";

// ✅ SAFE QUERY (commented) – prepared statement ব্যবহার করলে injection বন্ধ হয়
$query = "SELECT * FROM rooms WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute([':id' => $id]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

try {
    // Vulnerable execution
    $result = $pdo->query($query);
    $room = $result->fetch(PDO::FETCH_ASSOC);

    if (!$room) {
        echo json_encode([
            "success" => false,
            "message" => "Room not found",
            "sql" => $query
        ]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "room" => $room,
        "sql" => $query
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage(),
        "sql" => $query
    ]);
}
?>