<?php
header("Content-Type: application/json");

require './db.php';
require './helperfunctions.php';

// method check
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    response("error", "Invalid request");
}

// input
$data = [
    "username" => $_POST['username'] ?? '',
    "email" => $_POST['email'] ?? '',
    "password" => $_POST['password'] ?? '',
    "gender" => $_POST['gender'] ?? ''
];

// validate
validateInput($data);

// duplicates
if (usernameExists($pdo, $data['username'])) {
    response("error", "Username already exists");
}

if (emailExists($pdo, $data['email'])) {
    response("error", "Email already exists");
}

// create user
$hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare(
        "INSERT INTO users (username, email, password, gender) VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([
        $data['username'],
        $data['email'],
        $hashedPassword,
        $data['gender']
    ]);


$userId = $pdo->lastInsertId();
$stmt = $pdo->prepare("
    SELECT user_id, username, email, gender, created_at, profile_pic 
    FROM users 
    WHERE user_id = ?
");


$stmt->execute([$userId]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

session_start();

//will be onssestopn if user go te seeting pafe no need to query and take process from database
$_SESSION['user_id'] = $userId;
$_SESSION['username'] = $data['username'];
$_SESSION['gender'] = $data['gender'];
$_SESSION['email'] = $data['email'];
$_SESSION['create_date'] = $user['created_at'];
$_SESSION['avatar']= $user['profile_pic'];



    response("success", "User created");




} catch (PDOException $e) {
    response("error", "Database error");
}