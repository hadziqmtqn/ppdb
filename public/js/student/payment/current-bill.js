document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll('input[name="registration_fee_id[]"]');
    const totalWillBePaid = document.getElementById("totalWillBePaid");

    function updateTotal() {
        let total = 0;

        checkboxes.forEach((checkbox) => {
            const listItem = checkbox.closest('li');
            const amountInput = listItem.querySelector('.input-amount-of-bill');

            if (checkbox.checked) {
                if (amountInput) {
                    amountInput.style.display = 'block';
                    total += parseFloat(amountInput.value);
                } else {
                    total += parseFloat(checkbox.value);
                }
            } else {
                if (amountInput) {
                    amountInput.style.display = 'none';
                }
            }
        });

        totalWillBePaid.innerText = `Rp. ${total.toLocaleString('id-ID')}`;
    }

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", updateTotal);
    });

    document.querySelectorAll('.input-amount-of-bill').forEach((inputAmount) => {
        inputAmount.addEventListener("input", updateTotal);
    });
});