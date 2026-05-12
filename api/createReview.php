<?php

session_start();

header("Content-Type: application/json");

require_once "./db.php";

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "success" => false,
        "message" => "Login required"
    ]);

    exit;
}

$user_id = $_SESSION['user_id'];

$product_id = $_POST['product_id'] ?? null;
$rating = $_POST['rating'] ?? null;
$comment = trim($_POST['comment'] ?? "");

if (!$product_id || !$rating) {

    echo json_encode([
        "success" => false,
        "message" => "Missing data"
    ]);

    exit;
}

/*
PREVENT DUPLICATE REVIEW
*/

$check = $pdo->prepare("
SELECT review_id
FROM reviews
WHERE user_id = ?
AND product_id = ?
");

$check->execute([$user_id, $product_id]);

if ($check->fetch()) {

    echo json_encode([
        "success" => false,
        "message" => "You already reviewed this product"
    ]);

    exit;
}

/*
INSERT REVIEW
*/

$stmt = $pdo->prepare("
INSERT INTO reviews (
    user_id,
    product_id,
    rating,
    comment
)
VALUES (?, ?, ?, ?)
");

$stmt->execute([
    $user_id,
    $product_id,
    $rating,
    $comment
]);

/*
UPDATE PRODUCT STATS
*/

$ratingStmt = $pdo->prepare("
SELECT 
AVG(rating) as avg_rating,
COUNT(*) as total_reviews
FROM reviews
WHERE product_id = ?
");

$ratingStmt->execute([$product_id]);

$stats = $ratingStmt->fetch(PDO::FETCH_ASSOC);

$updateProduct = $pdo->prepare("
UPDATE products
SET
rating_average = ?,
rating_count = ?
WHERE product_id = ?
");

$updateProduct->execute([
    round($stats['avg_rating'], 1),
    $stats['total_reviews'],
    $product_id
]);

echo json_encode([
    "success" => true
]);