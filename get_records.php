<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include("DB.php");

$whereClauses = [];
$params = [];
$types = '';

$status = isset($_GET['status']) ? trim($_GET['status']) : '';
$borrower = isset($_GET['borrower']) ? trim($_GET['borrower']) : '';
$item = isset($_GET['item']) ? trim($_GET['item']) : '';
$startDate = isset($_GET['start_date']) ? trim($_GET['start_date']) : '';
$endDate = isset($_GET['end_date']) ? trim($_GET['end_date']) : '';

if (!empty($status)) {
    $whereClauses[] = "log_status = ?";
    $params[] = $status;
    $types .= 's';
}

if (!empty($borrower)) {
    $whereClauses[] = "(student_name LIKE ? OR student_number LIKE ?)";
    $params[] = '%' . $borrower . '%';
    $params[] = '%' . $borrower . '%';
    $types .= 'ss';
}

if (!empty($item)) {
    $whereClauses[] = "item_name LIKE ?";
    $params[] = '%' . $item . '%';
    $types .= 's';
}

if (!empty($startDate) && !empty($endDate)) {
    $whereClauses[] = "borrow_date BETWEEN ? AND ?";
    $params[] = $startDate;
    $params[] = $endDate;
    $types .= 'ss';
} elseif (!empty($startDate)) {
    $whereClauses[] = "borrow_date >= ?";
    $params[] = $startDate;
    $types .= 's';
} elseif (!empty($endDate)) {
    $whereClauses[] = "borrow_date <= ?";
    $params[] = $endDate;
    $types .= 's';
}

$sql = "SELECT borrow_log_id, student_name, student_number, year_section, item_name, quantity_borrowed, borrow_date, return_date, log_status FROM student_borrow_logs";
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(' AND ', $whereClauses);
}
$sql .= " ORDER BY borrow_log_id DESC";

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$records = array();
while($row = mysqli_fetch_assoc($result)) {
    $records[] = $row;
}

echo json_encode($records);
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
