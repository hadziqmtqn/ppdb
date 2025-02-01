$(document).ready(function () {
    const select = $('#select-media-file');

    select.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih',
        dropdownParent: select.parent(),
        ajax: {
            url: '/select-media-file',
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
