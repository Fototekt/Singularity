<?php
/**
 * Admin Demo Page - Localhost Sample
 * Compliance Checking SaaS
 * 
 * This is a demo page to showcase the admin interface
 * Access at: http://localhost/admin-demo.php
 */

// Sample data for demonstration
$sample_stats = [
    'total_organizations' => 24,
    'total_users' => 147,
    'documents_processed' => 8432,
    'compliance_checks' => 12845
];

$sample_organizations = [
    [
        'id' => 1,
        'name' => 'Acme Corporation',
        'tier' => 'enterprise',
        'users' => 25,
        'documents' => 1247,
        'status' => 'active',
        'created' => '2024-01-15'
    ],
    [
        'id' => 2,
        'name' => 'Tech Solutions Inc',
        'tier' => 'professional',
        'users' => 8,
        'documents' => 423,
        'status' => 'active',
        'created' => '2024-02-20'
    ],
    [
        'id' => 3,
        'name' => 'Small Business LLC',
        'tier' => 'essential',
        'users' => 3,
        'documents' => 89,
        'status' => 'trial',
        'created' => '2024-03-10'
    ],
    [
        'id' => 4,
        'name' => 'Global Industries',
        'tier' => 'enterprise',
        'users' => 45,
        'documents' => 2156,
        'status' => 'active',
        'created' => '2023-11-05'
    ]
];

