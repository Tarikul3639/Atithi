<?php

header("Content-Type: application/json");

require_once "../config/db.php";

$id = intval($_GET['id'] ?? 0);

if(!$id){
    echo json_encode([
        "success" => false,
        "message" => "Room ID required"
    ]);
    exit;
}

try{

    $stmt = $pdo->prepare(
        "SELECT * FROM rooms
         WHERE id = :id"
    );

    $stmt->execute([
        ":id" => $id
    ]);

    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$room){
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

}catch(PDOException $e){

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}