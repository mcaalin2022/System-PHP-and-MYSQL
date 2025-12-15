<?php
include 'db_connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect User Data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Plain text as requested

    // Collect Profile Data
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $gpa = $_POST['gpa'];
    $class_range = $_POST['class_range']; // Hidden or derived in this flow? User didn't ask, but I'll make it optional or derived. Let's make it input for now.

    // Collect Subjects
    $sub1 = $_POST['subject1'];
    $sub2 = $_POST['subject2'];
    $sub3 = $_POST['subject3'];

    // 1. Create User
    // Check if email exists
    $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        $message = "<div class='alert alert-danger'>Email already registered!</div>";
    } else {
        $conn->begin_transaction();
        try {
            // Insert User
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'student')");
            $stmt->bind_param("sss", $name, $email, $password);
            $stmt->execute();
            $user_id = $conn->insert_id;

            // Insert Profile (including Age)
            $stmt = $conn->prepare("INSERT INTO student_profiles (user_id, phone, address, age, gpa, class_range) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssds", $user_id, $phone, $address, $age, $gpa, $class_range);
            $stmt->execute();

            // Insert Subjects
            $stmt = $conn->prepare("INSERT INTO student_subjects (user_id, subject1, subject2, subject3) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $user_id, $sub1, $sub2, $sub3);
            $stmt->execute();

            $conn->commit();
            $message = "<div class='alert alert-success'>Registration successful! <a href='login-student.php'>Login Here</a></div>";
        } catch (Exception $e) {
            $conn->rollback();
            $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - University Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 50px 0;
        }

        .reg-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .section-title {
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="reg-card">
                    <h2 class="text-center fw-bold mb-4">Student Registration</h2>
                    <p class="text-center text-muted mb-5">Join us to explore your future academic path.</p>

                    <!-- <div class="alert alert-warning text-center">
                        <small>If you see a database error, <a href="fix_db.php" class="fw-bold">click here to update
                                the database</a>.</small>
                    </div> -->

                    <?php echo $message; ?>

                    <form method="POST" action="">
                        <!-- Account Details -->
                        <h6 class="section-title">Account Information</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <!-- Personal Details -->
                        <h6 class="section-title">Personal Details</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" name="phone" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Age</label>
                                <input type="number" class="form-control" name="age" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">GPA</label>
                                <input type="number" step="0.01" class="form-control" name="gpa" placeholder="e.g. 3.5"
                                    required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="2" required></textarea>
                        </div>

                        <!-- Academic Info -->
                        <h6 class="section-title">Academic Preferences</h6>
                        <p class="small text-muted mb-3">Select 3 subjects you are interested in for faculty advice.</p>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <input type="text" class="form-control mb-2" name="subject1" placeholder="Subject 1"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control mb-2" name="subject2" placeholder="Subject 2"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control mb-2" name="subject3" placeholder="Subject 3"
                                    required>
                            </div>
                        </div>

                        <!-- Hidden field for class_range default -->
                        <input type="hidden" name="class_range" value="New Student">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">Register Account</button>
                            <a href="login-student.php" class="btn btn-outline-secondary rounded-pill">Cancel /
                                Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>