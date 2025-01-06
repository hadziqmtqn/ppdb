document.addEventListener('DOMContentLoaded', function () {
    // Temukan semua tombol dengan data-bs-toggle="modal" dan data-bs-target="#modalRegister"
    const modalButtons = document.querySelectorAll('button[data-bs-toggle="modal"][data-bs-target="#modalRegister"]');

    modalButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Ambil nilai data-id dari tombol yang diklik
            const educationalInstitutionId = this.getAttribute('data-id');

            // Setel nilai pada input tersembunyi
            const hiddenInput = document.querySelector('#select-educational-institution');
            hiddenInput.value = educationalInstitutionId;
        });
    });
});