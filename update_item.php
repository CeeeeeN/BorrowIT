<?php
 
include 'db_connect.php';

$id = mysqli_real_escape_string($conn, $_POST['id']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

$sql = "UPDATE inventory SET name='$name', category='$category', quantity='$quantity' WHERE id=$id";

if(mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'message' => 'Item updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
}

mysqli_close($conn);
?>