$(document).ready(function () {
    const selectEducationalInstitution = $('#select-educational-institution');

    selectEducationalInstitution.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih',
        dropdownParent: selectEducationalInstitution.parent(),
        ajax: {
            url: '/select-educational-institution',
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
