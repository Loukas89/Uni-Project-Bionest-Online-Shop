<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['customerId'])) {
    echo json_encode(['count' => 0]);
    exit();
}

$customerId = $_SESSION['customerId'];
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

$sql = "SELECT SUM(Quantity) AS count FROM Cart WHERE CustomerId = ?";
$params = array($customerId);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
$count = $row['count'] ?? 0;

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

echo json_encode(['count' => $count]);
?>
