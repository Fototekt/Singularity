<?php
/**
 * Session Management
 * Compliance Checking SaaS
 */

// Start secure session
if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => SESSION_TIMEOUT,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    
    session_start();
}

// CSRF Token functions
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Get current user info
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['user_id'],
        'email' => $_SESSION['user_email'],
        'role' => $_SESSION['user_role'],
        'organization_id' => $_SESSION['organization_id'] ?? null,
        'subscription_tier' => $_SESSION['subscription_tier'] ?? TIER_ESSENTIAL
    ];
}

// Logout user
function logout() {
    session_destroy();
    header('Location: /login.php');
    exit();
}

// Require login
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
}

// Check user role
function hasRole($required_role) {
    $user = getCurrentUser();
    if (!$user) return false;
    
    $role_hierarchy = [
        'end_user' => 1,
        'analyst' => 2,
        'compliance_manager' => 3,
        'org_admin' => 4,
        'system_admin' => 5
    ];
    
    $user_level = $role_hierarchy[$user['role']] ?? 0;
    $required_level = $role_hierarchy[$required_role] ?? 0;
    
    return $user_level >= $required_level;
}
?>