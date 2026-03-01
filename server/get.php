<?php

const SQL_SERVER_DOMAIN = "localhost";
const SQL_SERVER_PORT = 3306;
const SQL_PASSWORD = "password here";

header("Access-Control-Allow-Origin: *");

if (!isset($_GET["train_id"])) {
    http_response_code(400);
    echo "'train_id' property is required";
    exit();
}

$train_id = mb_substr($_GET["train_id"], 0, 10);

$pdo = new \PDO("mysql:dbname=train_seat; host=". SQL_SERVER_DOMAIN. "; port=". SQL_SERVER_PORT. "; charset=utf8", "train_seat", SQL_PASSWORD);

$stmt = $pdo->prepare("select train_id, car_number, seat_number from seats where train_id = :train_id");
$stmt->bindValue(":train_id", $train_id, \PDO::PARAM_STR);
$stmt->execute();

$returnArray = [];
while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
    $returnArray[] = [
        "train_id" => $result["train_id"],
        "car_number" => (int) $result["car_number"],
        "seat_number" => (int) $result["seat_number"]
    ];
}

http_response_code(201);
echo json_encode($returnArray);