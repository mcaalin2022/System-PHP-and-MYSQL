<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login-student.php");
    exit();
}
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Analysis - University Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8f9fa;
        }

        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold">Faculty Analysis</h2>
                <p class="text-muted">Detailed insights into different faculties and their trends.</p>
            </div>
            <a href="student-dashboard.php" class="btn btn-outline-secondary rounded-pill">Back to Dashboard</a>
        </div>

        <div class="row g-4">
            <!-- Mock Data Visualization -->
            <div class="col-md-8">
                <div class="chart-container">
                    <h5 class="mb-4">Average GPA Acceptance by Faculty</h5>
                    <canvas id="gpaChart"></canvas>
                </div>
            </div>

            <div class="col-md-4">
                <div class="chart-container h-100">
                    <h5 class="mb-4">Popular Faculties</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            Medicine
                            <span class="badge bg-primary rounded-pill">98%</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            Engineering
                            <span class="badge bg-primary rounded-pill">95%</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                             Computer Science
                            <span class="badge bg-primary rounded-pill">88%</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            Business
                            <span class="badge bg-primary rounded-pill">85%</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            Arts
                            <span class="badge bg-primary rounded-pill">75%</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="chart-container">
                    <h5>Faculty Requirements Breakdown ("Parses")</h5>
                    <p>Detailed breakdown of requirements for each program structure.</p>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Faculty</th>
                                    <th>Core Subjects</th>
                                    <th>Min GPA</th>
                                    <th>Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Engineering</td>
                                    <td>Math, Physics, Chemistry</td>
                                    <td>3.5</td>
                                    <td>4-5 Years</td>
                                </tr>
                                <tr>
                                    <td>Medicine</td>
                                    <td>Biology, Chemistry, Physics</td>
                                    <td>3.8</td>
                                    <td>6-7 Years</td>
                                </tr>
                                <tr>
                                    <td>Business</td>
                                    <td>Math, Economics, Accounting</td>
                                    <td>3.0</td>
                                    <td>3-4 Years</td>
                                </tr>
                                   <tr>
                                    <td>Computer Science</td>
                                    <td>Basic Sof and Hadr, Dsingn, Arts</td>
                                    <td>3.5</td>
                                    <td>4-5 Years</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('gpaChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Medicine', 'Engineering', 'Law', 'Business', 'Science', 'Arts'],
                datasets: [{
                    label: 'Min GPA Requirement',
                    data: [3.8, 3.5, 3.4, 3.0, 2.8, 2.5],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 2
                    }
                }
            }
        });
    </script>
</body>

</html>