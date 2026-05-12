<?php
require "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare("
UPDATE requests
SET request_status = ?,
    request_result = ?,
    payment_status = ?
WHERE request_id = ?
");

$stmt->execute([
    $data["status"],
    $data["result"],
    $data["payment_status"],
    $data["request_id"]
]);

echo json_encode(["message"=>"updated"]);
?>