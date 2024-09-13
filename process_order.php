<?php
session_start();

// Get the order data from the request
$orderData = json_decode(file_get_contents('php://input'), true);

if (!$orderData) {
    echo json_encode(['success' => false, 'message' => 'Invalid order data.']);
    exit();
}

// Store the order data in the session
$_SESSION['order'] = $orderData;

echo json_encode(['success' => true]);
?>
