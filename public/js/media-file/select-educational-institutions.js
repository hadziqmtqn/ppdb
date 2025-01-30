document.addEventListener('DOMContentLoaded', function () {
    const categoryRadios = document.querySelectorAll('input[name="category"]');
    const educationalInstitutionsWrapper = document.getElementById('educational-institutions-wrapper');

    const toggleEducationalInstitutions = () => {
        const selectedCategoryElement = document.querySelector('input[name="category"]:checked');
        if (selectedCategoryElement) {
            const selectedCategory = selectedCategoryElement.value;
            if (selectedCategory === 'unit_tertentu') {
                educationalInstitutionsWrapper.style.display = 'block';
            } else {
                educationalInstitutionsWrapper.style.display = 'none';
            }
        } else {
            educationalInstitutionsWrapper.style.display = 'none';
        }
    };

    // Attach change event to category radios
    categoryRadios.forEach(radio => {
        radio.addEventListener('change', toggleEducationalInstitutions);
    });

    // Initialize the visibility of educational institutions select
    toggleEducationalInstitutions();
})