<?php

const SQL_SERVER_DOMAIN = "localhost";
const SQL_SERVER_PORT = 3306;
const SQL_PASSWORD = "password here";

header("Access-Control-Allow-Origin: *");

if (!isset($_POST["train_id"]) or !isset($_POST["car_number"]) or !isset($_POST["seat_number"])) {
    http_response_code(400);
    echo "'train_id', 'car_number' and 'seat_number' properties are required";
    exit();
}

if (!ctype_digit($_POST["car_number"]) or !ctype_digit($_POST["seat_number"])) {
    http_response_code(400);
    echo "'car_number' and 'seat_number' must be numeric";
    exit();
}

$train_id = mb_substr($_POST["train_id"], 0, 10);
$carNo = (int) $_POST["car_number"];
$seatNo = (int) $_POST["seat_number"];

$pdo = new \PDO("mysql:dbname=train_seat; host=". SQL_SERVER_DOMAIN. "; port=". SQL_SERVER_PORT. "; charset=utf8", "train_seat", SQL_PASSWORD);

$stmt = $pdo->prepare("insert into seats (train_id, car_number, seat_number) values (:train_id, :car_number, :seat_number)");
$stmt->bindValue(":train_id", $train_id, \PDO::PARAM_STR);
$stmt->bindValue(":car_number", $carNo, \PDO::PARAM_INT);
$stmt->bindValue(":seat_number", $seatNo, \PDO::PARAM_INT);

$stmt->execute();

http_response_code(201);
echo "Query OK";