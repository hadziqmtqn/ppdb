$(document).ready(function () {
    const selectProvince = $('#select-province'),
        selectCity = $('#select-city'),
        selectDistrict = $('#select-district'),
        selectVillage = $('#select-village');

    selectProvince.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih Provinsi',
        dropdownParent: selectProvince.parent(),
        ajax: {
            url: 'https://idn-location.bkn.my.id/api/v1/provinces',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.name
                        }
                    })
                };
            },
            cache: true
        }
    });

    selectCity.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih Kota/Kabupaten',
        dropdownParent: selectCity.parent(),
        ajax: {
            url: 'https://idn-location.bkn.my.id/api/v1/cities',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    province: selectProvince.val(),
                    q: params.term
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.name
                        }
                    })
                };
            },
            cache: true
        }
    });

    selectDistrict.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih Kecamatan',
        dropdownParent: selectDistrict.parent(),
        ajax: {
            url: 'https://idn-location.bkn.my.id/api/v1/districts',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    city: selectCity.val(),
                    q: params.term
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.name
                        }
                    })
                };
            },
            cache: true
        }
    });

    selectVillage.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Pilih Kelurahan/Desa',
        dropdownParent: selectVillage.parent(),
        ajax: {
            url: 'https://idn-location.bkn.my.id/api/v1/villages',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    district: selectDistrict.val(),
                    q: params.term
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.name
                        }
                    })
                };
            },
            cache: true
        }
    });

    selectProvince.on('change', function() {
        selectCity.val(null).trigger('change');
    });

    selectCity.on('change', function() {
        selectDistrict.val(null).trigger('change');
    });

    selectDistrict.on('change', function() {
        selectVillage.val(null).trigger('change');
    });
});
