<?php
session_start();

// remove all session data
$_SESSION = [];

// destroy session
session_destroy();

// optional: return JSON (better for API style)
echo json_encode(["success" => true]);

exit?>