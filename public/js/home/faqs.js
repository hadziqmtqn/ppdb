function buildQueryUrl(baseUrl, params) {
    const queryString = new URLSearchParams(params).toString();
    return `${baseUrl}?${queryString}`;
}

// Mendeklarasikan fetchData di level global
async function fetchData() {
    toastrOption();

    try {
        const educationalInstitution = $('#educational-institution');

        const url = buildQueryUrl('/get-faqs', {
            educational_institution_id: educationalInstitution.val() || '',
        });

        const response = await axios.get(url);
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
    const educationalInstitution = $('#educational-institution');

    if (educationalInstitution.length === 0) {
        return;
    }

    await fetchData(); // Memanggil fetchData saat halaman dibuka
});