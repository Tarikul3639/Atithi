<?php
header("Content-Type: application/json");
require_once "../config/db.php";

// ❌ VULNERABLE: সরাসরি $_GET['id'] ব্যবহার, কোনো sanitization বা prepared statement নেই
$id = $_GET['id'] ?? '0';

// বিপজ্জনক কোয়েরি – এখানে injection হবে
$query = "SELECT * FROM rooms WHERE id = $id";

try {
    $result = $pdo->query($query);
    $room = $result->fetch(PDO::FETCH_ASSOC);
    
    if(!$room){
        echo json_encode([
            "success" => false,
            "message" => "Room not found",
            "sql" => $query   // debugging (শিক্ষকের জন্য দেখাবেন)
        ]);
        exit;
    }
    
    echo json_encode([
        "success" => true,
        "room" => $room,
        "sql" => $query
    ]);
} catch (PDOException $e) {
    // error message sqlmap কে কাজ করতে সাহায্য করে
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage(),
        "sql" => $query
    ]);
}
?>