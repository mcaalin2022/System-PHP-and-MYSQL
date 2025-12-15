<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login-admin.php");
    exit();
}
include 'db_connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mock saving settings
    $site_name = $_POST['site_name'];
    $admin_email = $_POST['admin_email'];
    $maintenance_mode = isset($_POST['maintenance_mode']) ? 1 : 0;

    // In a real app, save to DB or Config file
    $message = "Settings saved successfully (Mock).";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings - Admin</title>
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

        .card-custom {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }
    </style>
</head>

<body>

    <div class="sidebar d-flex flex-column">
        <div class="p-4 text-center border-bottom border-secondary">
            <h4 class="fw-bold m-0">Admin Portal</h4>
        </div>
        <nav class="nav flex-column mt-4">
            <a class="nav-link" href="admin-dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a class="nav-link" href="admin-users.php"><i class="bi bi-people"></i> User Management</a>
            <a class="nav-link" href="admin-students.php"><i class="bi bi-person-badge"></i> Student Profiles</a>
            <a class="nav-link" href="admin-universities.php"><i class="bi bi-building"></i> Universities</a>
            <a class="nav-link" href="admin-programs.php"><i class="bi bi-journal-text"></i> Programs</a>
            <a class="nav-link active" href="admin-settings.php"><i class="bi bi-gear"></i> Settings</a>
        </nav>
    </div>

    <div class="main-content">
        <h2 class="fw-bold mb-4">System Configuration</h2>

        <?php if ($message)
            echo "<div class='alert alert-success'>$message</div>"; ?>

        <div class="card-custom">
            <form method="POST">
                <h5 class="mb-4 text-muted">General Settings</h5>

                <div class="mb-3">
                    <label class="form-label">System Name</label>
                    <input type="text" class="form-control" name="site_name" value="University Path" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Admin Notification Email</label>
                    <input type="email" class="form-control" name="admin_email" value="admin@system.com" required>
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenance">
                    <label class="form-check-label" for="maintenance">Enable Maintenance Mode</label>
                    <div class="form-text">When enabled, students cannot login.</div>
                </div>

                <button type="submit" class="btn btn-primary px-4">Save Configuration</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>