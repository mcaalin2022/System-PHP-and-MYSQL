<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login-student.php");
    exit();
}
include 'db_connect.php';
$student_name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - University Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background: #2c3e50;
            color: white;
            padding-top: 20px;
            transition: all 0.3s;
        }

        .sidebar a {
            padding: 15px 25px;
            text-decoration: none;
            font-size: 1.1rem;
            color: #bdc3c7;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            color: #fff;
            background: #34495e;
            border-left: 4px solid #3498db;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .card-stat {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .card-stat:hover {
            transform: translateY(-5px);
        }

        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h3 class="text-center fw-bold mb-5">Uni Path</h3>
        <a href="student-dashboard.php" class="active">Dashboard</a>
        <a href="student-profile.php">My Profile</a>
        <a href="university-explorer.php">Explore Universities</a>
        <a href="university-compare.php">Compare Universities</a>
        <a href="faculty-analysis.php">Faculty Analysis</a>
        <a href="application-tracker.php">My Applications</a>
        <a href="index.html" class="mt-5 text-danger">Logout</a>
    </div>

    <div class="main-content">
        <div class="welcome-banner">
            <h1>Welcome back, <?php echo htmlspecialchars($student_name); ?>!</h1>
            <p>Track your progress and explore your future.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-stat p-4 bg-white h-100">
                    <h5 class="text-muted">Profile Completion</h5>
                    <div class="progress mt-3 mb-2" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                    </div>
                    <small>Completing your profile improves faculty recommendations.</small>
                    <a href="student-profile.php" class="btn btn-sm btn-outline-primary mt-3">Update Profile</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-stat p-4 bg-white h-100">
                    <h5 class="text-muted">Recommended Faculties</h5>
                    <h2 class="fw-bold my-2">3</h2>
                    <p class="mb-0">Based on your GPA and subjects.</p>
                    <a href="faculty-analysis.php" class="btn btn-sm btn-outline-info mt-3">View Analysis</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-stat p-4 bg-white h-100">
                    <h5 class="text-muted">University List</h5>
                    <p>Browse through top universities and their programs.</p>
                    <a href="university-explorer.php" class="btn btn-sm btn-outline-warning mt-3">Start Exploring</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>