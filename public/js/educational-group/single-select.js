$(document).ready(function () {
    const selectEducationalGroup = $('#select-educational-group');

    selectEducationalGroup.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih',
        dropdownParent: selectEducationalGroup.parent(),
        ajax: {
            url: '/select-educational-group/single-select',
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
