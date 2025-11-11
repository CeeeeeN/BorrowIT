<?php
 
include 'db_connect.php';

$name = mysqli_real_escape_string($conn, $_POST['name']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

$sql = "INSERT INTO inventory (name, category, quantity) VALUES ('$name', '$category', '$quantity')";

if(mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'message' => 'Item added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
}

mysqli_close($conn);
?>