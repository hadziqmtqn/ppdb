$(document).ready(function () {
    function initializeSelectEducationalInstitution(element, url) {
        element.wrap('<div class="position-relative"></div>').select2({
            placeholder: 'Pilih',
            dropdownParent: element.parent(),
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function(item) {
                            return {
                                text: item.name,
                                id: item.id,
                            }
                        })
                    };
                },
                cache: true
            }
        });
    }

    // Looping untuk semua elemen dengan ID yang sama menggunakan indeks untuk ID unik
    $('[id="select-educational-institution"]').each(function (index) {
        const element = $(this);
        const uniqueId = 'select-educational-institution-' + index; // Membuat ID unik berdasarkan indeks
        element.attr('id', uniqueId); // Mengubah ID elemen
        initializeSelectEducationalInstitution(element, '/select-educational-institution');
    });
});
