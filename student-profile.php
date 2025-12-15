<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login-student.php");
    exit();
}
include 'db_connect.php';

$user_id = $_SESSION['user_id'];
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gpa = $_POST['gpa'];
    $class_range = $_POST['class_range'];

    $sub1 = $_POST['subject1'];
    $sub2 = $_POST['subject2'];
    $sub3 = $_POST['subject3'];

    // Update Profile
    $sql_profile = "INSERT INTO student_profiles (user_id, phone, address, gpa, class_range) 
                    VALUES ('$user_id', '$phone', '$address', '$gpa', '$class_range')
                    ON DUPLICATE KEY UPDATE phone='$phone', address='$address', gpa='$gpa', class_range='$class_range'";

    // Update Subjects
    $sql_subjects = "INSERT INTO student_subjects (user_id, subject1, subject2, subject3) 
                     VALUES ('$user_id', '$sub1', '$sub2', '$sub3')
                     ON DUPLICATE KEY UPDATE subject1='$sub1', subject2='$sub2', subject3='$sub3'";

    if ($conn->query($sql_profile) === TRUE && $conn->query($sql_subjects) === TRUE) {
        $message = "Profile updated successfully!";
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}

// Fetch current data
$sql_data = "SELECT u.name, u.email, sp.*, ss.subject1, ss.subject2, ss.subject3 
             FROM users u 
             LEFT JOIN student_profiles sp ON u.id = sp.user_id 
             LEFT JOIN student_subjects ss ON u.id = ss.user_id 
             WHERE u.id = '$user_id'";
$result = $conn->query($sql_data);
$data = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - University Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Requested Dark Mode style for profile view logic */
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #212529;
            /* Dark background */
            color: #f8f9fa;
        }

        .main-container {
            padding: 50px 0;
        }

        .profile-card {
            background: #2c3e50;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .form-control,
        .form-select {
            background-color: #34495e;
            border: 1px solid #4b6584;
            color: white;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #34495e;
            color: white;
            box-shadow: none;
            border-color: #3498db;
        }

        .btn-update {
            background: #3498db;
            color: white;
            padding: 10px 30px;
            border-radius: 50px;
            border: none;
            font-weight: 600;
        }

        .btn-update:hover {
            background: #2980b9;
        }

        .sidebar-link {
            color: #bdc3c7;
            text-decoration: none;
            margin-right: 20px;
        }

        .sidebar-link:hover {
            color: white;
        }
    </style>
</head>

<body>
    <div class="container main-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">My Profile</h2>
            <a href="student-dashboard.php" class="btn btn-outline-light rounded-pill">Back to Dashboard</a>
        </div>

        <div class="profile-card">
            <?php if ($message)
                echo "<div class='alert alert-info'>$message</div>"; ?>

            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Full Name</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['name']); ?>"
                            disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Email</label>
                        <input type="email" class="form-control" value="<?php echo htmlspecialchars($data['email']); ?>"
                            disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone"
                            value="<?php echo htmlspecialchars($data['phone'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address"
                            value="<?php echo htmlspecialchars($data['address'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">GPA (e.g., 3.5)</label>
                        <input type="number" step="0.01" class="form-control" name="gpa"
                            value="<?php echo htmlspecialchars($data['gpa'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Class Range/Rank</label>
                        <select class="form-select" name="class_range">
                            <option value="Top 10%" <?php if (($data['class_range'] ?? '') == 'Top 10%')
                                echo 'selected'; ?>>Top 10%</option>
                            <option value="Top 25%" <?php if (($data['class_range'] ?? '') == 'Top 25%')
                                echo 'selected'; ?>>Top 25%</option>
                            <option value="Top 50%" <?php if (($data['class_range'] ?? '') == 'Top 50%')
                                echo 'selected'; ?>>Top 50%</option>
                            <option value="Other" <?php if (($data['class_range'] ?? '') == 'Other')
                                echo 'selected'; ?>>
                                Other</option>
                        </select>
                    </div>
                </div>

                <h4 class="mt-4 mb-3 border-bottom border-secondary pb-2">Academic Interests</h4>
                <p class="text-muted small">Select your top 3 preferred subjects or majors.</p>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">First Choice</label>
                        <input type="text" class="form-control" name="subject1" placeholder="e.g. Computer Science"
                            value="<?php echo htmlspecialchars($data['subject1'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Second Choice</label>
                        <input type="text" class="form-control" name="subject2" placeholder="e.g. Engineering"
                            value="<?php echo htmlspecialchars($data['subject2'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Third Choice</label>
                        <input type="text" class="form-control" name="subject3" placeholder="e.g. Mathematics"
                            value="<?php echo htmlspecialchars($data['subject3'] ?? ''); ?>">
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-update">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>