<?php
require "../../api/db.php";

header('Content-Type: application/json');

$name_en = $_POST['name_en'] ?? "";
$name_ar = $_POST['name_ar'] ?? "";
$buy_price = $_POST['buy_price'] ?? 0;
$sell_price = $_POST['sell_price'] ?? 0;
$desc_en = $_POST['desc_en'] ?? "";
$desc_ar = $_POST['desc_ar'] ?? "";
$warning_en = $_POST['warning_en'] ?? "";
$warning_ar = $_POST['warning_ar'] ?? "";
$discount = $_POST['discount_percentage'] ?? 0;
$sell_price_before_dicount = $_POST['price_before_discount'] ?? 0; // Fixed: Added semicolon

$imagePath = null;

// HANDLE IMAGE
if (!empty($_FILES['productimg']['name'])) {
    $file = $_FILES['productimg'];
    $fileName = uniqid() . "_" . str_replace(" ", "_", $file['name']);
    $target = "../../zero-uploads/" . $fileName;

    if (move_uploaded_file($file['tmp_name'], $target)) {
        $imagePath = "zero-uploads/" . $fileName;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Please upload a valid image"]);
    exit;
}

try {
    // INSERT - Added price_before_discount to the query
    $stmt = $pdo->prepare("
        INSERT INTO products
        (product_name_en, product_name_ar, buy_price, sell_price,
         description_en, description_ar, warning_en, warning_ar, 
         product_image, discount_percentage, price_before_discount)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $name_en,
        $name_ar,
        $buy_price,
        $sell_price,
        $desc_en,
        $desc_ar,
        $warning_en,
        $warning_ar,
        $imagePath,
        $discount,
        $sell_price_before_dicount
    ]);

    echo json_encode(["status" => "success", "message" => "Product added"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}