function exportExcelHandler() {
    // Tunggu hingga elemen tersedia
    const checkElement = setInterval(() => {
        const registrationStatus = document.getElementById('registrationStatus');
        if (registrationStatus) {
            clearInterval(checkElement);
            initExportExcel();
        }
    }, 500); // Cek setiap 500ms
}

function initExportExcel() {
    const exportExcelButton = document.getElementById('exportExcelButton');
    const schoolYearId = document.getElementById('select-school-year');
    const educationalInstitutionId = document.getElementById('select-educational-institution-0');
    const registrationStatus = document.getElementById('registrationStatus');
    const registrationPath = document.getElementById('select-registration-path');

    if (!educationalInstitutionId || !exportExcelButton || !schoolYearId || !registrationStatus) {
        return;
    }

    exportExcelButton.addEventListener('click', async function(event) {
        event.preventDefault();
        toastrOption();
        blockUi();

        const formData = new FormData();
        formData.append('school_year_id', schoolYearId.value);
        formData.append('educational_institution_id', educationalInstitutionId.value);
        formData.append('registration_status', registrationStatus.value);
        formData.append('registration_path_id', registrationPath.value);

        try {
            const response = await axios.post('/student-report-excel', formData, {
                responseType: 'blob' // Atur blob, tapi tangani kesalahan secara manual
            });

            if (response.status === 200) {
                const blob = new Blob([response.data], { type: response.data.type });
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;

                const contentDisposition = response.headers['content-disposition'];
                link.download = contentDisposition
                    ? contentDisposition.split('filename=')[1].replace(/"/g, '')
                    : 'export.xlsx';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                toastr.success('File berhasil diunduh');
            }

        } catch (error) {
            if (error.response && error.response.status === 422) {
                const reader = new FileReader();
                reader.onload = function () {
                    const errorMessage = JSON.parse(reader.result).message || 'Data gagal diekspor';
                    toastr.error(errorMessage);
                };
                reader.readAsText(error.response.data); // Baca blob sebagai teks
            } else {
                toastr.error(error.response?.data?.message || 'Terjadi kesalahan');
            }
        } finally {
            unBlockUi();
        }
    });
}
