<?php
/**
 * Subscription Plans Page
 * Compliance Checking SaaS
 */

require_once 'config/constants.php';
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';

// Get flash message if any
$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subscription Plans - <?php echo APP_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .pricing-card {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }
        .pricing-header {
            border-radius: 20px 20px 0 0;
            padding: 2rem;
        }
        .essential-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .professional-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .enterprise-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .price-display {
            font-size: 3rem;
            font-weight: bold;
            color: white;
        }
        .price-period {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
        }
        .feature-list {
            padding: 0;
        }
        .feature-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid #f8f9fa;
        }
        .feature-item:last-child {
            border-bottom: none;
        }
        .popular-badge {
            position: absolute;
            top: -15px;
            right: 20px;
            background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%);
            color: #2d3436;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: bold;
            font-size: 0.875rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-shield-check me-2"></i>
                <?php echo APP_NAME; ?>
            </a>
            <div class="navbar-nav ms-auto">
                <?php if (isLoggedIn()): ?>
                    <a class="nav-link" href="/dashboard.php">Dashboard</a>
                    <a class="nav-link" href="/logout.php">Logout</a>
                <?php else: ?>
                    <a class="nav-link" href="/login.php">Login</a>
                    <a class="nav-link" href="/register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <?php if ($flash): ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($flash['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Header Section -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-primary mb-3">Choose Your Plan</h1>
            <p class="lead text-muted">Select the perfect compliance solution for your organization</p>
        </div>

        <!-- Pricing Cards -->
        <div class="row g-4 justify-content-center">
            <!-- Essential Plan -->
            <div class="col-lg-4 col-md-6">
                <div class="card pricing-card border-0">
                    <div class="pricing-header essential-header text-white text-center">
                        <h3 class="fw-bold mb-0">Essential</h3>
                        <p class="mb-3">Perfect for small teams</p>
                        <div class="price-display">$9.99</div>
                        <div class="price-period">per month</div>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled feature-list">
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Basic compliance checking
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Up to 100 documents/month
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Standard file formats (PDF, DOC, DOCX)
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Basic reporting
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Email support
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent p-4">
                        <button class="btn btn-primary btn-lg w-100" onclick="selectPlan('essential')">
                            <i class="bi bi-arrow-right-circle me-2"></i>Get Started
                        </button>
                    </div>
                </div>
            </div>

            <!-- Professional Plan -->
            <div class="col-lg-4 col-md-6">
                <div class="card pricing-card border-0 position-relative">
                    <div class="popular-badge">
                        <i class="bi bi-star-fill me-1"></i>Most Popular
                    </div>
                    <div class="pricing-header professional-header text-white text-center">
                        <h3 class="fw-bold mb-0">Professional</h3>
                        <p class="mb-3">Great for growing businesses</p>
                        <div class="price-display">$19.99</div>
                        <div class="price-period">per month</div>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled feature-list">
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Advanced compliance checking
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Up to 1,000 documents/month
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Extended file formats (XML, CSV, images)
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Custom compliance rules (5 rules)
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Advanced analytics & dashboards
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Priority email support
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                API access
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent p-4">
                        <button class="btn btn-primary btn-lg w-100" onclick="selectPlan('professional')">
                            <i class="bi bi-arrow-right-circle me-2"></i>Get Started
                        </button>
                    </div>
                </div>
            </div>

            <!-- Enterprise Plan -->
            <div class="col-lg-4 col-md-6">
                <div class="card pricing-card border-0">
                    <div class="pricing-header enterprise-header text-white text-center">
                        <h3 class="fw-bold mb-0">Enterprise</h3>
                        <p class="mb-3">For large organizations</p>
                        <div class="price-display">$199.99</div>
                        <div class="price-period">per month</div>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled feature-list">
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Unlimited compliance checking
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Unlimited documents
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                All file formats supported
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Unlimited custom compliance rules
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                AI-powered compliance suggestions
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                White-label options
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Dedicated account manager
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Phone & email support
                            </li>
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                On-premises deployment option
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent p-4">
                        <button class="btn btn-primary btn-lg w-100" onclick="selectPlan('enterprise')">
                            <i class="bi bi-arrow-right-circle me-2"></i>Contact Sales
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <h3 class="text-center mb-4">Frequently Asked Questions</h3>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Can I change my plan at any time?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, you can upgrade or downgrade your subscription at any time. Changes take effect immediately and billing is prorated.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Is there a free trial available?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, all new accounts start with a 14-day free trial on the Professional plan to test all features.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We accept all major credit cards, PayPal, and bank transfers for Enterprise customers.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">© 2024 <?php echo APP_NAME; ?>. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="/terms.php" class="text-white-50 text-decoration-none me-3">Terms</a>
                    <a href="/privacy.php" class="text-white-50 text-decoration-none">Privacy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function selectPlan(planType) {
            <?php if (isLoggedIn()): ?>
                // If user is logged in, redirect to payment
                window.location.href = '/payment.php?plan=' + planType;
            <?php else: ?>
                // If not logged in, redirect to registration with plan parameter
                window.location.href = '/register.php?plan=' + planType;
            <?php endif; ?>
        }
    </script>
</body>
</html>