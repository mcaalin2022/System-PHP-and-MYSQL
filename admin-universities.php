<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login-admin.php");
    exit();
}
include 'db_connect.php';

$message = "";

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM universities WHERE id=$id");
    $message = "University deleted successfully.";
}

// Handle Add/Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $ranking = $_POST['ranking'];
    $website = $_POST['website'];
    $description = $_POST['description'];

    if (isset($_POST['uni_id']) && !empty($_POST['uni_id'])) {
        $id = $_POST['uni_id'];
        $sql = "UPDATE universities SET name='$name', location='$location', ranking='$ranking', website='$website', description='$description' WHERE id='$id'";
    } else {
        $sql = "INSERT INTO universities (name, location, ranking, website, description) VALUES ('$name', '$location', '$ranking', '$website', '$description')";
    }

    if ($conn->query($sql) === TRUE) {
        $message = "University saved successfully.";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM universities ORDER BY ranking ASC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Universities - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f1f2f6;
        }

        .sidebar {
            width: 260px;
            background: #2c3e50;
            min-height: 100vh;
            color: white;
            position: fixed;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        .nav-link {
            color: #b2bec3;
            padding: 15px 20px;
            font-size: 1.1em;
        }

        .nav-link:hover,
        .nav-link.active {
            color: white;
            background: #34495e;
            border-left: 5px solid #3498db;
        }

        .table-custom {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    <div class="sidebar d-flex flex-column">
        <div class="p-4 text-center border-bottom border-secondary">
            <h4 class="fw-bold m-0">Admin Portal</h4>
        </div>
        <nav class="nav flex-column mt-4">
            <a class="nav-link" href="admin-dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a class="nav-link" href="admin-users.php"><i class="bi bi-people"></i> User Management</a>
            <a class="nav-link" href="admin-students.php"><i class="bi bi-person-badge"></i> Student Profiles</a>
            <a class="nav-link active" href="admin-universities.php"><i class="bi bi-building"></i> Universities</a>
            <a class="nav-link" href="admin-programs.php"><i class="bi bi-journal-text"></i> Programs</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">University Database</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uniModal" onclick="clearForm()">
                <i class="bi bi-plus-lg"></i> Add University
            </button>
        </div>

        <?php if ($message)
            echo "<div class='alert alert-info'>$message</div>"; ?>

        <div class="card border-0 shadow-sm p-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Website</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $row['ranking']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td><a href="//<?php echo htmlspecialchars($row['website']); ?>" target="_blank"
                                    class="text-decoration-none">Visit</a></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2"
                                    onclick='editUni(<?php echo json_encode($row); ?>)'>
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="uniModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add University</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="uni_id" id="uniId">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">University Name</label>
                                <input type="text" class="form-control" name="name" id="uniName" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Ranking</label>
                                <input type="number" class="form-control" name="ranking" id="uniRanking">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" name="location" id="uniLocation" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Website</label>
                            <input type="text" class="form-control" name="website" id="uniWebsite">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="uniDesc" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editUni(uni) {
            document.getElementById('modalTitle').innerText = 'Edit University';
            document.getElementById('uniId').value = uni.id;
            document.getElementById('uniName').value = uni.name;
            document.getElementById('uniRanking').value = uni.ranking;
            document.getElementById('uniLocation').value = uni.location;
            document.getElementById('uniWebsite').value = uni.website;
            document.getElementById('uniDesc').value = uni.description;
            new bootstrap.Modal(document.getElementById('uniModal')).show();
        }

        function clearForm() {
            document.getElementById('modalTitle').innerText = 'Add University';
            document.getElementById('uniId').value = '';
            document.getElementById('uniName').value = '';
            document.getElementById('uniRanking').value = '';
            document.getElementById('uniLocation').value = '';
            document.getElementById('uniWebsite').value = '';
            document.getElementById('uniDesc').value = '';
        }
    </script>
</body>

</html>