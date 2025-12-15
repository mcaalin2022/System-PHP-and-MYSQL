<?php
session_start();
include 'db_connect.php';

// Handle Login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Requesting dropdown value

    // Check credentials
    // Note: Plain text password check as requested previously
    $stmt = $conn->prepare("SELECT id, name, role, is_active FROM users WHERE email = ? AND password = ? AND role = ?");
    $stmt->bind_param("sss", $email, $password, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['is_active']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: admin-dashboard.php");
            } else {
                header("Location: student-dashboard.php");
            }
            exit();
        } else {
            $error = "Account is deactivated. Contact support.";
        }
    } else {
        $error = "Invalid credentials or role selected.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - University Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            height: 100vh;
            overflow: hidden;
            /* Prevent scroll if possible */
        }

        .login-container {
            height: 100vh;
            width: 100%;
        }

        .left-panel {
            background: url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=2560&auto=format&fit=crop') no-repeat center center;
            background-size: cover;
            position: relative;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            /* Dark overlay */
        }

        .left-panel-content {
            position: relative;
            z-index: 2;
            max-width: 500px;
        }

        .right-panel {
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-form-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #34495e;
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #dfe6e9;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            border-color: #3498db;
        }

        .btn-login {
            background-color: #1877f2;
            /* Blue like image */
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-login:hover {
            background-color: #1565c0;
        }

        .forgot-link {
            text-decoration: none;
            color: #1877f2;
            font-size: 0.9rem;
            float: right;
        }
    </style>
</head>

<body>
    <div class="row m-0 login-container">
        <!-- Left Side: Image -->
        <div class="col-lg-6 d-none d-lg-flex left-panel">
            <div class="left-panel-content">
                <h1 class="display-3 fw-bold mb-3">Shape Your Future</h1>
                <p class="lead fs-4 opacity-75">Discover your path and unlock your potential with our comprehensive
                    learning platform.</p>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="col-lg-6 right-panel">
            <div class="login-form-wrapper">
                <h3 class="fw-bold mb-2">Student & Admin Login</h3>
                <p class="text-muted mb-4">Welcome back. Please log in to your account.</p>

                <?php if (isset($error))
                    echo "<div class='alert alert-danger py-2'>$error</div>"; ?>

                <form method="POST">
                    <!-- Added Dropdown as requested -->
                    <div class="mb-3">
                        <label class="form-label">Select Role</label>
                        <select class="form-select p-2" name="role" required>
                            <option value="student">Student</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username or Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your username or email"
                            required>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label mb-0">Password</label>
                            <a href="forgot-password.php" class="forgot-link">Forgot Password?</a>
                        </div>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password"
                            required>
                    </div>

                    <button type="submit" class="btn btn-login">Login</button>

                    <div class="text-center mt-4">
                        <span class="text-muted">New student? </span>
                        <a href="registration-student.php" class="text-decoration-none fw-bold"
                            style="color: #1877f2;">Create an account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>