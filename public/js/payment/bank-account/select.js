$(document).ready(function () {
    const select = $('#select-bank-account');
    const educationalInstitution = select.data('educational-institution');

    select.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih',
        dropdownParent: select.parent(),
        ajax: {
            url: '/select-bank-account',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    educational_institution_id: educationalInstitution
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data, function(item) {
                        return {
                            text: item.paymentChannel,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
});
