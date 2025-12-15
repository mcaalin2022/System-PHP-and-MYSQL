<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Insecure query as requested (plain text password)
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND role = 'student'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['is_active']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = 'student';
            header("Location: student-dashboard.php");
            exit();
        } else {
            $error = "Your account is deactivated. Please contact admin.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - University Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
        }

        .btn-custom {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
        }

        .btn-custom:hover {
            color: white;
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h2 class="text-center fw-bold mb-4">Student Login</h2>
        <?php if (isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        } ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-custom">Login</button>
            </div>
            <div class="text-center">
                <a href="forgot-password.php" class="text-decoration-none text-muted small">Forgot Password?</a>
                <br>
                <a href="signup-student.php" class="text-decoration-none text-primary small">Create New Account</a>
                <br>
                <a href="index.html" class="text-decoration-none text-muted small">Back to Home</a>
            </div>
        </form>
    </div>
</body>

</html>