<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login-student.php");
    exit();
}
include 'db_connect.php';
$user_id = $_SESSION['user_id'];

// Handle new application simulation
if (isset($_POST['apply_program_id'])) {
    $prog_id = $_POST['apply_program_id'];
    $sql_apply = "INSERT INTO applications (student_id, program_id, status) VALUES ('$user_id', '$prog_id', 'pending')";
    $conn->query($sql_apply);
}

// Fetch applications
$sql = "SELECT a.*, p.name as program_name, u.name as uni_name 
        FROM applications a 
        JOIN programs p ON a.program_id = p.id 
        JOIN universities u ON p.university_id = u.id 
        WHERE a.student_id = '$user_id' 
        ORDER BY a.applied_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications - University Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8f9fa;
        }

        .app-card {
            background: white;
            border-radius: 15px;
            border-left: 5px solid #bdc3c7;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .app-card:hover {
            transform: translateX(5px);
        }

        .status-pending {
            border-left-color: #f1c40f;
        }

        .status-accepted {
            border-left-color: #2ecc71;
        }

        .status-rejected {
            border-left-color: #e74c3c;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold">My Applications</h2>
            <a href="student-dashboard.php" class="btn btn-outline-secondary rounded-pill">Back to Dashboard</a>
        </div>

        <?php if ($result->num_rows == 0): ?>
            <div class="text-center py-5">
                <h4 class="text-muted">No applications yet.</h4>
                <p>Explore universities and start applying!</p>
                <a href="university-explorer.php" class="btn btn-primary rounded-pill">Explore Universities</a>

                <!-- Demo purposes: Quick Apply -->
                <form method="POST" class="mt-4">
                    <input type="hidden" name="apply_program_id" value="1">
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Demo: Apply to Program #1</button>
                </form>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php while ($row = $result->fetch_assoc()):
                    $status_class = 'status-' . strtolower($row['status']);
                    $badge_class = match ($row['status']) {
                        'accepted' => 'bg-success',
                        'rejected' => 'bg-danger',
                        default => 'bg-warning text-dark'
                    };
                    ?>
                    <div class="col-md-12">
                        <div class="card app-card <?php echo $status_class; ?> p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($row['program_name']); ?></h5>
                                    <p class="text-muted mb-0"><?php echo htmlspecialchars($row['uni_name']); ?></p>
                                    <small class="text-muted">Applied on:
                                        <?php echo date('M d, Y', strtotime($row['applied_at'])); ?></small>
                                </div>
                                <div>
                                    <span
                                        class="badge <?php echo $badge_class; ?> rounded-pill px-3 py-2"><?php echo ucfirst($row['status']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>