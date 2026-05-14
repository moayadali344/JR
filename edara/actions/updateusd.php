<?php
require "../../api/db.php";
require "./session-checker.php";

$data = json_decode(file_get_contents("php://input"), true);

$rate = $data["usd_rate"] ?? 0;

if ($rate <= 0) {
    echo json_encode(["status" => "error"]);
    exit;
}

$stmt = $pdo->prepare("UPDATE settings SET usd_rate = ? WHERE id = 1");
$stmt->execute([$rate]);

echo json_encode(["status" => "success"]);