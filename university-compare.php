<?php
session_start();
include 'db_connect.php';

$ids = $_GET['ids'] ?? [];
if (count($ids) < 2) {
    echo "<div class='alert alert-warning m-5'>Please select at least two universities to compare. <a href='university-explorer.php'>Go back</a></div>";
    exit();
}

// Sanitize IDs
$ids_sanitized = array_map('intval', $ids);
$ids_string = implode(',', $ids_sanitized);

$sql = "SELECT * FROM universities WHERE id IN ($ids_string)";
$result = $conn->query($sql);
$universities = [];
while ($row = $result->fetch_assoc()) {
    $universities[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Universities - University Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8f9fa;
        }

        .table-custom th {
            background-color: #2c3e50;
            color: white;
        }

        .table-custom td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold">University Comparison</h2>
            <a href="university-explorer.php" class="btn btn-outline-secondary rounded-pill">Back to List</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-custom shadow-sm bg-white">
                <thead>
                    <tr>
                        <th style="width: 20%;">Feature</th>
                        <?php foreach ($universities as $uni): ?>
                            <th class="text-center"><?php echo htmlspecialchars($uni['name']); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold">Location</td>
                        <?php foreach ($universities as $uni): ?>
                            <td class="text-center"><?php echo htmlspecialchars($uni['location']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="fw-bold">Ranking</td>
                        <?php foreach ($universities as $uni): ?>
                            <td class="text-center"><span class="badge bg-primary">#<?php echo $uni['ranking']; ?></span>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="fw-bold">Description</td>
                        <?php foreach ($universities as $uni): ?>
                            <td class="small text-muted"><?php echo htmlspecialchars($uni['description']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="fw-bold">Action</td>
                        <?php foreach ($universities as $uni): ?>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-success">Apply Now</button>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>