<?php
header("Content-Type: application/json");

require './db.php';
require './helperfunctions.php';

// allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    response("error", "Invalid request method", [], 405);
}

// get email
$email = trim($_POST['email'] ?? '');

// empty check
if (empty($email)) {
    response("error", "Email required");
}

// validate format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response("error", "Invalid email format");
}

// check in database
$exists = emailExists($pdo, $email);

// send response
response("success", "Checked", [
    "exists" => $exists
]);
?>