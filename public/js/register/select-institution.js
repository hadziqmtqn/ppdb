document.addEventListener('DOMContentLoaded', function () {
    // Temukan semua tombol dengan data-bs-toggle="modal" dan data-bs-target="#modalRegister"
    const modalButtons = document.querySelectorAll('button[data-bs-toggle="modal"][data-bs-target="#modalRegister"]');

    // Simpan elemen #showMajors untuk referensi
    const showMajors = document.querySelector('#showMajors');
    const showMajorsContainer = document.querySelector('#showMajorsContainer');

    modalButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Ambil nilai data-id dari tombol yang diklik
            const educationalInstitutionId = this.getAttribute('data-id');
            const hasMajors = this.getAttribute('data-major');

            // Setel nilai pada input tersembunyi
            const hiddenInput = document.querySelector('#select-educational-institution');
            hiddenInput.value = educationalInstitutionId;

            // Hapus atau tambahkan kembali elemen #showMajors berdasarkan nilai hasMajors
            if (hasMajors === 'YES') {
                // Jika elemen tidak ada di dalam DOM, tambahkan kembali
                if (!showMajorsContainer.contains(showMajors)) {
                    showMajorsContainer.appendChild(showMajors);
                }
            } else {
                // Jika elemen ada di dalam DOM, hapus
                if (showMajorsContainer.contains(showMajors)) {
                    showMajors.remove();
                }
            }
        });
    });
});