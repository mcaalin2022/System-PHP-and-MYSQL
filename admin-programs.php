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
    $conn->query("DELETE FROM programs WHERE id=$id");
    $message = "Program deleted successfully.";
}

// Handle Add/Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $university_id = $_POST['university_id'];
    $name = $_POST['name'];
    $faculty = $_POST['faculty'];
    $gpa_requirement = $_POST['gpa_requirement'];
    $description = $_POST['description'];

    if (isset($_POST['prog_id']) && !empty($_POST['prog_id'])) {
        $id = $_POST['prog_id'];
        $sql = "UPDATE programs SET university_id='$university_id', name='$name', faculty='$faculty', gpa_requirement='$gpa_requirement', description='$description' WHERE id='$id'";
    } else {
        $sql = "INSERT INTO programs (university_id, name, faculty, gpa_requirement, description) VALUES ('$university_id', '$name', '$faculty', '$gpa_requirement', '$description')";
    }

    if ($conn->query($sql) === TRUE) {
        $message = "Program saved successfully.";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$result = $conn->query("SELECT p.*, u.name as uni_name FROM programs p LEFT JOIN universities u ON p.university_id = u.id ORDER BY u.name ASC");
$universities = $conn->query("SELECT id, name FROM universities");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Programs - Admin</title>
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
            <a class="nav-link" href="admin-universities.php"><i class="bi bi-building"></i> Universities</a>
            <a class="nav-link active" href="admin-programs.php"><i class="bi bi-journal-text"></i> Programs</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Program Management</h2>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#progModal" onclick="clearForm()">
                <i class="bi bi-plus-lg"></i> Add New Program
            </button>
        </div>

        <?php if ($message)
            echo "<div class='alert alert-info'>$message</div>"; ?>

        <div class="card border-0 shadow-sm p-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>University</th>
                        <th>Program Name</th>
                        <th>Faculty</th>
                        <th>Min GPA</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['uni_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['faculty']); ?></td>
                            <td><span class="badge bg-secondary"><?php echo $row['gpa_requirement']; ?></span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2"
                                    onclick='editProg(<?php echo json_encode($row); ?>)'>
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
    <div class="modal fade" id="progModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="prog_id" id="progId">
                        <div class="mb-3">
                            <label class="form-label">University</label>
                            <select class="form-select" name="university_id" id="progUni" required>
                                <?php
                                $universities->data_seek(0);
                                while ($u = $universities->fetch_assoc()): ?>
                                    <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Program Name</label>
                            <input type="text" class="form-control" name="name" id="progName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Faculty/Department</label>
                            <input type="text" class="form-control" name="faculty" id="progFaculty">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Min GPA Requirement</label>
                            <input type="number" step="0.01" class="form-control" name="gpa_requirement" id="progGpa">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="progDesc" rows="2"></textarea>
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
        function editProg(prog) {
            document.getElementById('modalTitle').innerText = 'Edit Program';
            document.getElementById('progId').value = prog.id;
            document.getElementById('progUni').value = prog.university_id;
            document.getElementById('progName').value = prog.name;
            document.getElementById('progFaculty').value = prog.faculty;
            document.getElementById('progGpa').value = prog.gpa_requirement;
            document.getElementById('progDesc').value = prog.description;
            new bootstrap.Modal(document.getElementById('progModal')).show();
        }

        function clearForm() {
            document.getElementById('modalTitle').innerText = 'Add Program';
            document.getElementById('progId').value = '';
            document.getElementById('progName').value = '';
            document.getElementById('progFaculty').value = '';
            document.getElementById('progGpa').value = '';
            document.getElementById('progDesc').value = '';
        }
    </script>
</body>

</html>