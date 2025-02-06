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
                            id: item.id,
                            accountName: item.accountName,
                            accountNumber: item.accountNumber
                        }
                    })
                };
            },
            cache: true
        }
    }).on('select2:select', function (e) {
        const data = e.params.data;
        const destinationBank = $('#destinationBank'),
            accountNumber = $('#accountNumber'),
            accountName = $('#accountName');

        if (destinationBank.length === 0 || accountNumber.length === 0 || accountName.length === 0) {
            return;
        }

        destinationBank.text(data.text);
        accountNumber.text(data.accountNumber);
        accountName.text(data.accountName);
    });
});