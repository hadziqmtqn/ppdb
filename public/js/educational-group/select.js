$(document).ready(function () {
    const selectEducationalGroup = $('#select-educational-group');
    const educationalInstitutionId = $('#select-educational-institution-0');

    selectEducationalGroup.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih',
        dropdownParent: selectEducationalGroup.parent(),
        ajax: {
            url: '/select-educational-group',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    educational_institution_id: educationalInstitutionId.val()
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

    educationalInstitutionId.on('change', function () {
        selectEducationalGroup.val(null).trigger('change');
    })
});
