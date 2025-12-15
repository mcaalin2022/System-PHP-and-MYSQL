<?php
session_start();
include 'db_connect.php';

// Mock data if database is empty
$mock_universities = [
    // [1, 'Harvard University', 'Cambridge, MA', 'Ivy League research university.', 1, 'www.harvard.edu'],
    // [2, 'MIT', 'Cambridge, MA', 'World-class technology and science.', 2, 'www.mit.edu'],
    // [3, 'Stanford University', 'Stanford, CA', 'Leading research university.', 3, 'www.stanford.edu'],
    // [4, 'University of Oxford', 'Oxford, UK', 'Oldest university in the English-speaking world.', 4, 'www.ox.ac.uk']
];

// Check if tables have data
$result = $conn->query("SELECT * FROM universities");
$universities = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $universities[] = $row;
    }
} else {
    // Populate with mock data for display if empty
    foreach ($mock_universities as $u) {
        $conn->query("INSERT INTO universities (id, name, location, description, ranking, website) VALUES ('$u[0]', '$u[1]', '$u[2]', '$u[3]', '$u[4]', '$u[5]') ON DUPLICATE KEY UPDATE id=id");
        $universities[] = ['id' => $u[0], 'name' => $u[1], 'location' => $u[2], 'description' => $u[3], 'ranking' => $u[4], 'website' => $u[5]];
    }
}

// Simple Filter Logic
$search = $_GET['search'] ?? '';
if ($search) {
    $universities = array_filter($universities, function ($u) use ($search) {
        return stripos($u['name'], $search) !== false || stripos($u['location'], $search) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Explorer - University Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8f9fa;
        }

        .uni-card {
            border: none;
            border-radius: 15px;
            transition: 0.3s;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .uni-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <h2 class="text-center fw-bold mb-4">University Explorer</h2>

        <form class="row justify-content-center mb-5" method="GET">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by name or location..."
                        value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-primary" type="submit">Search</button>
                    <a href="university-explorer.php" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>

        <form action="university-compare.php" method="GET">
            <div class="row g-4">
                <?php foreach ($universities as $uni): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card uni-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title fw-bold"><?php echo htmlspecialchars($uni['name']); ?></h5>
                                    <span class="badge bg-success rounded-pill">#<?php echo $uni['ranking']; ?></span>
                                </div>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($uni['location']); ?>
                                </h6>
                                <p class="card-text small"><?php echo htmlspecialchars($uni['description']); ?></p>
                                <a href="#" class="card-link text-decoration-none">Visit Website</a>
                            </div>
                            <div
                                class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="ids[]"
                                        value="<?php echo $uni['id']; ?>" id="uni<?php echo $uni['id']; ?>">
                                    <label class="form-check-label text-muted small" for="uni<?php echo $uni['id']; ?>">
                                        Compare
                                    </label>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill">Details</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="fixed-bottom p-3 bg-white border-top shadow-lg" style="display: none;" id="compareBar">
                <div class="container d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Select universities to compare</span>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Compare Selected</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Simple script to show compare bar when checkboxes are checked
        const checkboxes = document.querySelectorAll('.form-check-input');
        const compareBar = document.getElementById('compareBar');

        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                const checked = document.querySelectorAll('.form-check-input:checked');
                if (checked.length > 1) {
                    compareBar.style.display = 'block';
                } else {
                    compareBar.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>