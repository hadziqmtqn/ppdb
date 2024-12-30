$(document).ready(function () {
    const selectEducationalLevel = $('#select-educational-level');

    selectEducationalLevel.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih',
        dropdownParent: selectEducationalLevel.parent(),
        ajax: {
            url: '/select-educational-level',
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
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
});
