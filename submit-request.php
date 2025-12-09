<?php
include("DB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST["student_name"];
    $student_id = $_POST["student_id"];
    $year_section = $_POST["year_section"];
    $item = $_POST["item"];
    $quantity = $_POST["quantity"];

    // Check available quantity in inventory
    $sql_check = "SELECT quantity FROM inventory WHERE name = '$item'";
    $result_check = mysqli_query($conn, $sql_check);

    if ($result_check && mysqli_num_rows($result_check) > 0) {
        $row = mysqli_fetch_assoc($result_check);
        $available_quantity = $row['quantity'];

        if ($quantity > $available_quantity) {
            // Show alert if requested quantity exceeds available
            echo "<script>alert('Requested quantity ($quantity) exceeds available inventory ($available_quantity). Please adjust your request.'); window.location.href='request-form.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Item not found in inventory.'); window.location.href='request-form.php';</script>";
        exit();
    }

    $sql = "INSERT INTO student_borrow_logs(student_name, student_number, year_section, item_name, quantity_borrowed)
    VALUES ('$student_name', '$student_id', '$year_section', '$item', '$quantity')";

    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Request submitted'); window.location.href='request-form.php';</script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
}

mysqli_close($conn);

?>