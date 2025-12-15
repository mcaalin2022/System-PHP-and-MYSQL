<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login-admin.php");
    exit();
}
include 'db_connect.php';

// Fetch Students with Profile Data
$sql = "SELECT u.id, u.name, u.email, sp.phone, sp.gpa, sp.class_range, 
               ss.subject1, ss.subject2, ss.subject3 
        FROM users u 
        LEFT JOIN student_profiles sp ON u.id = sp.user_id 
        LEFT JOIN student_subjects ss ON u.id = ss.user_id 
        WHERE u.role = 'student' 
        ORDER BY u.id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profiles - Admin</title>
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

        .table-custom {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
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
            <a class="nav-link active" href="admin-students.php"><i class="bi bi-person-badge"></i> Student Profiles</a>
            <a class="nav-link" href="admin-universities.php"><i class="bi bi-building"></i> Universities</a>
            <a class="nav-link" href="admin-programs.php"><i class="bi bi-journal-text"></i> Programs</a>
        </nav>
    </div>

    <div class="main-content">
        <h2 class="fw-bold mb-4">Student Profiles</h2>

        <div class="card border-0 shadow-sm p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>GPA</th>
                            <th>Class Range</th>
                            <th>Selected Subjects</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone'] ?? 'N/A'); ?></td>
                                <td><span
                                        class="badge bg-info text-dark"><?php echo htmlspecialchars($row['gpa'] ?? '-'); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($row['class_range'] ?? '-'); ?></td>
                                <td>
                                    <?php if ($row['subject1']): ?>
                                        <small class="d-block">&bull; <?php echo htmlspecialchars($row['subject1']); ?></small>
                                    <?php endif; ?>
                                    <?php if ($row['subject2']): ?>
                                        <small class="d-block">&bull; <?php echo htmlspecialchars($row['subject2']); ?></small>
                                    <?php endif; ?>
                                    <?php if ($row['subject3']): ?>
                                        <small class="d-block">&bull; <?php echo htmlspecialchars($row['subject3']); ?></small>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>