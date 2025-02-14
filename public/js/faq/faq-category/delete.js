function deleteFaqCategory(slug) {
    Swal.fire({
        title: 'Peringatan!',
        text: "Apakah Anda ingin menghapus data ini?",
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
            const form = document.createElement('form');
            let token = $('meta[name="csrf-token"]').attr('content');

            form.method = 'POST';
            form.action = '/faq-category/' + slug + '/delete';
            const csrfField = document.createElement('input');
            csrfField.type = 'hidden';
            csrfField.name = '_token';
            csrfField.value = token;
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(csrfField);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    })
}