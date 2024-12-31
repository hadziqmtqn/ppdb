$(document).ready(function () {
    const selectRole = $('#select-role');

    selectRole.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih',
        dropdownParent: selectRole.parent(),
        ajax: {
            url: '/select-role',
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
