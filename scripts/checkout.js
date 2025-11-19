document.addEventListener('DOMContentLoaded', () => {
    const checkoutForm = document.getElementById('checkout-form');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const orderTotal = document.getElementById('order-total');

    // Validate form on submit
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', (e) => {
            const shippingAddress = document.getElementById('shipping_address').value;
            const cardNumber = document.getElementById('card_number').value;
            const cardExpiry = document.getElementById('card_expiry').value;
            const cardCvc = document.getElementById('card_cvc').value;

            let errors = [];

            if (!shippingAddress.trim()) {
                errors.push('La dirección de envío es obligatoria');
            }
            if (!/^\d{16}$/.test(cardNumber)) {
                errors.push('El número de tarjeta debe tener 16 dígitos');
            }
            if (!/^\d{2}\/\d{2}$/.test(cardExpiry)) {
                errors.push('La fecha de expiración debe ser en formato MM/AA');
            }
            if (!/^\d{3}$/.test(cardCvc)) {
                errors.push('El CVC debe tener 3 dígitos');
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
        });
    }

    // Update quantities and totals
    quantityInputs.forEach(input => {
        input.addEventListener('change', () => {
            const bookId = input.closest('tr').getAttribute('data-book-id');
            const quantity = parseInt(input.value);
            const price = parseFloat(input.getAttribute('data-price'));
            const subtotalElement = input.closest('tr').querySelector('.subtotal');

            if (quantity > 0) {
                // Update subtotal
                const subtotal = price * quantity;
                subtotalElement.textContent = `€${subtotal.toFixed(2)}`;

                // Update total
                let total = 0;
                document.querySelectorAll('.quantity-input').forEach(qtyInput => {
                    const qty = parseInt(qtyInput.value);
                    const prc = parseFloat(qtyInput.getAttribute('data-price'));
                    total += qty * prc;
                });
                orderTotal.textContent = `€${total.toFixed(2)}`;

                // Update cart via AJAX
                fetch('cart_handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `book_id=${bookId}&quantity=${quantity}&action=update`
                });
            }
        });
    });
});