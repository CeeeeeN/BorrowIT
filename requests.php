<?php
include("DB.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowing Requests</title>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="img/plv logo.jpg" alt="Logo 1" class="header-logo">
            <img src="img/suhay ce logo.jpg" alt="Logo 2" class="header-logo">
            <h1>BorrowIt Suhay CE</h1>
        </div>
        <nav>
            <a href="index.html" class="nav-btn">Dashboard</a>
            <a href="inventory.php" class="nav-btn">Inventory</a>
            <a href="requests.php" class="nav-btn active">Requests</a>
            <a href="records.php" class="nav-btn">Records</a>
        </nav>
    </header>
    <main class="inventory-main">
        <div class="page-header">
            <div>
                <h2 class="page-title">Borrowing Requests</h2>
                <p class="page-description">Review and approve pending equipment borrowing requests from users.</p>
            </div>
        </div>

        <div class="table-container">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Borrower</th>
                        <th>Item</th>
                        <th>QTY</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT borrow_log_id, student_name, student_number, year_section, item_name, quantity_borrowed, borrow_date, log_status FROM student_borrow_logs WHERE log_status = 'Requested' ORDER BY borrow_log_id DESC";
				        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['student_name']}<br>{$row['student_number']}<br>{$row['year_section']}</td>";
                            echo "<td>{$row['item_name']}</td>";
                            echo "<td>{$row['quantity_borrowed']}</td>";
                            echo "<td>{$row['borrow_date']}</td>";
                            echo "<td>";
                            echo "<form action='borrow_status.php' method='POST'>";
                                echo "<input type='hidden' name='id' value='" . $row['borrow_log_id'] . "'>";
                                echo "<button type='submit' class='approve-btn' name='borrowStatus' value='2'>Approve</button>";
                                echo "<button type='submit' class='deny-btn' name='borrowStatus' value='5'>Deny</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
