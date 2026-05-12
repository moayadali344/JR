<?php
require "../../api/db.php";

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

$id = $_POST["product_id"] ?? null;

if (!$id) {
    echo json_encode(["status" => "error", "message" => "Missing product ID"]);
    exit;
}

$name_en = $_POST["name_en"] ?? "";
$name_ar = $_POST["name_ar"] ?? "";
$buy_price = $_POST["buy_price"] ?? 0;
$sell_price = $_POST["sell_price"] ?? 0;
$desc_en = $_POST["desc_en"] ?? "";
$desc_ar = $_POST["desc_ar"] ?? "";
$warning_en = $_POST["warning_en"] ?? "";
$warning_ar = $_POST["warning_ar"] ?? "";
$discount = $_POST["discount_percentage"] ?? 0;
// Fixed: Added missing semicolon below
$sell_price_before_dicount = $_POST['price_before_discount'] ?? 0; 


/* ======================
   IMAGE UPLOAD (optional)
====================== */
$imagePath = null;

if (!empty($_FILES["productimg"]["name"])) {
    $fileName = time() . "_" . basename($_FILES["productimg"]["name"]);
    $targetPath = "../uploads/" . $fileName;

    if (move_uploaded_file($_FILES["productimg"]["tmp_name"], $targetPath)) {
        $imagePath = "uploads/" . $fileName;
    }
}

/* ======================
   UPDATE QUERY
====================== */
try {
    if ($imagePath) {
        // Fixed: Added missing comma before price_before_discount
        $sql = "UPDATE products SET 
            product_name_en = ?,
            product_name_ar = ?,
            buy_price = ?,
            sell_price = ?,
            description_en = ?,
            description_ar = ?,
            warning_en = ?,
            warning_ar = ?,
            product_image = ?,
            discount_percentage = ?,
            price_before_discount = ?
            WHERE product_id = ?";
            
        $stmt = $pdo->prepare($sql);
        // Fixed: Added missing comma after $sell_price_before_dicount
        $stmt->execute([
            $name_en, $name_ar, $buy_price, $sell_price, 
            $desc_en, $desc_ar, $warning_en, $warning_ar, 
            $imagePath, $discount, $sell_price_before_dicount, $id
        ]);
    } else {
        // Fixed: Added missing comma before price_before_discount
        $sql = "UPDATE products SET 
            product_name_en = ?,
            product_name_ar = ?,
            buy_price = ?,
            sell_price = ?,
            description_en = ?,
            description_ar = ?,
            warning_en = ?,
            warning_ar = ?,
            discount_percentage = ?,
            price_before_discount = ?
            WHERE product_id = ?";

        $stmt = $pdo->prepare($sql);
        // Fixed: Added missing comma after $sell_price_before_dicount
        $stmt->execute([
            $name_en, $name_ar, $buy_price, $sell_price, 
            $desc_en, $desc_ar, $warning_en, $warning_ar, 
            $discount, $sell_price_before_dicount, $id
        ]);
    }

    echo json_encode([
        "status" => "success",
        "message" => "Product updated successfully"
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error", 
        "message" => "Database error: " . $e->getMessage()
    ]);
}
?>