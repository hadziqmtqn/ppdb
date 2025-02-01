document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi FilePond untuk semua input file
    const inputElements = document.querySelectorAll('input[type="file"]');
    toastrOption();

    let uploadInProgress = false; // Flag untuk melacak proses upload

    // SweetAlert untuk konfirmasi penghapusan file
    document.querySelectorAll('.btn-delete-file').forEach(button => {
        button.addEventListener('click', function () {
            const username = this.dataset.username;
            const fileName = this.dataset.fileName;
            const listItem = this.closest('.list-group-item');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan file ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!',
                customClass: {
                    confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                    cancelButton: 'btn btn-label-secondary waves-effect'
                },
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/file-uploading/${username}/delete`, {
                        data: {
                            file: fileName,
                        },
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // Menandakan bahwa ini AJAX request
                        }
                    })
                        .then(response => {
                            toastr.success(response.data.message);
                            const viewButton = listItem.querySelector('a.btn-outline-secondary');
                            const removeButton = listItem.querySelector('button.btn-delete-file');
                            if (viewButton) {
                                viewButton.remove();
                            }

                            if (removeButton) {
                                removeButton.remove();
                            }
                        })
                        .catch(err => {
                            toastr.error(err.response.data.message);
                        });
                }
            });
        });
    });

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
                            toastr.success(response.data.message);

                            const inputElement = document.querySelector(`input[name="${fileName}"]`);
                            const listItem = inputElement.closest('.list-group-item');
                            let buttonGroup = listItem.querySelector('.btn-group');

                            if (!buttonGroup) {
                                buttonGroup = document.createElement('div');
                                buttonGroup.className = 'btn-group';
                                buttonGroup.setAttribute('role', 'group');
                                listItem.querySelector('.d-flex').appendChild(buttonGroup);
                            }

                            const data = response.data.data;

                            // Membuat tombol "Lihat"
                            const viewLink = document.createElement('a');
                            viewLink.href = data.fileUrl;
                            viewLink.className = 'btn btn-outline-secondary btn-xs waves-effect';
                            viewLink.target = '_blank';
                            viewLink.innerText = 'Lihat';

                            // Membuat tombol "Hapus"
                            const deleteButton = document.createElement('button');
                            deleteButton.type = 'button';
                            deleteButton.className = 'btn btn-outline-danger btn-xs waves-effect btn-delete-file';
                            deleteButton.dataset.username = username;
                            deleteButton.dataset.fileName = fileName;
                            deleteButton.innerText = 'Hapus';

                            // Menambahkan event listener untuk tombol "Hapus"
                            deleteButton.addEventListener('click', function () {
                                const username = deleteButton.dataset.username;
                                const fileName = deleteButton.dataset.fileName;
                                const listItem = deleteButton.closest('.list-group-item');

                                Swal.fire({
                                    title: 'Apakah Anda yakin?',
                                    text: "Anda tidak dapat mengembalikan file ini!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    cancelButtonText: 'TIDAK',
                                    confirmButtonText: 'YA, HAPUS!',
                                    customClass: {
                                        confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                                        cancelButton: 'btn btn-label-secondary waves-effect'
                                    },
                                    buttonsStyling: false,
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        axios.delete(`/file-uploading/${username}/delete`, {
                                            data: {
                                                file: fileName,
                                            },
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest' // Menandakan bahwa ini AJAX request
                                            }
                                        })
                                            .then(response => {
                                                toastr.success(response.data.message);
                                                const viewButton = listItem.querySelector('a.btn-outline-secondary');
                                                const removeButton = listItem.querySelector('button.btn-delete-file');
                                                if (viewButton) {
                                                    viewButton.remove();
                                                }

                                                if (removeButton) {
                                                    removeButton.remove();
                                                }
                                            })
                                            .catch(err => {
                                                toastr.error(err.response.data.message);
                                            });
                                    }
                                });
                            });

                            // Menambahkan tombol ke dalam grup tombol
                            buttonGroup.appendChild(viewLink);
                            buttonGroup.appendChild(deleteButton);

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

                    // Menggunakan Axios untuk menghapus file
                    axios.delete(`/file-uploading/${username}/delete`, {
                        data: {
                            file: fileName,
                        },
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // Menandakan bahwa ini AJAX request
                        }
                    })
                        .then(response => {
                            load(); // Menginformasikan FilePond bahwa penghapusan berhasil
                            toastr.success(response.data.message);

                            // Menghapus tombol "Lihat"
                            const inputElement = document.querySelector(`input[name="${fileName}"]`);
                            const listItem = inputElement.closest('.list-group-item');
                            const viewButton = listItem.querySelector('a.btn-outline-secondary');
                            const removeButton = listItem.querySelector('button.btn-delete-file');

                            if (viewButton) {
                                viewButton.remove();
                            }

                            if (removeButton) {
                                removeButton.remove();
                            }
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