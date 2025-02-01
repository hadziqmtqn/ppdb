document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi FilePond untuk semua input file
    const inputElements = document.querySelectorAll('input[type="file"]');
    //const datatable = $('#datatable');
    toastrOption();

    let uploadInProgress = false; // Flag untuk melacak proses upload

    inputElements.forEach(inputElement => {
        const fileName = inputElement.name; // Mendapatkan nama file

        // Menginisialisasi FilePond dengan pengaturan manual untuk upload via Axios
        FilePond.create(inputElement, {
            acceptedFileTypes: ['image/jpeg', 'image/png', 'application/pdf'],
            labelIdle: 'Seret dan jatuhkan file Anda atau <span class="filepond--label-action">Telusuri</span>',
            labelFileProcessing: 'Mengunggah',
            labelFileProcessingComplete: 'Pengunggahan selesai',
            labelFileProcessingAborted: 'Pengunggahan dibatalkan',
            labelFileProcessingError: 'Terjadi kesalahan saat mengunggah',
            labelTapToCancel: 'Ketuk untuk membatalkan',
            labelTapToRetry: 'Ketuk untuk mencoba lagi',
            labelTapToUndo: 'Ketuk untuk mengurungkan',
            labelFileTypeNotAllowed: 'File yang diunggah tidak valid',
            fileValidateTypeLabelExpectedTypes: 'Tipe file yang diharapkan: {allButLastType}, atau {lastType}',

            // Menangani event proses upload secara manual menggunakan Axios
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort) => {
                    uploadInProgress = true; // Set flag ketika proses upload dimulai

                    // Membuat FormData
                    const formData = new FormData();
                    formData.append(fieldName, file);

                    // Mendapatkan username dari form
                    const username = document.getElementById('form').dataset.username;

                    // Menambahkan data dari input hidden (school_year_id) ke FormData
                    /*const schoolYear = document.getElementById('schoolYear').value;
                    formData.append('school_year_id', schoolYear);*/

                    // Menggunakan Axios untuk upload file beserta form data lainnya
                    axios.post(`/file-uploading/${username}/store`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-Requested-With': 'XMLHttpRequest' // Menandakan bahwa ini AJAX request
                        },
                        onUploadProgress: (e) => {
                            // Melacak progress upload
                            progress(e.lengthComputable, e.loaded, e.total);
                        }
                    })
                        .then(response => {
                            load(response.data.fileId); // Memberitahu FilePond bahwa upload sukses
                            //datatable.DataTable().ajax.reload();
                            toastr.success(response.data.message);
                            uploadInProgress = false; // Set flag ketika proses upload selesai
                        })
                        .catch(err => {
                            toastr.error(err.response.data.message);
                            uploadInProgress = false; // Set flag ketika upload gagal
                        });

                    // Mengembalikan fungsi abort jika diperlukan
                    return {
                        abort: () => {
                            abort(); // Memberitahu FilePond bahwa upload dibatalkan
                            uploadInProgress = false; // Set flag ketika upload dibatalkan
                        }
                    };
                },
                // Menambahkan endpoint untuk menghapus file
                revert: (uniqueFileId, load, error) => {
                    // Mendapatkan username dari form
                    const username = document.getElementById('form').dataset.username;
                    //const schoolYear = document.getElementById('schoolYear').value;

                    // Menggunakan Axios untuk menghapus file
                    axios.delete(`/file-uploading/${username}/delete`, {
                        data: {
                            file: fileName,
                            //school_year_id: schoolYear
                        },
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // Menandakan bahwa ini AJAX request
                        }
                    })
                        .then(response => {
                            load(); // Menginformasikan FilePond bahwa penghapusan berhasil
                            //datatable.DataTable().ajax.reload();
                            toastr.success(response.data.message);
                        })
                        .catch(err => {
                            toastr.error(err.response.data.message);
                        });
                }
            },
            instantUpload: true, // Upload otomatis begitu file dipilih
        });
    });

    // Menambahkan event beforeunload untuk mencegah berpindah halaman saat upload sedang berlangsung
    window.addEventListener('beforeunload', function(e) {
        if (uploadInProgress) {
            const confirmationMessage = "Proses upload masih berjalan. Apakah Anda yakin ingin meninggalkan halaman ini?";
            e.returnValue = confirmationMessage; // Standar untuk beberapa browser
            return confirmationMessage; // Standar untuk browser lain
        }
    });
});
