<?php
include("DB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review_id = $_POST['id'];
    $approval = $_POST['borrowStatus'];
    
    $sql = "UPDATE student_borrow_logs SET log_status = $approval WHERE borrow_log_id = $review_id";
    
    if (mysqli_query($conn, $sql)) {
        echo "Review updated successfully!";
    } else {
        echo "Error updating review: " . mysqli_error($conn);
    }
}

// Redirect back to reviews page
header("Location: requests.php");
exit();


// Close connection
mysqli_close($conn);
?>