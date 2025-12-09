<?php
include("DB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review_id = $_POST['id'];
    $approval = $_POST['borrowStatus'];

    // First, update the borrow log status
    $sql = "UPDATE student_borrow_logs SET log_status = $approval WHERE borrow_log_id = $review_id";

    if (mysqli_query($conn, $sql)) {
        // If approval is granted (status 2), deduct quantity from inventory
        if ($approval == 2) {
            // Fetch the item name and quantity borrowed for the specific borrow_log_id
            $fetch_sql = "SELECT item_name, quantity_borrowed FROM student_borrow_logs WHERE borrow_log_id = $review_id";
            $result = mysqli_query($conn, $fetch_sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $item_name = mysqli_real_escape_string($conn, $row['item_name']);
                $quantity_borrowed = $row['quantity_borrowed'];

                // Update inventory by subtracting the borrowed quantity
                $update_inventory_sql = "UPDATE inventory SET quantity = quantity - $quantity_borrowed WHERE name = '$item_name' AND quantity >= $quantity_borrowed";

                if (mysqli_query($conn, $update_inventory_sql)) {
                    if (mysqli_affected_rows($conn) > 0) {
                        echo "Request approved and inventory updated successfully!";
                    } else {
                        echo "Request approved, but inventory update failed. Item may not exist or insufficient quantity.";
                    }
                } else {
                    echo "Request approved, but error updating inventory: " . mysqli_error($conn);
                }
            } else {
                echo "Request approved, but could not fetch borrow details.";
            }
        } else {
            echo "Request status updated successfully!";
        }
    } else {
        echo "Error updating request status: " . mysqli_error($conn);
    }
}

// Redirect back to reviews page
header("Location: requests.php");
exit();

// Close connection
mysqli_close($conn);
?>
