<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['customerId'])) {
    echo json_encode(['success' => false, 'message' => 'You need to log in to remove items from the cart.']);
    exit();
}

$customerId = $_SESSION['customerId'];

$postData = json_decode(file_get_contents('php://input'), true);
$productId = $postData['productId'] ?? null;

if ($productId === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID.']);
    exit();
}

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

$sql = "DELETE FROM Cart WHERE CustomerId = ? AND ProductColorAvailabilityId = ?";
$params = array($customerId, $productId);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

echo json_encode(['success' => true, 'message' => 'Product removed from the cart.']);
?>
