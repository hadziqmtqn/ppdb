document.addEventListener('DOMContentLoaded', function() {
    const paymentSlug = document.getElementById('paymentSlug');
    const slug = paymentSlug.dataset.slug;

    function checkPaymentStatus() {
        axios.get(`/payment-transaction/${slug}/check-payment`)
            .then(function(response) {
                if (response.data.success) {
                    const status = response.data.data.status;
                    const paymentMethod = response.data.data.paymentMethod;
                    const paymentChannel = response.data.data.paymentChannel;

                    const paymentStatusButton = document.getElementById('paymentStatus');
                    paymentStatusButton.classList.remove('btn-outline-warning', 'btn-outline-success', 'btn-outline-danger');
                    paymentStatusButton.classList.add('btn-outline-' + (status === 'PENDING' ? 'warning' : (status === 'PAID' ? 'success' : 'danger')));
                    paymentStatusButton.textContent = status;

                    document.getElementById('paymenyMethod').textContent = paymentMethod;
                    document.getElementById('paymentChannel').textContent = paymentChannel;

                    const checkoutLink = document.getElementById('checkoutLink');
                    if (status === 'PAID') {
                        clearInterval(paymentStatusInterval);
                        const buttonElement = document.createElement('button');
                        buttonElement.type = 'button';
                        buttonElement.className = 'btn btn-primary w-100';
                        buttonElement.id = 'checkoutLink';
                        buttonElement.disabled = true;
                        buttonElement.textContent = 'Bayar Sekarang';
                        checkoutLink.replaceWith(buttonElement);
                    }
                }
            })
            .catch(function(error) {
                console.error('Failed to check payment status', error);
            });
    }

    // Check payment status every few seconds
    const paymentStatusInterval = setInterval(checkPaymentStatus, 1000);
});