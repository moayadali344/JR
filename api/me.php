<?php
session_start();

header('Content-Type: application/json');

if (isset($_SESSION['user_id'])) {

    echo json_encode([
        "loggedIn" => true,
        "user" => [
            "id" => $_SESSION['user_id'],
            "username" => $_SESSION['username'],
            "email" => $_SESSION['email'],
            "gender" => $_SESSION['gender'],
            "created_at" => $_SESSION['create_date'],
            "avatar" => !empty($_SESSION['avatar']) 
                ? $_SESSION['avatar'] 
                : "https://i.pravatar.cc/40"
        ]
    ]);

} else {

    echo json_encode([
        "loggedIn" => false
    ]);

}
?>