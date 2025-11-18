<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Inventory</title>
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
            <a href="inventory.php" class="nav-btn active">Inventory</a>
            <a href="requests.php" class="nav-btn">Requests</a>
            <a href="records.php" class="nav-btn">Records</a>
            <a href="logout.php" class="nav-btn logout-btn">Logout</a>
        </nav>
    </header>
    
    <main class="inventory-main">
        <div class="page-header">
            <div>
                <h2 class="page-title">Equipment Inventory</h2>
                <p class="page-description">Manage all equipment items, update quantities, and track availability status.</p>
            </div>
            <button class="action-btn primary" onclick="openAddModal()">+ Add New Item</button>
        </div>

        <div class="filters-container">
            <div class="filter-group">
                <label for="categoryFilter">Category:</label>
                <select id="categoryFilter">
                    <option value="">All Categories</option>
                    <option value="Calculators">Calculators</option>
                    <option value="Drafting Tools">Drafting Tools</option>
                    <option value="Reference Books">Reference Books</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="statusFilter">Status:</label>
                <select id="statusFilter">
                    <option value="">All Statuses</option>
                    <option value="available">Available</option>
                    <option value="unavailable">Unavailable</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="searchFilter">Search:</label>
                <input type="text" id="searchFilter" placeholder="Search items...">
            </div>
        </div>

        <div class="table-container">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="inventoryTableBody">
                    <!-- Items will be loaded here -->
                </tbody>
            </table>
        </div>
    </main>

    <!-- Add Item Modal -->
    <div id="addModal" class="modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Item</h3>
                <span class="modal-close" onclick="closeAddModal()">&times;</span>
            </div>
            <form id="addForm" onsubmit="addItem(event)">
                <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" id="itemName" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select id="itemCategory" required>
                        <option value="Calculators">Calculators</option>
                        <option value="Drafting Tools">Drafting Tools</option>
                        <option value="Reference Books">Reference Books</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" id="itemQuantity" min="0" value="1" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn secondary" onclick="closeAddModal()">Cancel</button>
                    <button type="submit" class="action-btn primary">Add Item</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Item Modal -->
    <div id="updateModal" class="modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Update Item</h3>
                <span class="modal-close" onclick="closeUpdateModal()">&times;</span>
            </div>
            <form id="updateForm" onsubmit="updateItem(event)">
                <input type="hidden" id="updateItemId">
                <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" id="updateItemName" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select id="updateItemCategory" required>
                        <option value="Calculators">Calculators</option>
                        <option value="Drafting Tools">Drafting Tools</option>
                        <option value="Reference Books">Reference Books</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" id="updateItemQuantity" min="0" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn secondary" onclick="closeUpdateModal()">Cancel</button>
                    <button type="submit" class="action-btn primary">Update Item</button>
                </div>
            </form>
        </div>
    </div>

    <script src="inventory.js"></script>
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
