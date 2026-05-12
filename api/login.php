<?php
session_start();

header("Content-Type: application/json");

require "./db.php";
require "./helperfunctions.php";

// method check
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    response("error", "Invalid request");
}

// input
$input = $_POST['user'] ?? '';
$password = $_POST['password'] ?? '';

// basic validation
if (empty($input) || empty($password)) {
    response("error", "All fields required");
}

// get user (email OR username)
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ? LIMIT 1");
$stmt->execute([$input, $input]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// check user + password
if (!$user || !password_verify($password, $user['password'])) {
    response("error", "Invalid credentials");
}

$_SESSION['user_id'] = $user['user_id'];
$_SESSION['username'] = $user['username'];
$_SESSION['gender'] = $user['gender'];
$_SESSION['email'] = $user['email'];
$_SESSION['create_date'] = $user['created_at'];
$_SESSION['avatar'] = $user['profile_pic'];

// return success + user (for sessionStorage)
response("success", "Login successful", [
    "user" => [
          "id" => $user['user_id'],
        "username" => $user['username'],
        "email" => $user['email'],
        "gender" => $user['gender'],
        "avatar" => $user['profile_pic'],
        "created_at" => $user['created_at']
    ]
]);