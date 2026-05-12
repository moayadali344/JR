<?php

function response($status, $message, $extra = []) {
    echo json_encode(array_merge([
        "status" => $status,
        "message" => $message
    ], $extra));
    exit;
}

function usernameExists($pdo, $username) {
    $stmt = $pdo->prepare("SELECT 1 FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    return (bool) $stmt->fetch();
}

function emailExists($pdo, $email) {
    $stmt = $pdo->prepare("SELECT 1 FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    return (bool) $stmt->fetch();
}

function validateInput($data) {
    if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['gender'])) {
        response("error", "All fields required");
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        response("error", "Invalid email");
    }

    if (strlen($data['password']) < 6) {
        response("error", "Password too short");
    }
}
?>