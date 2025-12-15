<?php
include 'db_connect.php';

$email = isset($_GET['email']) ? $_GET['email'] : '';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    // Insecure update as requested
    $sql = "UPDATE users SET password = '$new_password' WHERE email = '$email'";
    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-success'>Password updated! <a href='login-student.php'>Login now</a></div>";
    } else {
        $msg = "<div class='alert alert-danger'>Error updating password.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - University Path</title>
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
        <h3 class="text-center fw-bold mb-3">Reset Password</h3>
        <?php echo $msg; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Confirm Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success">Save New Password</button>
            </div>
        </form>
    </div>
</body>

</html>