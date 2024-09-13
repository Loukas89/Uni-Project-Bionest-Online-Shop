document.addEventListener('DOMContentLoaded', () => {
    displayCartItems();
    updateCartCount();
    document.querySelector('#checkout').addEventListener('click', checkout);
});

function displayCartItems() {
    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    const cartContainer = document.querySelector('#cart-items');
    cartContainer.innerHTML = '';

    if (cartItems.length === 0) {
        cartContainer.innerHTML = '<p>Your cart is empty.</p>';
    } else {
        const table = document.createElement('table');
        table.innerHTML = `
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;
        const tbody = table.querySelector('tbody');

        cartItems.forEach((product, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.name}</td>
                <td>
                    <div class="quantity-controls">
                        <button class="increment-item" data-index="${index}">+</button>
                        ${product.quantity}
                        <button class="decrement-item" data-index="${index}">-</button>
                    </div>
                </td>
                <td>$${(product.price * product.quantity).toFixed(2)}</td>
                <td>
                    <button class="delete-item" data-index="${index}">🗑️</button>
                </td>
            `;
            tbody.appendChild(row);
        });

        cartContainer.appendChild(table);
    }
    updateTotal();
    addCartEventListeners();
}

function updateTotal() {
    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    const total = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.querySelector('#total').textContent = `$${total.toFixed(2)}`;
}

function addCartEventListeners() {
    document.querySelectorAll('.increment-item').forEach(button => {
        button.addEventListener('click', function () {
            const index = this.dataset.index;
            modifyCartItem(index, 'increment');
        });
    });

    document.querySelectorAll('.decrement-item').forEach(button => {
        button.addEventListener('click', function () {
            const index = this.dataset.index;
            modifyCartItem(index, 'decrement');
        });
    });

    document.querySelectorAll('.delete-item').forEach(button => {
        button.addEventListener('click', function () {
            const index = this.dataset.index;
            deleteCartItem(index);
        });
    });
}

function modifyCartItem(index, action) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (action === 'increment') {
        cart[index].quantity += 1;
    } else if (action === 'decrement' && cart[index].quantity > 1) {
        cart[index].quantity -= 1;
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    displayCartItems();
    updateCartCount();
}

function deleteCartItem(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    displayCartItems();
    updateCartCount();
}

function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const count = cart.reduce((total, item) => total + item.quantity, 0);
    document.querySelector('.cart-icon .count').textContent = count;
}

function checkout() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length === 0) {
        alert('Your cart is empty.');
        return;
    }

    const customerName = prompt('Please enter your name:');
    const address = prompt('Please enter your delivery address:');

    if (!customerName || !address) {
        alert('Name and address are required to complete the order.');
        return;
    }

    const order = {
        customerName: customerName,
        address: address,
        items: cart,
        total: cart.reduce((sum, item) => sum + (item.price * item.quantity), 0)
    };

    // Store the order in the session and redirect to the order confirmation page
    fetch('process_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(order)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            localStorage.removeItem('cart');
            window.location.href = 'order_confirmation.php';
        } else {
            alert('An error occurred while processing your order. Please try again.');
        }
    });
}