$(document).ready(function () {
    const select = $('#select-message-user');
    const selectEducationId = select.data('education-id');
    const educationalInstitution = $('#select-educational-institution-' + selectEducationId);

    select.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih',
        dropdownParent: select.parent(),
        ajax: {
            url: '/select-message-user',
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
