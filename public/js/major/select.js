$(document).ready(function () {
    const select = $('#select-major');
    const educationalInstitution = $('#select-educational-institution');

    select.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih',
        dropdownParent: select.parent(),
        ajax: {
            url: '/select-major',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    educational_institution_id: educationalInstitution.val()
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

    educationalInstitution.on('change', function() {
        select.val(null).trigger('change');
    });
});
