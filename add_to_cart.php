<?php
session_start();
include 'db_config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['customerId'])) {
    echo json_encode(['success' => false, 'message' => 'You need to log in to add items to the cart.']);
    exit();
}

$customerId = $_SESSION['customerId'];

// Debugging: Check if the session customerId is set
error_log("Session customerId: " . $customerId);

$postData = json_decode(file_get_contents('php://input'), true);
$productId = $postData['productId'];
$quantity = $postData['quantity'] ?? 1;

if (empty($productId) || $quantity < 1) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID or quantity.']);
    exit();
}

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Debugging: Check connection status
error_log("Connected to the database. Customer ID: $customerId, Product ID: $productId, Quantity: $quantity");

$sql = "SELECT * FROM Cart WHERE CustomerId = ? AND ProductColorAvailabilityId = ?";
$params = array($customerId, $productId);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $sql = "UPDATE Cart SET Quantity = Quantity + ? WHERE CustomerId = ? AND ProductColorAvailabilityId = ?";
    $params = array($quantity, $customerId, $productId);
} else {
    $sql = "INSERT INTO Cart (CustomerId, ProductColorAvailabilityId, Quantity) VALUES (?, ?, ?)";
    $params = array($customerId, $productId, $quantity);
}

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Debugging: Confirm query execution
error_log("Query executed successfully. Product ID: $productId added/updated for customer ID: $customerId with quantity: $quantity");

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

echo json_encode(['success' => true, 'message' => 'Product added to the cart.']);
?>
