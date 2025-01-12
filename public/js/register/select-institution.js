document.addEventListener('DOMContentLoaded', function () {
    // Temukan semua tombol dengan data-bs-toggle="modal" dan data-bs-target="#modalRegister"
    const modalButtons = document.querySelectorAll('button[data-bs-toggle="modal"][data-bs-target="#modalRegister"]');

    // registration path container
    const registrationPathsContainer = document.querySelector('#registrationPathsContainer'),
        showRegistrationPaths = document.querySelector('#showRegistrationPaths');

    // Simpan elemen #showMajors untuk referensi
    const showMajors = document.querySelector('#showMajors'),
        showMajorsContainer = document.querySelector('#showMajorsContainer');

    // NISN wajib diisi
    const showNisnContainer = document.querySelector('#showNisnContainer'),
        showNisn = document.querySelector('#showNisn');

    modalButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Ambil nilai data-id dari tombol yang diklik
            const educationalInstitutionId = this.getAttribute('data-id');
            const educationName = this.getAttribute('data-education-name');
            const hasRegistrationPath = this.getAttribute('data-registration-path');
            const hasMajors = this.getAttribute('data-major');
            const nisnIsRequired = this.getAttribute('data-nisn-is-required');

            // Setel nilai pada input tersembunyi
            const hiddenInput = document.querySelector('#select-educational-institution');
            hiddenInput.value = educationalInstitutionId;

            // education name
            const education = document.querySelector('#educationName');
            education.value = educationName;

            // input has registration path
            const hasRegistrationPathInput = document.querySelector('#hasRegistrationPath');
            hasRegistrationPathInput.value = hasRegistrationPath;

            // input has major
            const hasMajorInput = document.querySelector('#hasMajor');
            hasMajorInput.value = hasMajors;

            const nisnIsRequiredInput = document.querySelector('#nisnIsRequired');
            nisnIsRequiredInput.value = nisnIsRequired;

            // Hapus atau tambahkan kembali elemen #showRegistrationPaths
            if (hasRegistrationPath === 'YES') {
                // Jika elemen tidak ada di dalam DOM, tambahkan kembali
                if (!registrationPathsContainer.contains(showRegistrationPaths)) {
                    registrationPathsContainer.appendChild(showRegistrationPaths);
                }
            } else {
                // Jika elemen ada di dalam DOM, hapus
                if (registrationPathsContainer.contains(showRegistrationPaths)) {
                    showRegistrationPaths.remove();
                }
            }

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

            // Hapus atau tambahkan kembali elemen #showNisn berdasarkan nilai nisnIsRequired
            if (nisnIsRequired === 'YES') {
                // Jika elemen tidak ada di dalam DOM, tambahkan kembali
                if (!showNisnContainer.contains(showNisn)) {
                    showNisnContainer.appendChild(showNisn);
                }
            } else {
                // Jika elemen ada di dalam DOM, hapus
                if (showNisnContainer.contains(showNisn)) {
                    showNisn.remove();
                }
            }
        });
    });
});