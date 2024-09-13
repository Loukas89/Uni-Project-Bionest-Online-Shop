<?php
session_start();

// Check if order details are available in the session
if (!isset($_SESSION['order'])) {
    header('Location: cart.php');
    exit();
}

$order = $_SESSION['order'];

// Clear the cart and order details from the session after displaying the confirmation
unset($_SESSION['cart']);
unset($_SESSION['order']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="confirmation.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="container">
        <h1>Order Completed Successfully!</h1>
        <p>Thank you, <?php echo htmlspecialchars($order['customerName']); ?>. Your order will be delivered to <?php echo htmlspecialchars($order['address']); ?>.</p>
        <h2>Order Summary</h2>
        <ul>
            <?php foreach ($order['items'] as $item): ?>
                <li><?php echo $item['quantity']; ?> x <?php echo htmlspecialchars($item['name']); ?> - $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></li>
            <?php endforeach; ?>
        </ul>
        <h3>Total: $<?php echo number_format($order['total'], 2); ?></h3>
        <button onclick="window.location.href='index.html'">Order More</button>
    </div>
</body>
</html>
