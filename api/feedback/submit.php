<?php
// Set response header to JSON
header("Content-Type: application/json");
session_start();

// Include database connection file (Adjust the path if needed)
require_once "../config/db.php";    

// Accept only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Please login to submit feedback."]);
    exit;
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Check if user already submitted feedback
try {
    $checkStmt = $pdo->prepare("SELECT id FROM feedbacks WHERE user_id = ?");
    $checkStmt->execute([$user_id]);
    if ($checkStmt->fetch()) {
        echo json_encode(["success" => false, "message" => "You have already submitted your feedback."]);
        exit;
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo json_encode(["success" => false, "message" => "Server error occurred during verification."]);
    exit;
}

// Get input data
$data = json_decode(file_get_contents("php://input"), true);
$rating = isset($data['rating']) ? (int)$data['rating'] : 0;
$comments = isset($data['comments']) ? htmlspecialchars($data['comments'], ENT_QUOTES, 'UTF-8') : '';

// Validate input
if ($rating < 1 || $rating > 5) {
    echo json_encode(["success" => false, "message" => "Please provide a valid rating (1-5)."]);
    exit;
}

try {
    // Insert feedback into the database
    $stmt = $pdo->prepare("INSERT INTO feedbacks (user_id, rating, comments) VALUES (?, ?, ?)");
    $result = $stmt->execute([$user_id, $rating, $comments]);

    if ($result) {
        echo json_encode(["success" => true, "message" => "Thank you for your valuable feedback!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to save feedback. Please try again."]);
    }
} catch (PDOException $e) {
    // Log error for debugging
    error_log($e->getMessage());
    echo json_encode(["success" => false, "message" => "Server error occurred while saving."]);
}
?>