<?php

header("Content-Type: application/json");

require_once "./db.php";

$product_id = $_GET['product_id'] ?? null;

if (!$product_id) {

    echo json_encode([
        "success" => false
    ]);

    exit;
}

$stmt = $pdo->prepare("
SELECT
    r.rating,
    r.comment,
    r.created_at,

    u.username,
    u.profile_pic

FROM reviews r

JOIN users u
ON r.user_id = u.user_id

WHERE r.product_id = ?

ORDER BY r.created_at DESC
");

$stmt->execute([$product_id]);

$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "reviews" => $reviews
]);