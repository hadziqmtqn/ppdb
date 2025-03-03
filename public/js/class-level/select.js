$(document).ready(function () {
    const select = $('#select-class-level');
    const educationalInstitution = $('#select-educational-institution');
    const registrationCategory = $('#select-registration-category');

    select.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih',
        dropdownParent: select.parent(),
        ajax: {
            url: '/select-class-level',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    educational_institution_id: educationalInstitution.val(),
                    registration_category_id: registrationCategory.val()
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

    registrationCategory.on('change', function() {
        select.val(null).trigger('change');
    });
});
