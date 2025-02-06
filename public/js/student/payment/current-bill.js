document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll('input[name^="registration_fee_id"]');
    const totalWillBePaid = document.getElementById("totalWillBePaid");
    const dpElement = document.getElementById("dp");
    const restBillElement = document.getElementById("restBill");

    function updateTotal() {
        let total = 0;
        let dp = 0;

        checkboxes.forEach((checkbox) => {
            const listItem = checkbox.closest('li');
            const amountInput = listItem.querySelector('.input-amount-of-bill');
            const label = listItem.querySelector('label[for="' + checkbox.id + '"]');
            const amountValue = parseFloat(checkbox.dataset.amount);

            if (checkbox.checked) {
                if (amountInput) {
                    amountInput.style.display = 'block';
                    dp += parseFloat(amountInput.value);
                } else {
                    dp += amountValue;
                }
                label.classList.remove('btn-outline-primary');
                label.classList.add('btn-primary');
                label.textContent = 'Tagihan Dipilih';
            } else {
                if (amountInput) {
                    amountInput.style.display = 'none';
                }
                label.classList.remove('btn-primary');
                label.classList.add('btn-outline-primary');
                label.textContent = 'Pilih Tagihan';
            }

            if (checkbox.checked) {
                total += amountValue;
            }
        });

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