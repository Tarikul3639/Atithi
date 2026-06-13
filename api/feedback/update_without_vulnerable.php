<?php
header("Content-Type: application/json");
session_start();
require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
}

$data = json_decode(file_get_contents("php://input"), true);
$rating = isset($data['rating']) ? (int)$data['rating'] : 0;
$comments = isset($data['comments']) ? htmlspecialchars($data['comments'], ENT_QUOTES, 'UTF-8') : '';
$user_id = $_SESSION['user_id'];

if ($rating < 1 || $rating > 5) {
    echo json_encode(["success" => false, "message" => "Invalid rating."]);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE feedbacks SET rating = ?, comments = ?, created_at = CURRENT_TIMESTAMP WHERE user_id = ?");
    $result = $stmt->execute([$rating, $comments, $user_id]);

    if ($result) {
        echo json_encode(["success" => true, "message" => "Feedback updated successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Update failed."]);
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo json_encode(["success" => false, "message" => "Server error during update."]);
}
?>