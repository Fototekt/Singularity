<?php
/**
 * Registration Page
 * Compliance Checking SaaS
 */

require_once 'config/constants.php';
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';
require_once 'classes/User.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: /dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'])) {
            $error = 'Invalid request. Please try again.';
        } else {
            $first_name = sanitizeInput($_POST['first_name']);
            $last_name = sanitizeInput($_POST['last_name']);
            $email = sanitizeInput($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $organization_name = sanitizeInput($_POST['organization_name']);
            $terms_accepted = isset($_POST['terms_accepted']);
            
            // Validation
            if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($organization_name)) {
                $error = 'Please fill in all required fields.';
            } else if (!validateEmail($email)) {
                $error = 'Please enter a valid email address.';
            } else if (strlen($password) < 8) {
                $error = 'Password must be at least 8 characters long.';
            } else if ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } else if (!$terms_accepted) {
                $error = 'You must accept the terms and conditions.';
            } else {
                try {
                    $database = new Database();
                    $db = $database->getConnection();
                    
                    // Check if email already exists
                    $user = new User($db);
                    $existing_user = $user->getByEmail($email);
                    
                    if ($existing_user) {
                        $error = 'An account with this email address already exists.';
                    } else {
                        // Create organization first
                        $org_query = "INSERT INTO organizations (name, subscription_tier, subscription_status) VALUES (?, 'essential', 'trial')";
                        $org_stmt = $db->prepare($org_query);
                        $org_stmt->execute([$organization_name]);
                        $organization_id = $db->lastInsertId();
                        
                        // Create user
                        $user_data = [
                            'organization_id' => $organization_id,
                            'email' => $email,
                            'password' => $password,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'role' => 'org_admin' // First user in org becomes admin
                        ];
                        
                        if ($user->create($user_data)) {
                            $success = 'Account created successfully! Please check your email to verify your account.';
                            
                            // Log activity
                            logActivity(null, 'user_registered', 'New user registered: ' . $email);
                            
                            // Send verification email (simplified)
                            $subject = "Welcome to " . APP_NAME;
                            $body = "Thank you for registering! Your account has been created and is ready to use.";
                            sendEmail($email, $subject, $body);
                            
                            // For demo purposes, auto-verify the account
                            $verify_query = "UPDATE users SET email_verified = TRUE, status = 'active' WHERE email = ?";
                            $verify_stmt = $db->prepare($verify_query);
                            $verify_stmt->execute([$email]);
                            
                        } else {
                            $error = 'Failed to create account. Please try again.';
                        }
                    }
                } catch (Exception $e) {
                    $error = 'An error occurred. Please try again later.';
                    error_log("Registration error: " . $e->getMessage());
                }
            }
        }
    }
}

// Generate CSRF token for the form
$csrf_token = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - <?php echo APP_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .register-card {
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        .register-header {
            background: linear-gradient(135deg, #4267cd 0%, #3552a4 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card register-card border-0">
                    <div class="card-header register-header text-center py-4">
                        <h3 class="mb-0">
                            <i class="bi bi-shield-check me-2"></i>
                            Join <?php echo APP_NAME; ?>
                        </h3>
                        <p class="mb-0 mt-2">Start your compliance journey today</p>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                <?php echo htmlspecialchars($success); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <input type="hidden" name="action" value="register">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">
                                        <i class="bi bi-person me-1"></i>First Name *
                                    </label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" 
                                           value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" 
                                           required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">
                                        <i class="bi bi-person me-1"></i>Last Name *
                                    </label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" 
                                           value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>" 
                                           required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-1"></i>Email Address *
                                </label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                                       required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="organization_name" class="form-label">
                                    <i class="bi bi-building me-1"></i>Organization Name *
                                </label>
                                <input type="text" class="form-control" id="organization_name" name="organization_name" 
                                       value="<?php echo isset($_POST['organization_name']) ? htmlspecialchars($_POST['organization_name']) : ''; ?>" 
                                       required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-lock me-1"></i>Password *
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           minlength="8" required>
                                    <div class="form-text">Minimum 8 characters</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirm_password" class="form-label">
                                        <i class="bi bi-lock me-1"></i>Confirm Password *
                                    </label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                           minlength="8" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="terms_accepted" name="terms_accepted" required>
                                    <label class="form-check-label" for="terms_accepted">
                                        I agree to the <a href="/terms.php" target="_blank">Terms of Service</a> 
                                        and <a href="/privacy.php" target="_blank">Privacy Policy</a> *
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="bi bi-person-plus me-2"></i>Create Account
                            </button>
                        </form>
                        
                        <div class="text-center">
                            <p class="mb-0">Already have an account?</p>
                            <a href="/login.php" class="btn btn-outline-primary mt-2">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <small class="text-white-50">
                        © 2024 <?php echo APP_NAME; ?>. All rights reserved.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Password confirmation validation
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        
        function validatePassword() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity("Passwords don't match");
            } else {
                confirmPassword.setCustomValidity('');
            }
        }
        
        password.addEventListener('change', validatePassword);
        confirmPassword.addEventListener('keyup', validatePassword);
    </script>
</body>
</html>