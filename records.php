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
            <a href="inventory.html" class="nav-btn">Inventory</a>
            <a href="requests.html" class="nav-btn">Requests</a>
            <a href="records.html" class="nav-btn active">Records</a>
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
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Paulo Galarosa</td>
                        <td>Projector</td>
                        <td>Nov 1</td>
                        <td>Nov 3</td>
                        <td>Returned</td>
                    </tr>
                    <?php
                        $sql = "SELECT student_name, student_number, year_section, borrow_date, return_date, log_status FROM student_borrow_logs ORDER BY borrow_log_id DESC";
				        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['student_name']}{$row['student_number']}{$row['year_section']}</td>";
                            echo "<td></td>";
                            echo "<td>{$row['borrow_date']}</td>";
                            echo "<td>{$row['return_date']}</td>";
                            echo "<td>{$row['log_status']}</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>