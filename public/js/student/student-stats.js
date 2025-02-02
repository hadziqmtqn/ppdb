document.addEventListener('DOMContentLoaded', async function() {
    // Menambahkan async di sini
    const schoolYear = $('#select-school-year'),
        educationalInstitution = $('#select-educational-institution'),
        registrationCategory = $('#select-registration-category'),
        registrationPath = $('#select-registration-path');

    // Memastikan elemen ditemukan
    if (schoolYear.length === 0 || educationalInstitution.length === 0 || registrationCategory.length === 0 || registrationPath.length === 0) {
        return;
    }

    // Fungsi untuk membangun URL dengan parameter query
    function buildQueryUrl(baseUrl, params) {
        const queryString = new URLSearchParams(params).toString();
        return `${baseUrl}?${queryString}`;
    }

    // Fungsi untuk mengirim permintaan ke backend
    async function fetchData() {
        toastrOption();

        try {
            // Menggunakan fungsi untuk membangun URL
            const url = buildQueryUrl('/student-stats', {
                school_year_id: schoolYear.val(),
                educational_institution_id: educationalInstitution.val() === null ? '' : educationalInstitution.val(),
                registration_category_id: registrationCategory.val() === null ? '' : registrationCategory.val(),
                registration_path_id: registrationPath.val() === null ? '' : registrationPath.val(),
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

    schoolYear.on('change', fetchData);
    educationalInstitution.on('change', fetchData);
    registrationCategory.on('change', fetchData);
    registrationPath.on('change', fetchData);

    // Memanggil fetchData saat halaman dibuka
    await fetchData(); // Menggunakan await di sini
});
