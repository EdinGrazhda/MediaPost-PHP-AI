<?php
// Start session if not already started
session_start();

// Include database connection
include_once('../db_connection/index.php');

// Advanced security check
// 1. Check if session exists
// 2. Verify user exists in database
// 3. Generate a 404 error if not authenticated

$authenticated = false;

if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
    $name = $_SESSION['name'];
    
    // Verify user exists in database
    $stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $authenticated = true;
    }
}

// If not authenticated, show custom 404 error
if (!$authenticated) {
    // Redirect to our custom 404 page
    header("HTTP/1.0 404 Not Found");
    include_once('404.php');
    exit();
}

// User is authenticated, continue with the page
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediaSociale - Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background: #1877f2;
            color: #fff;
            transition: all 0.3s;
        }
        
        .sidebar .sidebar-header {
            padding: 20px;
            background: #1155aa;
        }
        
        .sidebar ul.components {
            padding: 20px 0;
        }
        
        .sidebar ul li a {
            padding: 10px 20px;
            font-size: 1.1em;
            display: block;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar ul li a:hover {
            background: #0d6efd;
        }
        
        .sidebar ul li.active > a {
            background: #0d6efd;
        }
        
        .sidebar .user-info {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 15px;
        }
        
        .sidebar .user-info img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
        }
        
        .content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        /* For mobile responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
                position: fixed;
                z-index: 999;
                height: 100%;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            #sidebarCollapse {
                display: block;
            }
        }
        
        .navbar {
            padding: 15px 10px;
            background: #fff;
            border: none;
            border-radius: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h3>MediaSociale</h3>
            </div>
            
            <div class="user-info">
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($name); ?>&background=random" alt="Profile Image">
                    <div class="ms-3">
                        <h5 class="mb-0"><?php echo htmlspecialchars($name); ?></h5>
                        <p class="mb-0 small"><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                </div>
            </div>
            
            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#"><i class="bi bi-house-door me-2"></i> Dashboard</a>
                </li>
                <li>
                    <a href="#"><i class="bi bi-person me-2"></i> Profile</a>
                </li>
                <li>
                    <a href="#"><i class="bi bi-chat-left-text me-2"></i> Messages</a>
                </li>
                <li>
                    <a href="#"><i class="bi bi-people me-2"></i> Friends</a>
                </li>
                <li>
                    <a href="#"><i class="bi bi-gear me-2"></i> Settings</a>
                </li>
                <li>
                    <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sign Out</a>
                </li>
            </ul>
        </nav>
        
        <!-- Page Content -->
        <div class="content">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary d-md-none">
                        <i class="bi bi-list"></i>
                    </button>
                    
                    <div class="d-flex ms-auto">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell"></i>
                                <span class="badge bg-danger rounded-pill">3</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">New friend request</a></li>
                                <li><a class="dropdown-item" href="#">New message</a></li>
                                <li><a class="dropdown-item" href="#">Event reminder</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            
            <div class="container-fluid">
                <h2 class="mb-4">Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Recent Activity</span>
                                <button class="btn btn-sm btn-outline-primary">View All</button>
                            </div>
                            <div class="card-body">
                                <p>Your recent activity will appear here.</p>
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i> This is a sample dashboard. Customize it according to your needs.
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <span>Your Information</span>
                            </div>
                            <div class="card-body">
                                <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                                <p><strong>Member Since:</strong> <?php echo date("F Y"); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar on mobile
            document.getElementById('sidebarCollapse').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('active');
            });
        });
    </script>
</body>
</html>