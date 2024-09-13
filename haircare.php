<?php
// haircare.php
// Database connection
$serverName = "DESKTOP-9RMQ4K2";
$connectionOptions = array(
    "Database" => "bio_shop",
    "Uid" => "", // Update with your database username
    "PWD" => ""  // Update with your database password
);

// Establish the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch products and images for haircare from the database
$sql = "SELECT Item.IId, Item.Name, Item.Description, ProductColorAvailability.Price, ProductColorAvailability.Stock, ImagePaths.ImagePath
        FROM Item
        JOIN ProductColorAvailability ON Item.IId = ProductColorAvailability.ItemId
        JOIN ImagePaths ON ProductColorAvailability.ImageId = ImagePaths.ImageId
        JOIN Category ON Item.CategoryId = Category.CATid
        WHERE Category.CATid = 10";  // Use CATid = 10 for Organic Haircare

$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$products = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $row['ImagePath'] = 'data:image/jpeg;base64,' . base64_encode($row['ImagePath']);
    $products[] = $row;
}

// Close the connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bio Shop - Organic Haircare</title>
    <link href="products2.css" rel="stylesheet" type="text/css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const products = <?php echo json_encode($products); ?>;
            const productGrid = document.getElementById('productGrid');
            productGrid.innerHTML = ''; // Clear the grid

            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.classList.add('product-card');

                productCard.innerHTML = `
                    <img src="${product.ImagePath}" alt="${product.Name}">
                    <h2>${product.Name}</h2>
                    <p>${product.Description}</p>
                    <p class="price">$${product.Price.toFixed(2)}</p>
                    <p class="stock">${product.Stock > 0 ? 'In Stock' : 'Out of Stock'}</p>
                    <button class="add-to-cart" data-id="${product.IId}" data-name="${product.Name}" data-price="${product.Price}" data-description="${product.Description}">Add to Cart</button>
                `;

                productGrid.appendChild(productCard);
            });

            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    const productName = this.getAttribute('data-name');
                    const productPrice = this.getAttribute('data-price');
                    const productDescription = this.getAttribute('data-description');
                    addToCart(productId, productName, productPrice, productDescription);
                });
            });
        });

        function addToCart(productId, productName, productPrice, productDescription) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingProductIndex = cart.findIndex(item => item.id == productId);

            if (existingProductIndex > -1) {
                cart[existingProductIndex].quantity += 1;
            } else {
                const product = {
                    id: productId,
                    name: productName,
                    price: parseFloat(productPrice),
                    description: productDescription,
                    quantity: 1
                };
                cart.push(product);
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
        }

        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const count = cart.reduce((acc, item) => acc + item.quantity, 0);
            document.querySelector('.cart-icon .count').textContent = count;
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateCartCount();
        });
    </script>
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
            <h1>Organic Haircare</h1>
            <div id="productGrid" class="product-grid">
                <!-- Products will be dynamically inserted here -->
            </div>
        </main>
        <footer>
            © 2024 Bio Shop. All rights reserved.
        </footer>
    </div>
</body>
</html>
