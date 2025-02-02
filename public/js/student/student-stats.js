document.addEventListener('DOMContentLoaded', async function() { // Menambahkan async di sini
    const schoolYear = $('#select-school-year');
    const educationalInstitution = $('#select-educational-institution');

    // Memastikan elemen ditemukan
    if (schoolYear.length === 0 || educationalInstitution.length === 0) {
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
                educational_institution_id: educationalInstitution.val() === null ? '' : educationalInstitution.val()
            });

            const response = await axios.post(url);
            if (response.data.type === 'success') {
                const data = response.data.data;

                document.getElementById('totalStudents').textContent = data.totalStudents;
            }
        } catch (error) {
            toastr.error(error.response.data.message);
        }
    }

    // Event listener untuk perubahan pada select tahun ajaran
    schoolYear.on('change', fetchData); // Menggunakan jQuery untuk menambahkan event listener

    // Event listener untuk perubahan pada select lembaga pendidikan
    educationalInstitution.on('change', fetchData); // Menggunakan jQuery untuk menambahkan event listener

    // Memanggil fetchData saat halaman dibuka
    await fetchData(); // Menggunakan await di sini
});
