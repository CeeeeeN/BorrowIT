<?php
include("DB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST["student_name"];
    $student_id = $_POST["student_id"];
    $year_section = $_POST["year_section"];
    $item = $_POST["item"];
    $quantity = $_POST["quantity"];

    $sql = "INSERT INTO student_borrow_logs(student_name, student_number, year_section, item_name, quantity_borrowed)
    VALUES ('$student_name', '$student_id', '$year_section', '$item', '$quantity')";

    if (mysqli_query($conn, $sql)) {
        header("Location: request-form.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);

?>