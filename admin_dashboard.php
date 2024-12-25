<?php
session_start();
include('db.php'); // Include database connection

// Admin login check
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch orders to display in the dashboard
$query = "SELECT id, user_id, created_at, status FROM orders ORDER BY created_at DESC"; 
$result = $conn->query($query); // Execute the query
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 70px;
            background-color: #f8f9fa;
        }
        .dashboard-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        footer {
            margin-top: 30px;
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text me-3">Welcome, <?= htmlspecialchars($_SESSION['admin']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container mt-5">
        <div class="row">
            <!-- Manage Products -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Manage Products</h5>
                        <p class="card-text">Add, edit, or view all products.</p>
                        <a href="manage_products.php" class="btn btn-primary">Go to Products</a>
                    </div>
                </div>
            </div>
            <!-- View Orders -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">View Orders</h5>
                        <p class="card-text">Check all customer orders.</p>
                        <a href="view_orders.php" class="btn btn-primary">View Orders</a>
                    </div>
                </div>
            </div>
            <!-- Manage Order Items -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Manage Order Items</h5>
                        <p class="card-text">View detailed order items.</p>
                        <a href="view_order_details.php" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Display Orders -->
            <div class="col-lg-12">
                <h2>Recent Orders</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= htmlspecialchars($order['id']); ?></td>
                                <td><?= htmlspecialchars($order['user_id']); ?></td>
                                <td><?= date("F j, Y, g:i a", strtotime($order['created_at'])); ?></td>
                                <td><?= htmlspecialchars($order['status']); ?></td>
                                <td>
                                    <a href="view_order_details.php?id=<?= htmlspecialchars($order['id']); ?>" class="btn btn-info">View Details</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; <?= date('Y'); ?> Admin Dashboard. All Rights Reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>