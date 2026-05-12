<?php
require "./db.php";

$stmt = $pdo->prepare("SELECT usd_rate FROM settings WHERE id = 1");
$stmt->execute();

echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
?>