<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Path - Student Management System</title>
    <!-- Using Bootstrap 5 as requested -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .hero-section {
            padding: 100px 0;
            text-align: center;
        }

        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .card-custom:hover {
            transform: translateY(-10px);
        }

        .btn-primary-custom {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
        }

        .btn-outline-custom {
            border: 2px solid #764ba2;
            color: #764ba2;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
        }

        .btn-outline-custom:hover {
            background: #764ba2;
            color: white;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">University Path</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="login-student.php">Student Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="login-admin.php">Admin Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container hero-section">
        <h1 class="display-4 fw-bold mb-4">Plan Your Academic Future</h1>
        <p class="lead mb-5 text-muted">Compare universities, manage your profile, and receive faculty advice all in one
            place.</p>

        <div class="row justify-content-center g-4">
            <div class="col-md-5">
                <div class="card card-custom p-5">
                    <h3>For Students</h3>
                    <p class="mb-4">Access your dashboard, update your profile, and explore universities.</p>
                    <div class="d-grid gap-2">
                        <a href="login-student.php" class="btn btn-primary-custom text-white">Login</a>
                        <a href="signup-student.php" class="btn btn-outline-custom">Create Account</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card card-custom p-5">
                    <h3>For Administrators</h3>
                    <p class="mb-4">Manage users, universities, and system settings efficiently.</p>
                    <div class="d-grid gap-2">
                        <a href="login-admin.php" class="btn btn-secondary rounded-pill py-2">Admin Portal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.css"></script>
</body>

</html>