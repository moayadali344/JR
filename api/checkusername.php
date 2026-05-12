<?php
header("Content-Type: application/json");

require './db.php';
require './helperfunctions.php';

// allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    response("error", "Invalid request method");
}

// get username
$username = trim($_POST['username'] ?? '');

if (empty($username)) {
    response("error", "Username required");
}

// check using helper function
$exists = usernameExists($pdo, $username);

// return result
response("success", "Checked", [
    "exists" => $exists
]); 

?>