<?php

session_start();

header("Content-Type: application/json");

require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare("
        SELECT

            b.id,
            b.check_in,
            b.check_out,
            b.guests,
            b.total_amount,
            b.booking_status,

            r.name AS room_name,
            r.type AS room_type,
            r.image AS room_image

        FROM bookings b

        INNER JOIN rooms r
            ON b.room_id = r.id

        WHERE b.user_id = :user_id

        ORDER BY b.created_at DESC
    ");

    $stmt->execute([
        ":user_id" => $_SESSION['user_id']
    ]);

    $bookings =
        $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "bookings" => $bookings
    ]);

} catch(PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}