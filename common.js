// common.js
function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const count = cart.reduce((acc, item) => acc + item.quantity, 0);
    document.querySelector('.cart-icon .count').textContent = count;
}

document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
});
