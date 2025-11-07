<?php
 
include 'db_connect.php';

$id = mysqli_real_escape_string($conn, $_POST['id']);

$sql = "DELETE FROM inventory WHERE id=$id";

if(mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'message' => 'Item deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
}

mysqli_close($conn);
?>
