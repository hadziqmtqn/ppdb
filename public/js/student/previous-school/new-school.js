document.addEventListener('DOMContentLoaded', function() {
    const createNewCheckbox = document.getElementById('createNew');
    const inputNewSchool = document.getElementById('inputNewSchool');

    function toggleNewSchoolInput() {
        if (createNewCheckbox.checked) {
            createNewCheckbox.value = "1";
            inputNewSchool.classList.remove('d-none');
            inputNewSchool.classList.add('d-block');
            $('#select-previous-school-reference').val(null).trigger('change');
        } else {
            createNewCheckbox.value = "0";
            inputNewSchool.classList.remove('d-block');
            inputNewSchool.classList.add('d-none');
        }
    }

    createNewCheckbox.addEventListener('change', toggleNewSchoolInput);

    // Initialize the state on page load
    toggleNewSchoolInput();
});