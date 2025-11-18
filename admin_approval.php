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
    <title>Admin Approval | BorrowIt Suhay CE</title>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="img/plv logo.jpg" alt="PLV Logo" class="header-logo">
            <img src="img/suhay ce logo.jpg" alt="Suhay CE Logo" class="header-logo">
            <h1>BorrowIT Suhay CE</h1>
        </div>
        <nav>
            <?php if ($_SESSION['account_type'] == 'SuperAdmin'): ?>
                <a href="admin_approval.php" class="nav-btn active">Superadmin</a>
            <?php endif; ?>
            <!--<a href="index.php" class="nav-btn">Dashboard</a>-->
            <a href="inventory.php" class="nav-btn">Inventory</a>
            <a href="requests.php" class="nav-btn">Requests</a>
            <a href="records.php" class="nav-btn">Records</a>
        </nav>
    </header>

    <main class="admin-main">
        <!-- Pending Admin Registrations -->
        <div class="page-header">
            <div>
                <h2 class="page-title">Admin Registration Requests</h2>
                <p class="page-description">Approve or deny pending admin registration requests for system access.</p>
            </div>
        </div>

        <div class="table-container">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Account Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT AdminID, Name, Email, AccountType FROM admin WHERE status = 'Pending' ORDER BY AdminID DESC";
				        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['Name']}</td>";
                            echo "<td>{$row['Email']}</td>";
                            echo "<td>{$row['AccountType']}</td>";
                            echo "<td>";
                            echo "<form action='admin_status.php' method='POST' style='display:inline;'>";
                            echo "<input type='hidden' name='AdminID' value='" . $row['AdminID'] . "'>";
                            echo "<button type='submit' class='approve-btn' name='AccountStatus' value='2'>Approve</button>";
                            echo "<button type='submit' class='deny-btn' name='AccountStatus' value='3'>Deny</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }


                    ?>
                </tbody>
            </table>
        </div>

        <!-- Existing Admin Accounts -->
        <div class="page-header admin-accounts-header">
            <div>
                <h2 class="page-title">Admin Accounts</h2>
                <p class="page-description">Manage current admin and superadmin accounts.</p>
            </div>
        </div>

        <div class="table-container">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Account Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT AdminID, Name, Email, Password, AccountType FROM admin WHERE status = 'Approved' ORDER BY AdminID DESC";
				        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['Name']}</td>";
                            echo "<td>{$row['Email']}</td>";
                            echo "<td>";
                            echo '<div class="password-wrapper">';
                                echo "<input type='password' value='' name='Password' class='admin-password' placeholder='Enter New Password'>";
                                echo '<img class="toggle-password" src="img/eyeClose.png" alt="Toggle password visibility">';
                            echo "</div>";
                            echo "</td>";
                            echo "<td>";
                            echo "<form action='admin_status.php' method='POST' style='display:inline;'>";
                            echo '<select class="admin-role-select" name="AccountType">';
                                echo "<option value='SuperAdmin' " . ($row['AccountType'] == 'SuperAdmin' ? 'selected' : '') . ">SuperAdmin</option>";
                                echo "<option value='Admin' " . ($row['AccountType'] == 'Admin' ? 'selected' : '') . ">Admin</option>";
                            echo "</select>";
                            echo "</td>";
                            echo "<td>";
                            echo "<input type='hidden' name='AdminID' value='" . $row['AdminID'] . "'>";
                            echo "<button type='submit' class='approve-btn' name='AccountUpdate'>Save Changes</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }


                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', () => {
                const input = icon.previousElementSibling;
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                icon.src = isHidden ? 'img/eyeOpen.png' : 'img/eyeClose.png';
            });
        });
    </script>
</body>
<?php 
    mysqli_close($conn);
?>
</html>
