<?php
/**
 * Homepage
 * Compliance Checking SaaS
 */

require_once 'config/constants.php';
require_once 'includes/session.php';

// If user is logged in, redirect to dashboard
if (isLoggedIn()) {
    header('Location: /dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo APP_NAME; ?> - Compliance Made Simple</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4267cd 0%, #3552a4 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem auto;
        }
        .feature-card {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            height: 100%;
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .stats-section {
            background: #f8f9fa;
        }
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #4267cd;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-shield-check text-primary me-2"></i>
                <?php echo APP_NAME; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="/register.php">Get Started</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Compliance Made Simple</h1>
                    <p class="lead mb-4">
                        Streamline your document compliance with AI-powered checking, 
                        folder structure validation, and comprehensive reporting tools.
                    </p>
                    <div class="d-flex gap-3 mb-4">
                        <a href="/register.php" class="btn btn-light btn-lg">
                            <i class="bi bi-rocket-takeoff me-2"></i>Start Free Trial
                        </a>
                        <a href="/subscription.php" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-play-circle me-2"></i>View Plans
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-4 text-white-50">
                        <small><i class="bi bi-check-circle me-1"></i>14-day free trial</small>
                        <small><i class="bi bi-check-circle me-1"></i>No credit card required</small>
                        <small><i class="bi bi-check-circle me-1"></i>Cancel anytime</small>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="bg-white bg-opacity-10 p-4 rounded-3 backdrop-blur">
                        <i class="bi bi-shield-check display-1 text-white mb-3"></i>
                        <h4 class="text-white">Enterprise-Grade Security</h4>
                        <p class="text-white-50">Your documents are protected with bank-level encryption</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Powerful Compliance Features</h2>
                <p class="lead text-muted">Everything you need to ensure document compliance</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="bi bi-file-check text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h4>Document Validation</h4>
                        <p class="text-muted">
                            Automatically validate PDF, DOC, XML, and other document formats 
                            against your compliance standards.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="bi bi-folder-check text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h4>Folder Structure Analysis</h4>
                        <p class="text-muted">
                            Scan and validate folder structures, naming conventions, 
                            and organizational standards automatically.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h4>Advanced Analytics</h4>
                        <p class="text-muted">
                            Get detailed reports, compliance scores, and insights 
                            to improve your documentation processes.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="bi bi-robot text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h4>AI-Powered Suggestions</h4>
                        <p class="text-muted">
                            Leverage artificial intelligence to get smart recommendations 
                            for compliance improvements.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="bi bi-award text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h4>ISO Standards</h4>
                        <p class="text-muted">
                            Built-in support for ISO 9001, 27001, 14001, and other 
                            international compliance standards.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="bi bi-cloud text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h4>Hybrid Deployment</h4>
                        <p class="text-muted">
                            Choose between cloud-hosted or on-premises deployment 
                            to meet your security requirements.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-5">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-number">10K+</div>
                    <p class="text-muted">Documents Processed</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-number">500+</div>
                    <p class="text-muted">Organizations Trust Us</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-number">99.9%</div>
                    <p class="text-muted">Uptime Guarantee</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-number">24/7</div>
                    <p class="text-muted">Support Available</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="display-6 fw-bold mb-3">Ready to Get Started?</h2>
            <p class="lead mb-4">Join thousands of organizations already using <?php echo APP_NAME; ?></p>
            <a href="/register.php" class="btn btn-light btn-lg me-3">
                <i class="bi bi-rocket-takeoff me-2"></i>Start Free Trial
            </a>
            <a href="/subscription.php" class="btn btn-outline-light btn-lg">
                <i class="bi bi-credit-card me-2"></i>View Pricing
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>
                        <i class="bi bi-shield-check me-2"></i>
                        <?php echo APP_NAME; ?>
                    </h5>
                    <p class="text-white-50">
                        Making document compliance simple and automated for 
                        organizations of all sizes.
                    </p>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6>Product</h6>
                    <ul class="list-unstyled">
                        <li><a href="#features" class="text-white-50 text-decoration-none">Features</a></li>
                        <li><a href="/subscription.php" class="text-white-50 text-decoration-none">Pricing</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">API</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6>Company</h6>
                    <ul class="list-unstyled">
                        <li><a href="#about" class="text-white-50 text-decoration-none">About</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Blog</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6>Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">Help Center</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Documentation</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Status</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6>Legal</h6>
                    <ul class="list-unstyled">
                        <li><a href="/terms.php" class="text-white-50 text-decoration-none">Terms</a></li>
                        <li><a href="/privacy.php" class="text-white-50 text-decoration-none">Privacy</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Security</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2024 <?php echo APP_NAME; ?>. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-white-50 text-decoration-none me-3">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="text-white-50 text-decoration-none me-3">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="#" class="text-white-50 text-decoration-none">
                        <i class="bi bi-github"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>