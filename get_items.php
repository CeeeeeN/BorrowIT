<?php

include 'db_connect.php';

$whereClauses = [];
$params = [];
$types = '';

$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$status = isset($_GET['status']) ? trim($_GET['status']) : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($category)) {
    $whereClauses[] = "category = ?";
    $params[] = $category;
    $types .= 's';
}

if (!empty($status)) {
    if ($status === 'available') {
        $whereClauses[] = "quantity > 0";
    } elseif ($status === 'unavailable') {
        $whereClauses[] = "quantity = 0";
    }
}

if (!empty($search)) {
    $whereClauses[] = "name LIKE ?";
    $params[] = '%' . $search . '%';
    $types .= 's';
}

$sql = "SELECT * FROM inventory";
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(' AND ', $whereClauses);
}
$sql .= " ORDER BY category, name";

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$items = array();
while($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}

echo json_encode($items);
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
