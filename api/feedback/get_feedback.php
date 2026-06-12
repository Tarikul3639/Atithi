<?php
// Set response header to JSON
header("Content-Type: application/json");
session_start();

// Include database connection
require_once "../config/db.php";

try {
    // Fetch all feedback with user names
    // Join with users table to get the name of the person who gave feedback
    $stmt = $pdo->prepare("SELECT * FROM feedbacks WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);

    echo json_encode([
        "success" => true,
        "feedback" => $stmt->fetch(PDO::FETCH_ASSOC)
    ]);
} catch (PDOException $e) {
    // Log error and return error response
    error_log($e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Unable to fetch feedback data."
    ]);
}
