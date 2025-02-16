async function fetchData(conversationSlug) {
    toastrOption();

    try {
        const response = await axios.get(`/message/${conversationSlug}`);
        if (response.data.type === 'success') {
            const data = response.data.data;

            console.log(data);
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