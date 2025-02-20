document.addEventListener('DOMContentLoaded', function() {
    // create data
    const yesRadio = document.getElementById('yes');
    const noRadio = document.getElementById('no');
    const inputSemester = document.getElementById('inputSemester');

    function toggleSemesterInput() {
        if (yesRadio.checked) {
            inputSemester.classList.remove('d-none');
            inputSemester.classList.add('d-block');
        } else {
            inputSemester.classList.remove('d-block');
            inputSemester.classList.add('d-none');
        }
    }

    yesRadio.addEventListener('change', toggleSemesterInput);
    noRadio.addEventListener('change', toggleSemesterInput);

    // Initialize the state on page load
    toggleSemesterInput();
});