document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll('input[name="registration_fee_id[]"]');
    const totalWillBePaid = document.getElementById("totalWillBePaid");
    const dpElement = document.getElementById("dp");
    const restBillElement = document.getElementById("restBill");

    function updateTotal() {
        let total = 0;
        let dp = 0;

        checkboxes.forEach((checkbox) => {
            const listItem = checkbox.closest('li');
            const amountInput = listItem.querySelector('.input-amount-of-bill');

            if (checkbox.checked) {
                if (amountInput) {
                    amountInput.style.display = 'block';
                    const amountValue = parseFloat(amountInput.value);
                    dp += amountValue;
                } else {
                    const amountValue = parseFloat(checkbox.value);
                    dp += amountValue;
                }
            } else {
                if (amountInput) {
                    amountInput.style.display = 'none';
                }
            }
        });

        total = Array.from(checkboxes).reduce((acc, checkbox) => {
            return acc + parseFloat(checkbox.value);
        }, 0);

        const restBill = total - dp;

        totalWillBePaid.innerText = `Rp. ${dp.toLocaleString('id-ID')}`;
        dpElement.innerText = `Rp. ${dp.toLocaleString('id-ID')}`;
        restBillElement.innerText = `Rp. ${restBill.toLocaleString('id-ID')}`;
    }

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", updateTotal);
    });

    document.querySelectorAll('.input-amount-of-bill').forEach((inputAmount) => {
        inputAmount.addEventListener("input", function () {
            const min = parseFloat(inputAmount.min);
            const max = parseFloat(inputAmount.max);
            let value = parseFloat(inputAmount.value);

            if (value < min) {
                value = min;
            } else if (value > max) {
                value = max;
            }

            inputAmount.value = value;
            updateTotal();
        });
    });
});