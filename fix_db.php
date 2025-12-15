<?php
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixing Database...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Auto-redirect after 3 seconds
        setTimeout(function () {
            window.location.href = 'registration-student.php';
        }, 3000);
    </script>
</head>

<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="card p-5 shadow text-center">
        <h3 class="mb-4">Database Repair Tool</h3>
        <?php
        $table = "student_profiles";
        $column = "age";

        // Check 1: student_profiles table existence
        $checkTable = $conn->query("SHOW TABLES LIKE '$table'");
        if ($checkTable->num_rows == 0) {
            echo "<div class='alert alert-danger'>Table '$table' does not exist! Please re-import database.sql.</div>";
        } else {
            // Check 2: Column existence
            $checkCol = $conn->query("SHOW COLUMNS FROM $table LIKE '$column'");
            if ($checkCol->num_rows == 0) {
                // Add column
                $sql = "ALTER TABLE $table ADD COLUMN $column INT AFTER address";
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success'><strong>Success!</strong> Added 'age' column to database.</div>";
                    echo "<p>Redirecting you back to registration...</p>";
                } else {
                    echo "<div class='alert alert-danger'>Error adding column: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-info'>Column 'age' already exists. Database is up to date.</div>";
                echo "<p>Redirecting you back...</p>";
            }
        }
        ?>
        <div class="mt-3">
            <a href="registration-student.php" class="btn btn-primary">Return to Registration</a>
        </div>
    </div>
</body>

</html>