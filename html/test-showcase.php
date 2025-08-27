<?php
/**
 * Test Showcase - Complete Application Preview
 * Access at: http://localhost/singularity/test-showcase.php
 * 
 * This page showcases all screens and functionality for testing purposes
 */

// Get the requested screen from URL parameter
$screen = $_GET['screen'] ?? 'home';

// Sample data for different screens
$sample_user = [
    'name' => 'John Smith',
    'email' => 'john@acme.com',
    'role' => 'Organization Admin',
    'organization' => 'Acme Corporation',
    'subscription_tier' => 'Professional'
];

$sample_stats = [
    'documents' => 247,
    'compliance_checks' => 1,
    'issues' => 8,
    'monthly_docs' => 89
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Showcase - Singularity Compliance</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        .test-navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1050;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .test-content {
            margin-top: 70px;
        }
        .screen-nav {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        .screen-nav .btn {
            margin: 0.2rem;
            border-radius: 20px;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
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
        .pricing-card {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }
        .pricing-card:hover {
            transform: translateY(-10px);
        }
        .pricing-header {
            border-radius: 20px 20px 0 0;
            padding: 2rem;
        }
        .essential-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .professional-header { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .enterprise-header { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .price-display {
            font-size: 3rem;
            font-weight: bold;
            color: white;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        }
        .stat-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card, .register-card {
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        .login-header, .register-header {
            background: linear-gradient(135deg, #4267cd 0%, #3552a4 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .upload-zone {
            border: 3px dashed #dee2e6;
            border-radius: 15px;
            padding: 3rem;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        .upload-zone:hover {
            border-color: #4267cd;
            background: #e3f2fd;
        }
        .compliance-item {
            padding: 1rem;
            margin: 0.5rem 0;
            border-radius: 10px;
            border-left: 4px solid transparent;
        }
        .compliance-passed { 
            background: #d4edda; 
            border-left-color: #28a745; 
        }
        .compliance-failed { 
            background: #f8d7da; 
            border-left-color: #dc3545; 
        }
        .compliance-warning { 
            background: #fff3cd; 
            border-left-color: #ffc107; 
        }
    </style>
</head>
<body>
    <!-- Test Navigation Bar -->
    <nav class="navbar navbar-expand-lg test-navbar">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold" href="?screen=home">
                <i class="bi bi-shield-check me-2"></i>
                Singularity Compliance - Test Showcase
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text text-white-50 me-3">
                    Testing Mode: All Screens Available
                </span>
                <a class="btn btn-outline-light btn-sm" href="#screen-nav">
                    <i class="bi bi-list me-1"></i>All Screens
                </a>
            </div>
        </div>
    </nav>

    <div class="test-content">
        <!-- Screen Navigation -->
        <div class="container mt-3" id="screen-nav">
            <div class="screen-nav">
                <h5 class="mb-3">
                    <i class="bi bi-display me-2"></i>
                    Choose Screen to Test
                </h5>
                <div class="d-flex flex-wrap">
                    <a href="?screen=home" class="btn <?= $screen === 'home' ? 'btn-primary' : 'btn-outline-primary' ?>">🏠 Homepage</a>
                    <a href="?screen=login" class="btn <?= $screen === 'login' ? 'btn-primary' : 'btn-outline-primary' ?>">🔐 Login</a>
                    <a href="?screen=register" class="btn <?= $screen === 'register' ? 'btn-primary' : 'btn-outline-primary' ?>">📝 Register</a>
                    <a href="?screen=subscription" class="btn <?= $screen === 'subscription' ? 'btn-primary' : 'btn-outline-primary' ?>">💳 Subscription</a>
                    <a href="?screen=dashboard" class="btn <?= $screen === 'dashboard' ? 'btn-primary' : 'btn-outline-primary' ?>">📊 Dashboard</a>
                    <a href="?screen=upload" class="btn <?= $screen === 'upload' ? 'btn-primary' : 'btn-outline-primary' ?>">📤 Upload</a>
                    <a href="?screen=documents" class="btn <?= $screen === 'documents' ? 'btn-primary' : 'btn-outline-primary' ?>">📁 Documents</a>
                    <a href="?screen=compliance" class="btn <?= $screen === 'compliance' ? 'btn-primary' : 'btn-outline-primary' ?>">✅ Compliance</a>
                    <a href="?screen=reports" class="btn <?= $screen === 'reports' ? 'btn-primary' : 'btn-outline-primary' ?>">📈 Reports</a>
                    <a href="?screen=admin" class="btn <?= $screen === 'admin' ? 'btn-primary' : 'btn-outline-primary' ?>">👨‍💼 Admin</a>
                </div>
            </div>
        </div>

        <?php switch($screen): case 'home': ?>
        <!-- HOMEPAGE SCREEN -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-4 fw-bold mb-4">Compliance Made Simple</h1>
                        <p class="lead mb-4">
                            Streamline your document compliance with AI-powered checking, 
                            folder structure validation, and comprehensive reporting tools.
                        </p>
                        <div class="d-flex gap-3">
                            <a href="?screen=register" class="btn btn-light btn-lg">
                                <i class="bi bi-rocket-takeoff me-2"></i>Start Free Trial
                            </a>
                            <a href="?screen=subscription" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-play-circle me-2"></i>View Plans
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <i class="bi bi-shield-check display-1 text-white"></i>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold">Powerful Compliance Features</h2>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="feature-card bg-white">
                            <div class="feature-icon">
                                <i class="bi bi-file-check text-white" style="font-size: 2rem;"></i>
                            </div>
                            <h4>Document Validation</h4>
                            <p class="text-muted">Automatically validate documents against compliance standards.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="feature-card bg-white">
                            <div class="feature-icon">
                                <i class="bi bi-folder-check text-white" style="font-size: 2rem;"></i>
                            </div>
                            <h4>Folder Analysis</h4>
                            <p class="text-muted">Scan folder structures and naming conventions automatically.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="feature-card bg-white">
                            <div class="feature-icon">
                                <i class="bi bi-graph-up text-white" style="font-size: 2rem;"></i>
                            </div>
                            <h4>Advanced Analytics</h4>
                            <p class="text-muted">Get detailed reports and compliance insights.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php break; case 'login': ?>
        <!-- LOGIN SCREEN -->
        <div class="container-fluid vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="row w-100 justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="card login-card border-0">
                        <div class="card-header login-header text-center py-4">
                            <h3 class="mb-0">Singularity Compliance</h3>
                            <p class="mb-0 mt-2">Sign in to your account</p>
                        </div>
                        <div class="card-body p-4">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label"><i class="bi bi-envelope me-1"></i>Email</label>
                                    <input type="email" class="form-control form-control-lg" placeholder="Enter your email">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><i class="bi bi-lock me-1"></i>Password</label>
                                    <input type="password" class="form-control form-control-lg" placeholder="Enter password">
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input">
                                    <label class="form-check-label">Remember me</label>
                                </div>
                                <button type="button" class="btn btn-primary btn-lg w-100 mb-3" onclick="alert('Demo: Would login and redirect to dashboard')">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                                </button>
                            </form>
                            <div class="text-center">
                                <a href="?screen=register" class="btn btn-outline-primary">Create Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php break; case 'register': ?>
        <!-- REGISTRATION SCREEN -->
        <div class="container-fluid py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card register-card border-0">
                        <div class="card-header register-header text-center py-4">
                            <h3 class="mb-0">Join Singularity</h3>
                            <p class="mb-0 mt-2">Start your compliance journey</p>
                        </div>
                        <div class="card-body p-4">
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" placeholder="John">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Smith">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control" placeholder="john@company.com">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Organization Name</label>
                                    <input type="text" class="form-control" placeholder="Acme Corporation">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" placeholder="Confirm">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input">
                                        <label class="form-check-label">I agree to Terms & Privacy Policy</label>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary btn-lg w-100" onclick="alert('Demo: Would create account and redirect to dashboard')">
                                    <i class="bi bi-person-plus me-2"></i>Create Account
                                </button>
                            </form>
                            <div class="text-center mt-3">
                                <a href="?screen=login" class="btn btn-outline-primary">Already have account?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php break; case 'subscription': ?>
        <!-- SUBSCRIPTION PLANS SCREEN -->
        <div class="container py-5">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Choose Your Plan</h1>
                <p class="lead text-muted">Select the perfect compliance solution</p>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Essential Plan -->
                <div class="col-lg-4">
                    <div class="card pricing-card border-0">
                        <div class="pricing-header essential-header text-white text-center">
                            <h3 class="fw-bold mb-0">Essential</h3>
                            <p class="mb-3">Perfect for small teams</p>
                            <div class="price-display">$9.99</div>
                            <div style="color: rgba(255,255,255,0.8);">per month</div>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Up to 100 documents/month</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Basic compliance checking</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Standard file formats</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Email support</li>
                            </ul>
                            <button class="btn btn-primary w-100" onclick="alert('Demo: Would redirect to payment')">
                                Get Started
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Professional Plan -->
                <div class="col-lg-4">
                    <div class="card pricing-card border-0">
                        <div class="pricing-header professional-header text-white text-center">
                            <h3 class="fw-bold mb-0">Professional</h3>
                            <p class="mb-3">Most Popular</p>
                            <div class="price-display">$19.99</div>
                            <div style="color: rgba(255,255,255,0.8);">per month</div>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Up to 1,000 documents/month</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Advanced compliance</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Custom rules (5)</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>API access</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Priority support</li>
                            </ul>
                            <button class="btn btn-primary w-100" onclick="alert('Demo: Would redirect to payment')">
                                Get Started
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Enterprise Plan -->
                <div class="col-lg-4">
                    <div class="card pricing-card border-0">
                        <div class="pricing-header enterprise-header text-white text-center">
                            <h3 class="fw-bold mb-0">Enterprise</h3>
                            <p class="mb-3">For large organizations</p>
                            <div class="price-display">$199.99</div>
                            <div style="color: rgba(255,255,255,0.8);">per month</div>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Unlimited documents</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>AI-powered suggestions</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>White-label options</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Dedicated support</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>On-premises deployment</li>
                            </ul>
                            <button class="btn btn-primary w-100" onclick="alert('Demo: Would contact sales')">
                                Contact Sales
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php break; case 'dashboard': ?>
        <!-- DASHBOARD SCREEN -->
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                    <div class="position-sticky pt-3">
                        <div class="text-center mb-4">
                            <h4 class="text-white">Singularity</h4>
                            <small class="text-white-50">Welcome, <?= $sample_user['name'] ?></small>
                        </div>
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="#" style="background: rgba(255,255,255,0.2); border-radius: 8px;">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="?screen=upload">
                                    <i class="bi bi-cloud-upload me-2"></i>Upload Documents
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="?screen=documents">
                                    <i class="bi bi-files me-2"></i>My Documents
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="?screen=compliance">
                                    <i class="bi bi-check-square me-2"></i>Compliance
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="?screen=reports">
                                    <i class="bi bi-graph-up me-2"></i>Reports
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                        <a href="?screen=upload" class="btn btn-primary">
                            <i class="bi bi-cloud-upload me-1"></i>Upload Documents
                        </a>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon bg-primary">
                                            <i class="bi bi-files text-white fs-4"></i>
                                        </div>
                                        <div class="ms-3">
                                            <div class="fs-4 fw-bold text-primary"><?= $sample_stats['documents'] ?></div>
                                            <small class="text-muted">Documents</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon bg-success">
                                            <i class="bi bi-check-circle text-white fs-4"></i>
                                        </div>
                                        <div class="ms-3">
                                            <div class="fs-4 fw-bold text-success"><?= $sample_stats['compliance_checks'] ?></div>
                                            <small class="text-muted">Checks</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon bg-warning">
                                            <i class="bi bi-exclamation-triangle text-white fs-4"></i>
                                        </div>
                                        <div class="ms-3">
                                            <div class="fs-4 fw-bold text-warning"><?= $sample_stats['issues'] ?></div>
                                            <small class="text-muted">Issues</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon bg-info">
                                            <i class="bi bi-calendar-month text-white fs-4"></i>
                                        </div>
                                        <div class="ms-3">
                                            <div class="fs-4 fw-bold text-info"><?= $sample_stats['monthly_docs'] ?></div>
                                            <small class="text-muted">This Month</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Documents -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Recent Documents</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Document</th>
                                            <th>Size</th>
                                            <th>Status</th>
                                            <th>Uploaded</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><i class="bi bi-file-earmark-pdf me-2"></i>Company_Policy_2024.pdf</td>
                                            <td>2.1 MB</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td>Dec 15, 2024</td>
                                        </tr>
                                        <tr>
                                            <td><i class="bi bi-file-earmark-text me-2"></i>Procedure_Manual.docx</td>
                                            <td>1.5 MB</td>
                                            <td><span class="badge bg-warning">Processing</span></td>
                                            <td>Dec 14, 2024</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <?php break; case 'upload': ?>
        <!-- UPLOAD SCREEN -->
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                    <div class="position-sticky pt-3">
                        <div class="text-center mb-4">
                            <h4 class="text-white">Singularity</h4>
                        </div>
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="?screen=dashboard">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="#" style="background: rgba(255,255,255,0.2); border-radius: 8px;">
                                    <i class="bi bi-cloud-upload me-2"></i>Upload Documents
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Upload Documents</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="upload-zone" onclick="alert('Demo: Would open file picker')">
                                        <i class="bi bi-cloud-upload display-1 text-muted mb-3"></i>
                                        <h4>Drag & Drop Files Here</h4>
                                        <p class="text-muted">Or click to browse files</p>
                                        <button class="btn btn-primary">
                                            <i class="bi bi-folder me-2"></i>Browse Files
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Upload Guidelines</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Max file size: 100MB</li>
                                        <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Supported: PDF, DOC, DOCX</li>
                                        <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Batch upload available</li>
                                        <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Auto virus scanning</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <?php break; case 'documents': ?>
        <!-- DOCUMENTS SCREEN -->
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                    <div class="position-sticky pt-3">
                        <div class="text-center mb-4">
                            <h4 class="text-white">Singularity</h4>
                        </div>
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="?screen=dashboard">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="#" style="background: rgba(255,255,255,0.2); border-radius: 8px;">
                                    <i class="bi bi-files me-2"></i>My Documents
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">My Documents</h1>
                        <div>
                            <button class="btn btn-outline-secondary me-2">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                            <a href="?screen=upload" class="btn btn-primary">
                                <i class="bi bi-cloud-upload me-1"></i>Upload
                            </a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Document</th>
                                            <th>Size</th>
                                            <th>Status</th>
                                            <th>Compliance</th>
                                            <th>Uploaded</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                                Company_Policy_2024.pdf
                                            </td>
                                            <td>2.1 MB</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td><span class="badge bg-success">Passed</span></td>
                                            <td>Dec 15, 2024</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary" title="Download">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="bi bi-file-earmark-text text-primary me-2"></i>
                                                Procedure_Manual.docx
                                            </td>
                                            <td>1.5 MB</td>
                                            <td><span class="badge bg-warning">Processing</span></td>
                                            <td><span class="badge bg-secondary">Pending</span></td>
                                            <td>Dec 14, 2024</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary" title="Download">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="bi bi-file-earmark-text text-warning me-2"></i>
                                                ISO_Report.docx
                                            </td>
                                            <td>3.2 MB</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td><span class="badge bg-warning">Warning</span></td>
                                            <td>Dec 13, 2024</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary" title="Download">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <?php break; case 'compliance': ?>
        <!-- COMPLIANCE SCREEN -->
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                    <div class="position-sticky pt-3">
                        <div class="text-center mb-4">
                            <h4 class="text-white">Singularity</h4>
                        </div>
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="?screen=dashboard">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="#" style="background: rgba(255,255,255,0.2); border-radius: 8px;">
                                    <i class="bi bi-check-square me-2"></i>Compliance
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Compliance Dashboard</h1>
                        <button class="btn btn-primary" onclick="alert('Demo: Would run compliance check on all documents')">
                            <i class="bi bi-play-circle me-1"></i>Run Check
                        </button>
                    </div>

                    <!-- Compliance Summary -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-success">85%</h3>
                                    <p class="text-muted">Overall Compliance Score</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-primary">234</h3>
                                    <p class="text-muted">Documents Checked</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-warning">12</h3>
                                    <p class="text-muted">Issues Found</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Compliance Issues -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Recent Compliance Checks</h5>
                        </div>
                        <div class="card-body">
                            <div class="compliance-item compliance-passed">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Company_Policy_2024.pdf</strong>
                                        <br><small class="text-muted">PDF Format Validation</small>
                                    </div>
                                    <div class="text-success">
                                        <i class="bi bi-check-circle-fill me-2"></i>PASSED
                                    </div>
                                </div>
                            </div>
                            
                            <div class="compliance-item compliance-warning">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>ISO_Report.docx</strong>
                                        <br><small class="text-muted">Document naming convention check</small>
                                    </div>
                                    <div class="text-warning">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>WARNING
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">Document name doesn't follow ISO naming standard</small>
                                </div>
                            </div>
                            
                            <div class="compliance-item compliance-failed">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>old_document.doc</strong>
                                        <br><small class="text-muted">File format validation</small>
                                    </div>
                                    <div class="text-danger">
                                        <i class="bi bi-x-circle-fill me-2"></i>FAILED
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">Legacy format not supported in current policy</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <?php break; case 'reports': ?>
        <!-- REPORTS SCREEN -->
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                    <div class="position-sticky pt-3">
                        <div class="text-center mb-4">
                            <h4 class="text-white">Singularity</h4>
                        </div>
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="?screen=dashboard">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="#" style="background: rgba(255,255,255,0.2); border-radius: 8px;">
                                    <i class="bi bi-graph-up me-2"></i>Reports
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Reports & Analytics</h1>
                        <button class="btn btn-primary" onclick="alert('Demo: Would open report generator')">
                            <i class="bi bi-plus-circle me-1"></i>Generate Report
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Compliance Trends</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="complianceChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Recent Reports</h5>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Monthly Compliance Report</strong>
                                                <br><small class="text-muted">December 2024</small>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary">Download</button>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>ISO Audit Summary</strong>
                                                <br><small class="text-muted">November 2024</small>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary">Download</button>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Document Analysis</strong>
                                                <br><small class="text-muted">October 2024</small>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary">Download</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <?php break; case 'admin': ?>
        <!-- ADMIN SCREEN (Simplified) -->
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-3 col-lg-2 d-md-block" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); min-height: 100vh;">
                    <div class="position-sticky pt-3">
                        <div class="text-center mb-4">
                            <h4 class="text-white">Admin Panel</h4>
                        </div>
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="#" style="background: rgba(255,255,255,0.2); border-radius: 8px;">
                                    <i class="bi bi-speedometer2 me-2"></i>Overview
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="#">
                                    <i class="bi bi-building me-2"></i>Organizations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="#">
                                    <i class="bi bi-people me-2"></i>Users
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">System Administration</h1>
                    </div>

                    <!-- Admin Stats -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card stat-card text-center">
                                <div class="card-body">
                                    <div class="stat-icon bg-primary mx-auto mb-2">
                                        <i class="bi bi-building text-white fs-3"></i>
                                    </div>
                                    <h3 class="text-primary">24</h3>
                                    <p class="text-muted">Organizations</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card stat-card text-center">
                                <div class="card-body">
                                    <div class="stat-icon bg-success mx-auto mb-2">
                                        <i class="bi bi-people text-white fs-3"></i>
                                    </div>
                                    <h3 class="text-success">147</h3>
                                    <p class="text-muted">Users</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card stat-card text-center">
                                <div class="card-body">
                                    <div class="stat-icon bg-warning mx-auto mb-2">
                                        <i class="bi bi-files text-white fs-3"></i>
                                    </div>
                                    <h3 class="text-warning">8,432</h3>
                                    <p class="text-muted">Documents</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card stat-card text-center">
                                <div class="card-body">
                                    <div class="stat-icon bg-info mx-auto mb-2">
                                        <i class="bi bi-check-square text-white fs-3"></i>
                                    </div>
                                    <h3 class="text-info">12,845</h3>
                                    <p class="text-muted">Checks</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Organizations Table -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Organizations</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Organization</th>
                                            <th>Plan</th>
                                            <th>Users</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Acme Corporation</strong></td>
                                            <td><span class="badge bg-warning text-dark">Enterprise</span></td>
                                            <td>25</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">View</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tech Solutions</strong></td>
                                            <td><span class="badge bg-primary">Professional</span></td>
                                            <td>8</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">View</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <?php break; default: ?>
        <div class="container mt-5 text-center">
            <h2>Screen Not Found</h2>
            <p>The requested screen "<?= htmlspecialchars($screen) ?>" doesn't exist.</p>
            <a href="?screen=home" class="btn btn-primary">Go to Homepage</a>
        </div>
        <?php endswitch; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize charts when on reports page
        <?php if ($screen === 'reports'): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('complianceChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Compliance Score',
                            data: [75, 82, 80, 85, 88, 85],
                            borderColor: '#4267cd',
                            backgroundColor: 'rgba(66, 103, 205, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, max: 100 }
                        }
                    }
                });
            }
        });
        <?php endif; ?>

        // Add smooth scrolling to screen navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>