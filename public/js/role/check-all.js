document.addEventListener('DOMContentLoaded', function () {
    // Loop through all card headers and attach a Check All feature
    document.querySelectorAll('.card-header').forEach(function (header) {
        // Create Check All checkbox
        const checkAllContainer = document.createElement('div');
        checkAllContainer.classList.add('form-check');

        const checkAllInput = document.createElement('input');
        checkAllInput.type = 'checkbox';
        checkAllInput.className = 'form-check-input check-all';
        checkAllInput.id = 'check-all-' + Math.random().toString(36).substring(2, 10);

        const checkAllLabel = document.createElement('label');
        checkAllLabel.htmlFor = checkAllInput.id;
        checkAllLabel.className = 'form-check-label';
        checkAllLabel.textContent = 'Check All';

        checkAllContainer.appendChild(checkAllInput);
        checkAllContainer.appendChild(checkAllLabel);

        // Add Check All checkbox to card header
        header.appendChild(checkAllContainer);

        // Add event listener to Check All checkbox
        checkAllInput.addEventListener('change', function () {
            const cardBody = header.nextElementSibling;
            const checkboxes = cardBody.querySelectorAll('.form-check-input:not(.check-all)');

            checkboxes.forEach(function (checkbox) {
                checkbox.checked = checkAllInput.checked;
            });
        });
    });

    // Update Check All checkbox state when any individual checkbox is clicked
    document.querySelectorAll('.form-check-input:not(.check-all)').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const cardBody = checkbox.closest('.card-body');
            const checkAllInput = cardBody.previousElementSibling.querySelector('.check-all');

            if (!checkAllInput) return;

            const checkboxes = cardBody.querySelectorAll('.form-check-input:not(.check-all)');
            checkAllInput.checked = Array.from(checkboxes).every(function (cb) {
                return cb.checked;
            });
        });
    });
});