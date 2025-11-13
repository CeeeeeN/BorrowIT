<?php
include("DB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrow_log_id = $_POST['borrow_log_id'];

    // Update the return_date to the current date and set status to returned
    $current_date = date('Y-m-d H:i:s');
    $sql = "UPDATE student_borrow_logs SET return_date = '$current_date', log_status = 4 WHERE borrow_log_id = $borrow_log_id";

    if (mysqli_query($conn, $sql)) {
        echo "Item marked as returned successfully!";
    } else {
        echo "Error updating return date: " . mysqli_error($conn);
    }
}

// Redirect back to records page
header("Location: records.php");
exit();

// Close connection
mysqli_close($conn);
?>
