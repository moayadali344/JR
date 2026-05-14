<?php

require_once "../../api/db.php";




// ONLY ALLOW POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit();
}


// CHECK INPUT EXISTS
if (
    !isset($_POST["email"]) ||
    !isset($_POST["password"])
) {
    http_response_code(400);
    exit();
}


$email = trim($_POST["email"]);
$password = $_POST["password"];


// BASIC VALIDATION
if (
    empty($email) ||
    empty($password)
) {
    http_response_code(400);
    exit();
}


// QUERY
$stmt = $pdo->prepare("
    SELECT id, username, secret
    FROM numbers
    WHERE email = ?
    LIMIT 1
");

$stmt->execute([$email]);

$admin = $stmt->fetch(PDO::FETCH_ASSOC);


// VERIFY
if (
    $admin &&
    password_verify($password, $admin["secret"])
) {

session_start();


session_set_cookie_params([
    'lifetime' => 0,
    'path' => '../edara',
    'httponly' => true,
    'samesite' => 'Strict'
]);

    session_regenerate_id(true);

    $_SESSION["admin"] = true;

    $_SESSION["admin_id"] = $admin["id"];

    $_SESSION["admin_name"] = $admin["username"];

    $_SESSION["last_activity"] = time();

    header("Location: ../yo.html");
    exit();
}


// SILENT FAIL
// http_response_code(403);
exit();