<?php
 
include 'db_connect.php';

$sql = "SELECT * FROM inventory ORDER BY category, name";
$result = mysqli_query($conn, $sql);

$items = array();
while($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}

echo json_encode($items);
mysqli_close($conn);
?>