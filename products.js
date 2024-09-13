const products = [
    { id: 2, name: "Organic Banana", price: 0.99, description: "Fresh organic bananas" },
    { id: 3, name: "Organic Carrot", price: 0.59, description: "Crunchy organic carrots" },
    { id: 4, name: "Organic Lettuce", price: 0.89, description: "Fresh organic lettuce" },
    { id: 14, name: "Mango Juice", price: 5.99, description: "Fresh organic mango juice" },
    { id: 15, name: "Lemon Juice", price: 4.99, description: "Fresh organic lemon juice" },
    { id: 16, name: "Strawberry Juice", price: 6.49, description: "Fresh organic strawberry juice" },
    { id: 23, name: "Organic Face Cream", price: 19.99, description: "Nourishing organic face cream" },
    { id: 25, name: "Organic Sunscreen", price: 12.99, description: "Protective organic sunscreen" },
    { id: 26, name: "Scalp Treatment", price: 8.00, description: "Organic scalp treatment product" },
    { id: 27, name: "Nourishing Hair Oil", price: 10.00, description: "Organic nourishing hair oil" },
    { id: 29, name: "Organic Body Lotion", price: 8.00, description: "Hydrating organic body lotion" },
    { id: 30, name: "Organic Hair Spray", price: 10.00, description: "Description of Organic Hair Spray" }
];

function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    if (!product) return;

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItem = cart.find(item => item.id === productId);

    if (cartItem) {
        cartItem.quantity += 1;
    } else {
        cart.push({ ...product, quantity: 1 });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const productId = parseInt(button.getAttribute('data-id'));
            addToCart(productId);
        });
    });
    updateCartCount();
});
