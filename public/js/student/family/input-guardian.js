document.addEventListener('DOMContentLoaded', function() {
    const yesRadio = document.getElementById('yes');
    const noRadio = document.getElementById('no');
    const inputGuardian = document.getElementById('inputGuardian');

    function toggleGuardianInput() {
        if (yesRadio.checked) {
            inputGuardian.classList.remove('d-none');
            inputGuardian.classList.add('d-block');
        } else {
            inputGuardian.classList.remove('d-block');
            inputGuardian.classList.add('d-none');
        }
    }

    yesRadio.addEventListener('change', toggleGuardianInput);
    noRadio.addEventListener('change', toggleGuardianInput);

    // Initialize the state on page load
    toggleGuardianInput();
});