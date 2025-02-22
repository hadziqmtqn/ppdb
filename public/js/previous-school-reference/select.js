$(document).ready(function () {
    const previousSchoolReference = $('#select-previous-school-reference'),
        selectProvince = $('#select-province'),
        selectCity = $('#select-city'),
        selectDistrict = $('#select-district'),
        selectVillage = $('#select-village');

    previousSchoolReference.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih Provinsi',
        dropdownParent: previousSchoolReference.parent(),
        ajax: {
            url: '/select-previous-school-reference',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    province: selectProvince.val(),
                    city: selectCity.val(),
                    district: selectDistrict.val(),
                    village: selectVillage.val()
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(item) {
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

    selectProvince.on('change', function() {
        previousSchoolReference.val(null).trigger('change');
    });

    selectCity.on('change', function() {
        previousSchoolReference.val(null).trigger('change');
    });

    selectDistrict.on('change', function() {
        previousSchoolReference.val(null).trigger('change');
    });
});
