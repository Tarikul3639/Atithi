<?php

session_start();

header("Content-Type: application/json");

require_once "../config/db.php";

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$roomId = intval($data['room_id'] ?? 0);
$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$phone = trim($data['phone'] ?? '');
$checkIn = $data['check_in'] ?? '';
$checkOut = $data['check_out'] ?? '';
$guests = intval($data['guests'] ?? 1);
$special = trim($data['special_requests'] ?? '');
$payment = trim($data['payment_method'] ?? 'cash');

if(
    !$roomId ||
    !$name ||
    !$email ||
    !$phone ||
    !$checkIn ||
    !$checkOut
){
    echo json_encode([
        "success" => false,
        "message" => "All required fields must be filled."
    ]);
    exit;
}

try{

    $stmt = $pdo->prepare(
        "SELECT * FROM rooms
         WHERE id = :id"
    );

    $stmt->execute([
        ":id" => $roomId
    ]);

    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$room){
        echo json_encode([
            "success" => false,
            "message" => "Room not found."
        ]);
        exit;
    }

    $nights =
        (strtotime($checkOut) -
        strtotime($checkIn))
        / 86400;

    $subtotal =
        $nights * $room['price'];

    $tax =
        $subtotal * 0.10;

    $total =
        $subtotal + $tax;

    $stmt = $pdo->prepare(
        "INSERT INTO bookings(
            user_id,
            room_id,
            guest_name,
            guest_email,
            guest_phone,
            check_in,
            check_out,
            guests,
            special_requests,
            payment_method,
            total_amount
        )
        VALUES(
            :user_id,
            :room_id,
            :guest_name,
            :guest_email,
            :guest_phone,
            :check_in,
            :check_out,
            :guests,
            :special_requests,
            :payment_method,
            :total_amount
        )"
    );

    $stmt->execute([
        ":user_id" => $_SESSION['user_id'] ?? null,
        ":room_id" => $roomId,
        ":guest_name" => $name,
        ":guest_email" => $email,
        ":guest_phone" => $phone,
        ":check_in" => $checkIn,
        ":check_out" => $checkOut,
        ":guests" => $guests,
        ":special_requests" => $special,
        ":payment_method" => $payment,
        ":total_amount" => $total
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Booking successful"
    ]);

}catch(PDOException $e){

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}