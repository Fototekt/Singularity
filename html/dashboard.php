<?php
/**
 * Dashboard Page
 * Compliance Checking SaaS
 */

require_once 'config/constants.php';
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';
require_once 'classes/User.php';

// Require login
requireLogin();

$current_user = getCurrentUser();
$database = new Database();
$db = $database->getConnection();

// Get user statistics
$stats = [
    'documents_uploaded' => 0,
    'compliance_checks' => 0,
    'issues_found' => 0,
    'documents_this_month' => 0
];

try {
    // Get document count
    $stmt = $db->prepare("SELECT COUNT(*) FROM documents WHERE user_id = ?");
    $stmt->execute([$current_user['id']]);
    $stats['documents_uploaded'] = $stmt->fetchColumn();
    
    // Get compliance checks count
    $stmt = $db->prepare("SELECT COUNT(*) FROM compliance_checks cc 
                         JOIN documents d ON cc.document_id = d.id 
                         WHERE d.user_id = ?");
    $stmt->execute([$current_user['id']]);
    $stats['compliance_checks'] = $stmt->fetchColumn();
    
    // Get issues found
    $stmt = $db->prepare("SELECT COUNT(*) FROM compliance_checks cc 
                         JOIN documents d ON cc.document_id = d.id 
                         WHERE d.user_id = ? AND cc.status IN ('failed', 'warning')");
    $stmt->execute([$current_user['id']]);
    $stats['issues_found'] = $stmt->fetchColumn();
    
    // Get documents this month
    $stmt = $db->prepare("SELECT COUNT(*) FROM documents 
                         WHERE user_id = ? AND MONTH(upload_date) = MONTH(NOW()) AND YEAR(upload_date) = YEAR(NOW())");
    $stmt->execute([$current_user['id']]);
    $stats['documents_this_month'] = $stmt->fetchColumn();
    
} catch (Exception $e) {
    error_log("Dashboard stats error: " . $e->getMessage());
}

// Get recent documents
$recent_documents = [];
try {
    $stmt = $db->prepare("SELECT * FROM documents WHERE user_id = ? ORDER BY upload_date DESC LIMIT 5");
    $stmt->execute([$current_user['id']]);
    $recent_documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log("Recent documents error: " . $e->getMessage());
}

$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - <?php echo APP_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
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
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2) !important;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <!-- Brand -->
                    <div class="text-center mb-4">
                        <h4 class="text-white">
                            <i class="bi bi-shield-check me-2"></i>
                            <?php echo APP_NAME; ?>
                        </h4>
                        <small class="text-white-50">Welcome, <?php echo htmlspecialchars($current_user['email']); ?></small>
                    </div>
                    
                    <!-- Navigation -->
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="/dashboard.php">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/upload.php">
                                <i class="bi bi-cloud-upload me-2"></i>Upload Documents
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/documents.php">
                                <i class="bi bi-files me-2"></i>My Documents
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/compliance.php">
                                <i class="bi bi-check-square me-2"></i>Compliance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/reports.php">
                                <i class="bi bi-graph-up me-2"></i>Reports
                            </a>
                        </li>
                        
                        <?php if (hasRole('compliance_manager')): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/rules.php">
                                <i class="bi bi-gear me-2"></i>Rules
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php if (hasRole('org_admin')): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/users.php">
                                <i class="bi bi-people me-2"></i>Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/settings.php">
                                <i class="bi bi-sliders me-2"></i>Settings
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <li class="nav-item mt-3">
                            <a class="nav-link text-white" href="/subscription.php">
                                <i class="bi bi-credit-card me-2"></i>Subscription
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/profile.php">
                                <i class="bi bi-person me-2"></i>Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <a href="/upload.php" class="btn btn-sm btn-primary">
                            <i class="bi bi-cloud-upload me-1"></i>Upload Documents
                        </a>
                    </div>
                </div>
                
                <?php if ($flash): ?>
                    <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($flash['message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Subscription Status -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title text-info mb-1">Current Plan: <?php echo ucfirst($current_user['subscription_tier']); ?></h6>
                                        <p class="card-text mb-0">
                                            <small class="text-muted">
                                                <?php echo $stats['documents_this_month']; ?>/<?php echo getTierLimits($current_user['subscription_tier'])['monthly_docs'] == -1 ? '∞' : getTierLimits($current_user['subscription_tier'])['monthly_docs']; ?> documents this month
                                            </small>
                                        </p>
                                    </div>
                                    <a href="/subscription.php" class="btn btn-outline-info btn-sm">Upgrade</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-primary">
                                        <i class="bi bi-files text-white fs-4"></i>
                                    </div>
                                    <div class="ms-3">
                                        <div class="fs-4 fw-bold text-primary"><?php echo $stats['documents_uploaded']; ?></div>
                                        <small class="text-muted">Documents Uploaded</small>
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
                                        <div class="fs-4 fw-bold text-success"><?php echo $stats['compliance_checks']; ?></div>
                                        <small class="text-muted">Compliance Checks</small>
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
                                        <div class="fs-4 fw-bold text-warning"><?php echo $stats['issues_found']; ?></div>
                                        <small class="text-muted">Issues Found</small>
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
                                        <div class="fs-4 fw-bold text-info"><?php echo $stats['documents_this_month']; ?></div>
                                        <small class="text-muted">This Month</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Recent Documents</h5>
                            </div>
                            <div class="card-body">
                                <?php if (empty($recent_documents)): ?>
                                    <div class="text-center py-4">
                                        <i class="bi bi-file-earmark text-muted display-4"></i>
                                        <p class="text-muted mt-3">No documents uploaded yet</p>
                                        <a href="/upload.php" class="btn btn-primary">
                                            <i class="bi bi-cloud-upload me-2"></i>Upload Your First Document
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Document</th>
                                                    <th>Size</th>
                                                    <th>Status</th>
                                                    <th>Uploaded</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($recent_documents as $doc): ?>
                                                <tr>
                                                    <td>
                                                        <i class="bi bi-file-earmark-<?php echo $doc['file_type']; ?> me-2"></i>
                                                        <?php echo htmlspecialchars($doc['original_filename']); ?>
                                                    </td>
                                                    <td><?php echo formatFileSize($doc['file_size']); ?></td>
                                                    <td>
                                                        <?php 
                                                        $status_class = match($doc['status']) {
                                                            'completed' => 'success',
                                                            'processing' => 'warning',
                                                            'failed' => 'danger',
                                                            default => 'secondary'
                                                        };
                                                        ?>
                                                        <span class="badge bg-<?php echo $status_class; ?>">
                                                            <?php echo ucfirst($doc['status']); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo date('M j, Y', strtotime($doc['upload_date'])); ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="/upload.php" class="btn btn-primary">
                                        <i class="bi bi-cloud-upload me-2"></i>Upload Documents
                                    </a>
                                    <a href="/compliance.php" class="btn btn-outline-success">
                                        <i class="bi bi-check-square me-2"></i>Run Compliance Check
                                    </a>
                                    <a href="/reports.php" class="btn btn-outline-info">
                                        <i class="bi bi-graph-up me-2"></i>Generate Report
                                    </a>
                                    <?php if (hasRole('compliance_manager')): ?>
                                    <a href="/rules.php" class="btn btn-outline-warning">
                                        <i class="bi bi-gear me-2"></i>Manage Rules
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Tips & Updates</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <small>
                                        <strong>Tip:</strong> Use consistent naming conventions 
                                        for better compliance scores.
                                    </small>
                                </div>
                                <div class="alert alert-success">
                                    <small>
                                        <strong>New:</strong> AI-powered suggestions are now 
                                        available for Enterprise users.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>