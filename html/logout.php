<?php
/**
 * Logout Page
 * Compliance Checking SaaS
 */

require_once 'config/constants.php';
require_once 'includes/session.php';
require_once 'includes/functions.php';

// Log the logout activity
if (isLoggedIn()) {
    $current_user = getCurrentUser();
    logActivity($current_user['id'], 'logout', 'User logged out');
}

// Destroy session and redirect
session_destroy();
redirect('/login.php', 'You have been logged out successfully.');
?>