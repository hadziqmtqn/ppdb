// Tambahkan event listener pada modal
document.addEventListener('DOMContentLoaded', function () {
    // Temukan modal by id
    const modalRegister = document.getElementById('modalRegister');

    // Tambahkan event listener untuk event `hidden.bs.modal`
    modalRegister.addEventListener('hidden.bs.modal', function () {
        // Setel nilai elemen dengan id `select-class-level` menjadi null
        const selectClassLevel = document.getElementById('select-class-level');
        const selectRegistrationPath = document.getElementById('select-registration-path');
        const selectMajor = document.getElementById('select-major');

        if (selectClassLevel) {
            $(selectClassLevel).val(null).trigger('change');
        }

        if (selectRegistrationPath) {
            $(selectRegistrationPath).val(null).trigger('change');
        }

        if (selectMajor) {
            $(selectMajor).val(null).trigger('change');
        }
    });
});