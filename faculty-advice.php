<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login-student.php");
    exit();
}
include 'db_connect.php';

$user_id = $_SESSION['user_id'];

// Get user profile
$sql_profile = "SELECT * FROM student_profiles WHERE user_id = '$user_id'";
$result_profile = $conn->query($sql_profile);
$profile = $result_profile->fetch_assoc();

$recommendations = [];
if ($profile && isset($profile['gpa'])) {
    $gpa = $profile['gpa'];

    // Simple logic for recommendations
    if ($gpa >= 3.5) {
        $recommendations[] = [
            'faculty' => 'Medicine',
            'advice' => 'Your GPA is excellent! You are a strong candidate for Medical programs.',
            'badge' => 'Highly Recommended'
        ];
        $recommendations[] = [
            'faculty' => 'Engineering',
            'advice' => 'You meet the high standards required for top Engineering schools.',
            'badge' => 'Recommended'
        ];
    } elseif ($gpa >= 3.0) {
        $recommendations[] = [
            'faculty' => 'Computer Science',
            'advice' => 'Your GPA is good. You have a solid chance at Computer Science programs.',
            'badge' => 'Recommended'
        ];
        $recommendations[] = [
            'faculty' => 'Business Administration',
            'advice' => 'You are well-positioned for Business schools.',
            'badge' => 'Good Fit'
        ];
    } else {
        $recommendations[] = [
            'faculty' => 'Arts & Humanities',
            'advice' => 'Consider exploring Arts programs where your portfolio might matter more than GPA.',
            'badge' => 'Explore'
        ];
        $recommendations[] = [
            'faculty' => 'Vocational Studies',
            'advice' => 'Practical vocational courses could be a great path for career success.',
            'badge' => 'Explore'
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Advice - University Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8f9fa;
        }

        .advice-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            transition: transform 0.2s;
        }

        .advice-card:hover {
            transform: translateY(-5px);
        }

        .badge-custom {
            background-color: #e3f2fd;
            color: #1565c0;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold">Faculty Recommendations</h2>
                <p class="text-muted">Personalized advice based on your academic profile.</p>
            </div>
            <a href="student-dashboard.php" class="btn btn-outline-secondary rounded-pill">Back to Dashboard</a>
        </div>

        <?php if (empty($recommendations)): ?>
            <div class="alert alert-warning">
                Please <a href="student-profile.php">complete your profile</a> (especially GPA) to receive recommendations.
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($recommendations as $rec): ?>
                    <div class="col-md-6">
                        <div class="card advice-card h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h4 class="fw-bold text-primary"><?php echo $rec['faculty']; ?></h4>
                                    <span class="badge-custom"><?php echo $rec['badge']; ?></span>
                                </div>
                                <p class="card-text text-muted"><?php echo $rec['advice']; ?></p>
                                <a href="faculty-analysis.php?faculty=<?php echo urlencode($rec['faculty']); ?>"
                                    class="btn btn-sm btn-link text-decoration-none px-0">View Detailed Analysis &rarr;</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>