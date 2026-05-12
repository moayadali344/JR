<?php
header('Content-Type: application/json');
require_once '../api/db.php';


// Get total revenue
$stmt = $pdo->query("SELECT SUM(total_price) as total FROM requests WHERE request_status = 'completed'");
$totalRevenue = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// Get order counts
$stmt = $pdo->query("SELECT COUNT(*) as count FROM requests WHERE request_status = 'completed'");
$completedOrders = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM requests WHERE request_status = 'pending'");
$pendingOrders = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Get product count
$stmt = $pdo->query("SELECT COUNT(*) as count FROM products");
$totalProducts = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Get most popular product
$stmt = $pdo->query("
    SELECT p.product_name_en, COUNT(r.request_id) as order_count
    FROM requests r
    JOIN products p ON r.product_id = p.product_id
    GROUP BY r.product_id
    ORDER BY order_count DESC
    LIMIT 1
");
$mostPopular = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'totalRevenue' => number_format($totalRevenue, 2),
    'completedOrders' => $completedOrders,
    'pendingOrders' => $pendingOrders,
    'totalOrders' => $completedOrders + $pendingOrders,
    'totalProducts' => $totalProducts,
    'mostPopular' => $mostPopular['product_name_en'] ?? 'N/A'
]);
?>