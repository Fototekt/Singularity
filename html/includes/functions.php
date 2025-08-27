<?php
/**
 * Global Helper Functions
 * Compliance Checking SaaS
 */

// Sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Hash password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verify password
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Generate random token
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

// Format file size
function formatFileSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= pow(1024, $pow);
    
    return round($bytes, 2) . ' ' . $units[$pow];
}

// Check if file type is allowed for user's subscription tier
function isFileTypeAllowed($filename, $tier) {
    global $SUPPORTED_TYPES;
    
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allowed_types = $SUPPORTED_TYPES[$tier] ?? [];
    
    return in_array('*', $allowed_types) || in_array($extension, $allowed_types);
}

// Get subscription tier limits
function getTierLimits($tier) {
    switch ($tier) {
        case TIER_ESSENTIAL:
            return [
                'monthly_docs' => ESSENTIAL_DOCS_LIMIT,
                'price' => 9.99,
                'features' => ['Basic compliance checking', 'Standard file formats', 'Basic reporting', 'Email support']
            ];
        case TIER_PROFESSIONAL:
            return [
                'monthly_docs' => PROFESSIONAL_DOCS_LIMIT,
                'price' => 19.99,
                'features' => ['Advanced compliance checking', 'Extended file formats', 'Custom rules (5)', 'Advanced analytics', 'API access']
            ];
        case TIER_ENTERPRISE:
            return [
                'monthly_docs' => ENTERPRISE_DOCS_LIMIT,
                'price' => 199.99,
                'features' => ['Unlimited compliance checking', 'All file formats', 'Unlimited custom rules', 'AI-powered suggestions', 'White-label options', 'Dedicated support']
            ];
        default:
            return getTierLimits(TIER_ESSENTIAL);
    }
}

// Log activity
function logActivity($user_id, $action, $details = '') {
    try {
        $database = new Database();
        $conn = $database->getConnection();
        
        $query = "INSERT INTO activity_logs (user_id, action, details, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id, $action, $details]);
    } catch (Exception $e) {
        error_log("Failed to log activity: " . $e->getMessage());
    }
}

// Send email (basic implementation)
function sendEmail($to, $subject, $body, $is_html = false) {
    $headers = [
        'From' => 'noreply@' . parse_url(APP_URL, PHP_URL_HOST),
        'Reply-To' => 'support@' . parse_url(APP_URL, PHP_URL_HOST),
        'X-Mailer' => 'PHP/' . phpversion()
    ];
    
    if ($is_html) {
        $headers['Content-Type'] = 'text/html; charset=UTF-8';
    }
    
    $header_string = '';
    foreach ($headers as $key => $value) {
        $header_string .= $key . ': ' . $value . "\r\n";
    }
    
    return mail($to, $subject, $body, $header_string);
}

// Redirect with message
function redirect($url, $message = '', $type = 'info') {
    if ($message) {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }
    header('Location: ' . $url);
    exit();
}

// Display flash message
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'info';
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}
?>