<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Sent - Bio Shop</title>
    <meta name="description" content="Get in touch with Bio Shop - We'd love to hear from you.">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="contactus.css" rel="stylesheet" type="text/css">
    <style>
        .confirmation-message {
            background-color: #e0f7e9;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 30px 265px 50px auto; /* Position to the right */
            width: 60%;
            font-size: 1.3em; /* Increase the font size */
            color: #000;
        }
        .confirmation-message h1 {
            font-size: 2.3em; /* Increase the font size */
            color: #249b24;
        }
        .confirmation-message p {
            font-size: 1.3em; /* Increase the font size */
        }
        .confirmation-message a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #249b24;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 1.5em; /* Increase the font size */
        }
        .confirmation-message a:hover {
            background-color: #1a5d1a;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <a href="home.html">
                <img src="Photos/bionest.png" class="mainicon" alt="Mainhome">
            </a>
            <div class="nav-links">
                <a href="redirect_home.php">Home</a>
                <a href="redirect_products.php">Products</a>
                <a href="redirect_aboutus.php">About Us</a>
                <a href="redirect_contactus.php">Contact Us</a>
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
        
        <section class="confirmation-message">
            <h1>Message sent successfully!</h1>
            <p>Contact Message:</p>
            <p>- Name: <?php echo $name; ?></p>
            <p>- Email: <?php echo $email; ?></p>
            <p>- Message: <?php echo $message; ?></p>
            <a href="contactus.html">Send another message</a>
        </section>
    </div>
    <script src="common.js"></script> <!-- Include the common.js file -->
    <footer>
        © 2024 Bio Shop. All rights reserved.
    </footer>
</body>
</html>
