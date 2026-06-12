<?php
header("Content-Type: application/json");
require_once "../config/db.php";

// ⚠️ VULNERABILITY ADDED: intval() সরিয়ে ফেলা হয়েছে, সরাসরি $_GET নেওয়া হচ্ছে
$id = $_GET['id'] ?? '0';

// বাকি অংশ সুরক্ষিত রাখার চেষ্টা করা হয়েছে (যেমন error handling, output structure)
if(!$id){
    echo json_encode(["success" => false, "message" => "Room ID required"]);
    exit;
}

try {
    // ❌ VULNERABLE QUERY: স্ট্রিং কনকাটেনেশন (SQL injection সম্ভব)
    $query = "SELECT * FROM rooms WHERE id = $id";
    $result = $pdo->query($query);
    $room = $result->fetch(PDO::FETCH_ASSOC);

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
    // নিরাপদ error message (ডিবাগ তথ্য বাইরে দেয়া হয়নি)
    echo json_encode([
        "success" => false,
        "message" => "Database error occurred"
    ]);
}
?>