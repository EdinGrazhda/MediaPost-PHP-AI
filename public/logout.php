<?php
// Start the session
session_start();

// Check if user was logged in
$wasLoggedIn = isset($_SESSION['name']);

// Unset all session variables
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Set a flag to prevent browser back button from accessing cached pages
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect based on whether user was logged in
if ($wasLoggedIn) {
    // User was logged in, redirect to login page
    header("Location: index.php");
} else {
    // No session existed, return 404 for security
    header("HTTP/1.0 404 Not Found");
    include_once('404.php');
    exit();
}
exit();
?>
