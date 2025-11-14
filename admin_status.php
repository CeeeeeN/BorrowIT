<?php
include("DB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['AccountStatus'])) {
        $adminID = $_POST['AdminID'];
        $statusValue = $_POST['AccountStatus'];

        // Determine status based on value
        $status = ($statusValue == 2) ? 'Approved' : 'Denied';

        // Update admin status
        $sql = "UPDATE admin SET status = '$status' WHERE AdminID = $adminID";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Admin status updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating admin status: " . mysqli_error($conn) . "');</script>";
        }
    } elseif (isset($_POST['AccountUpdate'])) {
        $adminID = $_POST['AdminID'];
        $accountType = $_POST['AccountType'];
        $password = $_POST['Password'];

        // Hash the password if it's not empty
        if (!empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE admin SET AccountType = '$accountType', Password = '$passwordHash' WHERE AdminID = $adminID";
        } else {
            $sql = "UPDATE admin SET AccountType = '$accountType' WHERE AdminID = $adminID";
        }

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Admin account updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating admin account: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Redirect back to admin_approval.php
header("Location: admin_approval.php");
exit();

// Close connection
mysqli_close($conn);
?>
