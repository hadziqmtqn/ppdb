$(document).ready(function () {
    const selectSchoolYear = $('#select-school-year');

    selectSchoolYear.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih',
        dropdownParent: selectSchoolYear.parent(),
        ajax: {
            url: '/select-school-year',
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
                            text: item.year,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
});
