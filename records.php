<?php
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
            <img src="plv logo.jpg" alt="Logo 1" class="header-logo">
            <img src="suhay ce logo.jpg" alt="Logo 2" class="header-logo">
            <h1>BorrowIT Suhay CE</h1>
        </div>
        <nav>
            <a href="admin.html" class="nav-btn">Dashboard</a>
            <a href="inventory.php" class="nav-btn">Inventory</a>
            <a href="requests.php" class="nav-btn">Requests</a>
            <a href="records.php" class="nav-btn active">Records</a>
        </nav>
    </header>
    <main class="inventory-main">
        <div class="page-header">
            <div>
                <h2 class="page-title">Borrowing Records</h2>
                <p class="page-description">View complete history of all equipment borrowing transactions and returns.</p>
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
                <tbody>
                    <?php
                        $sql = "SELECT borrow_log_id, student_name, student_number, year_section, item_name, quantity_borrowed, borrow_date, return_date, log_status FROM student_borrow_logs ORDER BY borrow_log_id DESC";
				        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['student_name']}<br>{$row['student_number']}<br>{$row['year_section']}</td>";
                            echo "<td>{$row['item_name']}</td>";
                            echo "<td>{$row['quantity_borrowed']}</td>";
                            echo "<td>{$row['borrow_date']}</td>";
                            echo "<td>";
                            if (is_null($row['return_date'])) {
                                echo "<form action='mark_returned.php' method='POST' style='display:inline;'>";
                                echo "<input type='hidden' name='borrow_log_id' value='" . $row['borrow_log_id'] . "'>";
                                echo "<button type='submit' class='action-btn primary'>Mark Returned</button>";
                                echo "</form>";
                            } else {
                                echo $row['return_date'] ?: '-';
                            }
                            echo "</td>";
                            echo "<td>{$row['log_status']}</td>";
                            echo "</tr>";
                        }

                        mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>