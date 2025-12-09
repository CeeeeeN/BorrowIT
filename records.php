<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include("DB.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowing Records</title>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="img/plv logo.jpg" alt="Logo 1" class="header-logo">
            <img src="img/suhay ce logo.jpg" alt="Logo 2" class="header-logo">
            <h1>BorrowIT Suhay CE</h1>
        </div>
        <nav>
            <?php if ($_SESSION['account_type'] == 'SuperAdmin'): ?>
                <a href="admin_approval.php" class="nav-btn">Superadmin</a>
            <?php endif; ?>
            <!--<a href="index.php" class="nav-btn">Dashboard</a>-->
            <a href="inventory.php" class="nav-btn">Inventory</a>
            <a href="requests.php" class="nav-btn">Requests</a>
            <a href="records.php" class="nav-btn active">Records</a>
            <a href="logout.php" class="nav-btn logout-btn">Logout</a>
        </nav>
    </header>

    <main class="inventory-main">
        <div class="page-header">
            <div>
                <h2 class="page-title">Borrowing Records</h2>
                <p class="page-description">View complete history of all equipment borrowing transactions and returns.</p>
            </div>
        </div>

        <div class="filters-container">
            <div class="filter-group">
                <label for="statusFilter">Status:</label>
                <select id="statusFilter">
                    <option value="">All Statuses</option>
                    <option value="Approved">Approved</option>
                    <option value="Requested">Requested</option>
                    <option value="Returned">Returned</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="borrowerSearch">Borrower:</label>
                <input type="text" id="borrowerSearch" placeholder="Search by name or number...">
            </div>
            <div class="filter-group">
                <label for="itemSearch">Item:</label>
                <input type="text" id="itemSearch" placeholder="Search by item name...">
            </div>
            <div class="filter-group">
                <label for="startDate">From:</label>
                <input type="date" id="startDate">
            </div>
            <div class="filter-group">
                <label for="endDate">To:</label>
                <input type="date" id="endDate">
            </div>
            <div class="filter-group">
                <button id="applyFilters" class="action-btn primary">Apply Filters</button>
                <button id="clearFilters" class="action-btn secondary">Clear</button>
            </div>
        </div>

        <div class="table-container">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Borrower</th>
                        <th>Item</th>
                        <th>QTY</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="recordsTableBody">
                    <!-- Records will be loaded here -->
                </tbody>
            </table>
        </div>
    </main>
    <script src="records.js"></script>
    <script>
        // Logout confirmation
        document.querySelector('.logout-btn')?.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to logout?')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
