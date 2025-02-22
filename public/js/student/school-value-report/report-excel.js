function exportExcelHandler() {
    const exportExcelButton = document.getElementById('exportExcelButton');
    const schoolYearId = document.getElementById('select-school-year');
    const educationalInstitutionId = document.getElementById('select-educational-institution');
    const educationalGroup = document.getElementById('select-educational-group');

    if (!educationalInstitutionId || !exportExcelButton || !schoolYearId || !educationalGroup) {
        return;
    }

    exportExcelButton.addEventListener('click', async function(event) {
        event.preventDefault();
        toastrOption();
        blockUi();

        const formData = new FormData();
        formData.append('school_year_id', schoolYearId.value);
        formData.append('educational_institution_id', educationalInstitutionId.value);
        formData.append('educational_group_id', educationalGroup.value);

        try {
            const response = await axios.post('/school-value-report/export', formData, {
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
            const reader = new FileReader();
            reader.onload = function () {
                const errorMessage = JSON.parse(reader.result).message || 'Data gagal diekspor';
                toastr.error(errorMessage);
            };
            reader.readAsText(error.response.data);
        } finally {
            unBlockUi();
        }
    });
}
