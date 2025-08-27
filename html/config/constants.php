<?php
/**
 * Application Constants
 * Compliance Checking SaaS
 */

// Application Info
define('APP_NAME', 'Singularity Compliance');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost');

// Security
define('CSRF_TOKEN_NAME', 'csrf_token');
define('SESSION_TIMEOUT', 3600); // 1 hour

// File Upload Settings
define('MAX_FILE_SIZE', 104857600); // 100MB in bytes
define('UPLOAD_DIR', '../uploads/');

// Subscription Tiers
define('TIER_ESSENTIAL', 'essential');
define('TIER_PROFESSIONAL', 'professional'); 
define('TIER_ENTERPRISE', 'enterprise');

// Tier Limits
define('ESSENTIAL_DOCS_LIMIT', 100);
define('PROFESSIONAL_DOCS_LIMIT', 1000);
define('ENTERPRISE_DOCS_LIMIT', -1); // unlimited

// Stripe Configuration (sandbox)
define('STRIPE_PUBLIC_KEY', 'pk_test_your_key_here');
define('STRIPE_SECRET_KEY', 'sk_test_your_key_here');

// Email Settings
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your_email@gmail.com');
define('SMTP_PASSWORD', 'your_password');

// Supported File Types by Tier
$SUPPORTED_TYPES = [
    TIER_ESSENTIAL => ['pdf', 'doc', 'docx', 'txt'],
    TIER_PROFESSIONAL => ['pdf', 'doc', 'docx', 'txt', 'xml', 'csv', 'jpg', 'png', 'gif', 'ppt', 'pptx', 'xls', 'xlsx'],
    TIER_ENTERPRISE => ['*'] // all types
];
?>