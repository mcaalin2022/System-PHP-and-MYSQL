<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email exists
    $check = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        // Allow user to create account as requested
        $sql = "INSERT INTO users (name, email, password, role, is_active) VALUES ('$name', '$email', '$password', 'student', 1)";

        if ($conn->query($sql) === TRUE) {
            $success = "Account created successfully! <a href='login-student.php'>Login here</a>";
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sign Up - University Path</title>
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

        .signup-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
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
    <div class="signup-card">
        <h2 class="text-center fw-bold mb-4">Create Account</h2>
        <?php if (isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        } ?>
        <?php if (isset($success)) {
            echo "<div class='alert alert-success'>$success</div>";
        } ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-custom">Sign Up</button>
            </div>
            <div class="text-center">
                <a href="login-student.php" class="text-decoration-none text-muted">Already have an account? Login</a>
            </div>
        </form>
    </div>
</body>

</html>