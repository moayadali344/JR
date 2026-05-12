<?php
require "../../api/db.php";

header("Content-Type: application/json");

$stmt = $pdo->prepare("SELECT r.*, u.username, p.product_name_en FROM requests r JOIN users u ON r.user_id = u.user_id JOIN products p ON r.product_id = p.product_id ORDER BY r.created_at DESC");
$stmt->execute();

$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($requests);
?>