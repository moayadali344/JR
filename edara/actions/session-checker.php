<?php
session_start();


// NOT LOGGED IN
if (
    !isset($_SESSION["admin"]) ||
    $_SESSION["admin"] !== true
) {

    http_response_code(403);

    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized"
    ]);

    exit();
}


// SESSION TIMEOUT
if (
    isset($_SESSION["last_activity"]) &&
    time() - $_SESSION["last_activity"] > 3600
) {

    session_unset();

    session_destroy();

    http_response_code(403);

    exit();
}


$_SESSION["last_activity"] = time();