$sample_recent_activity = [
    ['user' => 'john@acme.com', 'action' => 'Uploaded 5 documents', 'time' => '2 minutes ago'],
    ['user' => 'sarah@techsolutions.com', 'action' => 'Created new compliance rule', 'time' => '15 minutes ago'],
    ['user' => 'admin@global.com', 'action' => 'Generated compliance report', 'time' => '1 hour ago'],
    ['user' => 'mike@smallbiz.com', 'action' => 'Upgraded to Professional plan', 'time' => '2 hours ago'],
    ['user' => 'system', 'action' => 'Automated compliance check completed', 'time' => '3 hours ago']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Singularity Compliance</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js" rel="prefetch">
    
    <style>
        .admin-sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .stat-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        }
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .nav-link.admin-nav {
            color: rgba(255, 255, 255, 0.8) !important;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
        }
        .nav-link.admin-nav:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white !important;
            transform: translateX(5px);
        }
        .nav-link.admin-nav.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white !important;
        }
        .org-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.8rem;
            border-radius: 50px;
        }
        .activity-item {
            padding: 1rem;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .activity-item:hover {
            background-color: #f8f9fa;
            border-left-color: #4267cd;
        }
        .demo-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem;
            text-align: center;
            font-weight: bold;
        }
        .chart-container {
            position: relative;
            height: 300px;
        }
        .metric-trend {
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        .trend-up { color: #28a745; }
        .trend-down { color: #dc3545; }
        .table-custom {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">
    <!-- Demo Banner -->
    <div class="demo-banner">
        🎯 DEMO MODE - Localhost Administration Interface - Sample Data Only
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Admin Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block admin-sidebar">
                <div class="position-sticky pt-4">
                    <!-- Brand -->
                    <div class="text-center mb-4">
                        <h3 class="text-white">
                            <i class="bi bi-shield-check me-2"></i>
                            Singularity
                        </h3>
                        <small class="text-white-50">System Administration</small>
                    </div>
                    
                    <!-- Admin Navigation -->
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link admin-nav active" href="#dashboard">
                                <i class="bi bi-speedometer2 me-3"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link admin-nav" href="#organizations">
                                <i class="bi bi-building me-3"></i>Organizations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link admin-nav" href="#users">
                                <i class="bi bi-people me-3"></i>Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link admin-nav" href="#subscriptions">
                                <i class="bi bi-credit-card me-3"></i>Subscriptions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link admin-nav" href="#documents">
                                <i class="bi bi-files me-3"></i>Documents
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link admin-nav" href="#compliance">
                                <i class="bi bi-check-square me-3"></i>Compliance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link admin-nav" href="#reports">
                                <i class="bi bi-graph-up me-3"></i>Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link admin-nav" href="#settings">
                                <i class="bi bi-gear me-3"></i>System Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link admin-nav" href="#activity">
                                <i class="bi bi-clock-history me-3"></i>Activity Logs
                            </a>
                        </li>
                        
                        <li class="nav-item mt-4 pt-3 border-top border-white-25">
                            <a class="nav-link admin-nav" href="/dashboard.php">
                                <i class="bi bi-arrow-left me-3"></i>Back to App
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link admin-nav" href="/logout.php">
                                <i class="bi bi-box-arrow-right me-3"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Admin Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Header -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="bi bi-speedometer2 me-2 text-primary"></i>
                        System Administration
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-download me-1"></i>Export Data
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-gear me-1"></i>Settings
                            </button>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Add Organization
                        </button>
                    </div>
                </div>
                
                <!-- System Stats -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <div class="stat-icon bg-primary mx-auto">
                                    <i class="bi bi-building text-white fs-3"></i>
                                </div>
                                <h3 class="text-primary fw-bold"><?php echo $sample_stats['total_organizations']; ?></h3>
                                <p class="text-muted mb-0">Organizations</p>
                                <div class="metric-trend trend-up">
                                    <i class="bi bi-arrow-up"></i> +3 this month
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <div class="stat-icon bg-success mx-auto">
                                    <i class="bi bi-people text-white fs-3"></i>
                                </div>
                                <h3 class="text-success fw-bold"><?php echo $sample_stats['total_users']; ?></h3>
                                <p class="text-muted mb-0">Active Users</p>
                                <div class="metric-trend trend-up">
                                    <i class="bi bi-arrow-up"></i> +12 this week
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <div class="stat-icon bg-warning mx-auto">
                                    <i class="bi bi-files text-white fs-3"></i>
                                </div>
                                <h3 class="text-warning fw-bold"><?php echo number_format($sample_stats['documents_processed']); ?></h3>
                                <p class="text-muted mb-0">Documents Processed</p>
                                <div class="metric-trend trend-up">
                                    <i class="bi bi-arrow-up"></i> +245 today
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <div class="stat-icon bg-info mx-auto">
                                    <i class="bi bi-check-square text-white fs-3"></i>
                                </div>
                                <h3 class="text-info fw-bold"><?php echo number_format($sample_stats['compliance_checks']); ?></h3>
                                <p class="text-muted mb-0">Compliance Checks</p>
                                <div class="metric-trend trend-up">
                                    <i class="bi bi-arrow-up"></i> +387 today
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organizations Overview -->
                <div class="row mb-4">
                    <div class="col-lg-8">
                        <div class="card table-custom">
                            <div class="card-header bg-white border-0 pb-0">
                                <h5 class="card-title">
                                    <i class="bi bi-building me-2 text-primary"></i>
                                    Organizations Overview
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Organization</th>
                                                <th>Plan</th>
                                                <th>Users</th>
                                                <th>Documents</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($sample_organizations as $org): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                            <i class="bi bi-building text-white"></i>
                                                        </div>
                                                        <div>
                                                            <strong><?php echo $org['name']; ?></strong>
                                                            <br><small class="text-muted">Since <?php echo date('M Y', strtotime($org['created'])); ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php
                                                    $badge_class = match($org['tier']) {
                                                        'essential' => 'bg-secondary',
                                                        'professional' => 'bg-primary',
                                                        'enterprise' => 'bg-warning text-dark'
                                                    };
                                                    ?>
                                                    <span class="org-badge badge <?php echo $badge_class; ?>">
                                                        <?php echo ucfirst($org['tier']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong><?php echo $org['users']; ?></strong>
                                                    <br><small class="text-muted">users</small>
                                                </td>
                                                <td>
                                                    <strong><?php echo number_format($org['documents']); ?></strong>
                                                    <br><small class="text-muted">docs</small>
                                                </td>
                                                <td>
                                                    <?php
                                                    $status_class = $org['status'] === 'active' ? 'success' : 'warning';
                                                    ?>
                                                    <span class="badge bg-<?php echo $status_class; ?>">
                                                        <?php echo ucfirst($org['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-outline-primary" title="View Details">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        <button class="btn btn-outline-secondary" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-outline-info" title="Reports">
                                                            <i class="bi bi-graph-up"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <!-- Revenue Chart -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-currency-dollar me-2"></i>
                                    Monthly Revenue
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="revenueChart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Stats -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-lightning me-2"></i>
                                    Quick Stats
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Server Uptime</span>
                                    <span class="badge bg-success">99.9%</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Processing Queue</span>
                                    <span class="badge bg-info">23 items</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Storage Used</span>
                                    <span class="badge bg-warning text-dark">67%</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Active Sessions</span>
                                    <span class="badge bg-primary">89</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row">
                    <div class="col-12">
                        <div class="card table-custom">
                            <div class="card-header bg-white border-0 pb-0">
                                <h5 class="card-title">
                                    <i class="bi bi-clock-history me-2 text-primary"></i>
                                    Recent System Activity
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php foreach ($sample_recent_activity as $activity): ?>
                                <div class="activity-item border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle text-muted me-3 fs-4"></i>
                                            <div>
                                                <strong><?php echo $activity['user']; ?></strong>
                                                <span class="text-muted"><?php echo $activity['action']; ?></span>
                                            </div>
                                        </div>
                                        <small class="text-muted"><?php echo $activity['time']; ?></small>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                
                                <div class="text-center mt-3">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-arrow-down me-1"></i>Load More Activity
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <footer class="my-5 pt-5 text-muted text-center text-small">
                    <p class="mb-1">&copy; 2024 Singularity Compliance - System Administration</p>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="#">Privacy</a></li>
                        <li class="list-inline-item"><a href="#">Terms</a></li>
                        <li class="list-inline-item"><a href="#">Support</a></li>
                    </ul>
                </footer>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
    
    <script>
        // Revenue Chart
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Monthly Revenue ($)',
                    data: [1200, 1900, 3000, 5000, 4200, 6300],
                    borderColor: '#4267cd',
                    backgroundColor: 'rgba(66, 103, 205, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: '#f1f1f1'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Smooth hover animations for nav items
        document.querySelectorAll('.admin-nav').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.admin-nav').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>