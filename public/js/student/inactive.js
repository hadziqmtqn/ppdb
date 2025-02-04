function confirmInactive(username) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Status akun akan diubah!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'TIDAK',
        confirmButtonText: 'YA!',
        customClass: {
            confirmButton: 'btn btn-warning me-3 waves-effect waves-light',
            cancelButton: 'btn btn-label-secondary waves-effect'
        },
        buttonsStyling: false,
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('inactive-form-' + username).submit();
        }
    });
}