<?php
// Enable error reporting for debugging (remove on production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page after logout
header("Location: login.php");
exit;
