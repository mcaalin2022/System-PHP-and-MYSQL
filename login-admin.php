<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Insecure query as requested
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND role = 'admin'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = 'admin';
        header("Location: admin-dashboard.php");
        exit();
    } else {
        $error = "Invalid admin credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - University Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);
            /* Darker theme for admin */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
        }

        .btn-custom {
            background: linear-gradient(45deg, #2c3e50, #4ca1af);
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
        <h2 class="text-center fw-bold mb-4 text-dark">Admin Portal</h2>
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
                <button type="submit" class="btn btn-custom">Login to Dashboard</button>
            </div>
            <div class="text-center">
                <a href="index.html" class="text-decoration-none text-muted small">Back to Home</a>
            </div>
        </form>
    </div>
</body>

</html>