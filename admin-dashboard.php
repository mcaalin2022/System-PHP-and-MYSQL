<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login-admin.php");
    exit();
}
include 'db_connect.php';

// Fetch quick stats
$students_count = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='student'")->fetch_assoc()['c'];
$universities_count = $conn->query("SELECT COUNT(*) as c FROM universities")->fetch_assoc()['c'];
$applications_count = $conn->query("SELECT COUNT(*) as c FROM applications")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - University Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f1f2f6;
        }

        .sidebar {
            width: 260px;
            background: #2c3e50;
            min-height: 100vh;
            color: white;
            position: fixed;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        .nav-link {
            color: #b2bec3;
            padding: 15px 20px;
            font-size: 1.1em;
        }

        .nav-link:hover,
        .nav-link.active {
            color: white;
            background: #34495e;
            border-left: 5px solid #3498db;
        }

        .nav-link i {
            margin-right: 10px;
        }

        .card-stat {
            border: none;
            border-radius: 15px;
            background: white;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .stat-icon {
            font-size: 2.5em;
            opacity: 0.2;
        }
    </style>
</head>

<body>

    <div class="sidebar d-flex flex-column">
        <div class="p-4 text-center border-bottom border-secondary">
            <h4 class="fw-bold m-0">Admin Portal</h4>
        </div>
        <nav class="nav flex-column mt-4">
            <a class="nav-link active" href="admin-dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a class="nav-link" href="admin-users.php"><i class="bi bi-people"></i> User Management</a>
            <a class="nav-link" href="admin-students.php"><i class="bi bi-person-badge"></i> Student Profiles</a>
            <a class="nav-link" href="admin-universities.php"><i class="bi bi-building"></i> Universities</a>
            <a class="nav-link" href="admin-programs.php"><i class="bi bi-journal-text"></i> Programs</a>
            <a class="nav-link" href="index.html" class="mt-auto text-danger"><i class="bi bi-box-arrow-right"></i>
                Logout</a>
        </nav>
    </div>

    <div class="main-content">
        <h2 class="fw-bold mb-4">Dashboard Overview</h2>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card-stat d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-2">Total Students</h6>
                        <h2 class="fw-bold m-0"><?php echo $students_count; ?></h2>
                    </div>
                    <i class="bi bi-people-fill stat-icon text-primary"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-stat d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-2">Universities</h6>
                        <h2 class="fw-bold m-0"><?php echo $universities_count; ?></h2>
                    </div>
                    <i class="bi bi-building stat-icon text-success"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-stat d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-2">Total Applications</h6>
                        <h2 class="fw-bold m-0"><?php echo $applications_count; ?></h2>
                    </div>
                    <i class="bi bi-file-earmark-text-fill stat-icon text-warning"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-3">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="admin-users.php" class="btn btn-outline-primary text-start"><i
                                class="bi bi-person-plus"></i> Add New User</a>
                        <a href="admin-universities.php" class="btn btn-outline-secondary text-start"><i
                                class="bi bi-plus-lg"></i> Add University</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>