<?php

session_start();

header("Content-Type: application/json");

require_once "./db.php";

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "success" => false,
        "message" => "Not logged in"
    ]);

    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "
SELECT 
    r.request_id,
    r.request_status,
    r.payment_status,
    r.created_at,
    r.total_price,
    r.request_result,

    p.product_name_en,
    p.product_image

FROM requests r

JOIN products p 
ON r.product_id = p.product_id

WHERE r.user_id = :user_id

ORDER BY r.created_at DESC
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":user_id" => $user_id
]);

$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "requests" => $requests
]);