function buildQueryUrl(baseUrl, params) {
    const queryString = new URLSearchParams(params).toString();
    return `${baseUrl}?${queryString}`;
}

// Mendeklarasikan fetchData di level global
async function fetchData() {
    toastrOption();

    try {
        const schoolYear = $('#select-school-year'),
            educationalInstitution = $('#select-educational-institution-0'),
            registrationCategory = $('#select-registration-category'),
            registrationPath = $('#select-registration-path');

        const url = buildQueryUrl('/student-stats', {
            school_year_id: schoolYear.val(),
            educational_institution_id: educationalInstitution.val() || '',
            registration_category_id: registrationCategory.val() || '',
            registration_path_id: registrationPath.val() || '',
        });

        const response = await axios.get(url);
        if (response.data.type === 'success') {
            const data = response.data.data;

            document.getElementById('totalStudents').textContent = data.totalStudents;
            document.getElementById('notYetValidated').textContent = data.notYetValidated;
            document.getElementById('validated').textContent = data.validated;
            document.getElementById('registrationReceived').textContent = data.registrationReceived;
            document.getElementById('notYetReceived').textContent = data.notYetReceived;
            document.getElementById('registrationRejected').textContent = data.registrationRejected;
        }
    } catch (error) {
        toastr.error(error.response.data.message);
    }
}

// Menambahkan event listener DOMContentLoaded
document.addEventListener('DOMContentLoaded', async function() {
    const schoolYear = $('#select-school-year'),
        educationalInstitution = $('#select-educational-institution'),
        registrationCategory = $('#select-registration-category'),
        registrationPath = $('#select-registration-path');

    if (schoolYear.length === 0 || educationalInstitution.length === 0 || registrationCategory.length === 0 || registrationPath.length === 0) {
        return;
    }

    // Inisialisasi select2 setelah elemen tersedia di DOM
    educationalInstitution.select2();

    //schoolYear.on('change', fetchData);
    schoolYear.on('select2:select change', function () {
        fetchData();
    });
    educationalInstitution.on('select2:select change', function() {
        fetchData();  // Panggil fetchData di sini
    });
    registrationCategory.on('select2:select change', function() {
        fetchData();  // Panggil fetchData di sini
    });
    registrationPath.on('select2:select change', function() {
        fetchData();  // Panggil fetchData di sini
    });

    await fetchData(); // Memanggil fetchData saat halaman dibuka
});