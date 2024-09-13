<?php
session_start();

if (!isset($_SESSION['customerId'])) {
    echo "You need to log in to view your cart.";
    exit();
}

$customerId = $_SESSION['customerId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="cart.css" rel="stylesheet" type="text/css">
    <script src="cart.js"></script>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <a href="home.html">
                <img src="Photos/bionest.png" class="mainicon" alt="Bio Shop Home">
            </a>
            <div class="nav-links">
                <a href="home.html">Home</a>
                <a href="index.html">Products</a>
                <a href="aboutus.html">About Us</a>
                <a href="contactus.html">Contact Us</a>
            </div>
            <div class="nav-search-profile">
                <form class="search-form">
                    <input type="search" name="search" placeholder="Search products..." />
                    <button type="submit">Search</button>
                </form>
                <a href="loginpage.html" class="icon profile-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" width="24" height="24" class="prof">
                        <path d="M12,12a4,4 0 1,0 -4,-4a4,4 0 0,0 4,4m0,2c-2.67,0 -8,1.34 -8,4v2h16v-2c0,-2.66 -5.33,-4 -8,-4"/>
                    </svg>
                </a>
                <a href="cart.php" class="icon cart-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" width="24" height="24" class="cart">
                        <path d="M7,18a2,2 0 1,0 2,2a2,2 0 0,0 -2,-2m9,0a2,2 0 1,0 2,2a2,2 0 0,0 -2,-2M1,2h3.6l1.35,4H19a1,1 0 0,1 0,2h-14l-0.35,1h12a1,1 0 1,1 0,2h-12l-1.65,4.55a1,1 0 0,1 -0.95,0.45h-2a1,1 0 1,1 0,-2h1.2l1.45,-4H4.8L3.45,4H1a1,1 0 1,1 0,-2"/>
                    </svg>
                    <span class="count">0</span>
                </a>
            </div>
        </nav>
        <main>
            <h1>Your Cart</h1>
            <div id="cart-items" class="cart-items"></div>
            <div class="cart-summary">
                <h2>Total: <span id="total">$0.00</span></h2>
                <button id="checkout" class="btn-checkout">Checkout</button>
            </div>
        </main>
        <footer>
            © 2024 Bio Shop. All rights reserved.
        </footer>
    </div>
</body>
</html>
