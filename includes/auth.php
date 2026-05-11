<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Get dynamic base path for redirects
 */
function getBasePath() {
    $current_path = $_SERVER['PHP_SELF'];
    // Check if we are in a subdirectory
    if (strpos($current_path, '/admin/') !== false || 
        strpos($current_path, '/staff/') !== false || 
        strpos($current_path, '/reservations/') !== false) {
        return '../';
    }
    return '';
}

/**
 * Redirect if not logged in
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: " . getBasePath() . "login.php");
        exit();
    }
}

/**
 * Check if user has a specific role
 */
function hasRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

/**
 * Redirect if not admin
 */
function requireAdmin() {
    requireLogin();
    if (!hasRole('admin')) {
        header("Location: " . getBasePath() . "index.php");
        exit();
    }
}

/**
 * Redirect if not receptionist
 */
function requireReceptionist() {
    requireLogin();
    if (!hasRole('receptionist')) {
        header("Location: " . getBasePath() . "index.php");
        exit();
    }
}

/**
 * Redirect if not admin or receptionist
 */
function requireStaff() {
    requireLogin();
    if (!hasRole('admin') && !hasRole('receptionist')) {
        header("Location: " . getBasePath() . "index.php");
        exit();
    }
}

/**
 * Sanitize input
 */
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>
