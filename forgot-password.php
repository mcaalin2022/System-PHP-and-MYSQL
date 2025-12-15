<?php
// Mock functionality for demo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    // In a real app, send email here. For now, redirect to reset page.
    header("Location: reset-password.php?email=" . urlencode($email));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - University Path</title>
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

        .card-custom {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>

<body>
    <div class="card-custom">
        <h3 class="text-center fw-bold mb-3">Recovery</h3>
        <p class="text-center text-muted mb-4">Enter your email to reset your password.</p>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Continue</button>
            </div>
            <div class="text-center mt-3">
                <a href="login-student.php" class="text-decoration-none text-muted">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>