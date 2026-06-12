<?php
header("Content-Type: application/json");
session_start();
require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM feedbacks WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);

    echo json_encode(["success" => true, "message" => "Feedback deleted successfully!"]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo json_encode(["success" => false, "message" => "Failed to delete feedback."]);
}
?>