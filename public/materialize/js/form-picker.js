/**
 * Form Picker
 */

'use strict';

(function () {
    // Flat Picker
    // --------------------------------------------------------------------
    const flatpickrDates = document.querySelectorAll('.flatpickr-date'),
        flatpickrTime = document.querySelector('#flatpickr-time'),
        flatpickrDateTime = document.querySelector('#flatpickr-datetime'),
        flatpickrMulti = document.querySelector('#flatpickr-multi'),
        flatpickrRange = document.querySelector('#flatpickr-range'),
        flatpickrInline = document.querySelector('#flatpickr-inline'),
        flatpickrFriendly = document.querySelector('#flatpickr-human-friendly'),
        flatpickrDisabledRange = document.querySelector('#flatpickr-disabled-range');

    // Date
    if (flatpickrDates.length > 0) {
        flatpickrDates.forEach((input) => {
            flatpickr(input, {
                monthSelectorType: 'static',
                locale: "id"
            });
        });
    }

    // Time
    if (flatpickrTime) {
        flatpickrTime.flatpickr({
            enableTime: true,
            noCalendar: true
        });
    }

    // Datetime
    if (flatpickrDateTime) {
        flatpickrDateTime.flatpickr({
            enableTime: true,
            dateFormat: 'Y-m-d H:i'
        });
    }

    // Multi Date Select
    if (flatpickrMulti) {
        flatpickrMulti.flatpickr({
            weekNumbers: true,
            enableTime: true,
            mode: 'multiple',
            minDate: 'today'
        });
    }

    // Inline
    if (flatpickrInline) {
        flatpickrInline.flatpickr({
            inline: true,
            allowInput: false,
            monthSelectorType: 'static'
        });
    }

    // Human Friendly
    if (flatpickrFriendly) {
        flatpickrFriendly.flatpickr({
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d'
        });
    }

    // Disabled Date Range
    if (flatpickrDisabledRange) {
        const fromDate = new Date(Date.now() - 3600 * 1000 * 48);
        const toDate = new Date(Date.now() + 3600 * 1000 * 48);

        flatpickrDisabledRange.flatpickr({
            dateFormat: 'Y-m-d',
            disable: [
                {
                    from: fromDate.toISOString().split('T')[0],
                    to: toDate.toISOString().split('T')[0]
                }
            ]
        });
    }
})();

// * Pickers with jQuery dependency (jquery)
$(function () {
    // Bootstrap Datepicker
    // --------------------------------------------------------------------
    const bsDatepickerBasic = $('#bs-datepicker-basic'),
        bsDatepickerFormat = $('#bs-datepicker-format'),
        bsDatepickerRange = $('#bs-datepicker-daterange'),
        bsDatepickerDisabledDays = $('#bs-datepicker-disabled-days'),
        bsDatepickerMultidate = $('#bs-datepicker-multidate'),
        bsDatepickerOptions = $('#bs-datepicker-options'),
        bsDatepickerAutoclose = $('#bs-datepicker-autoclose'),
        bsDatepickerInlinedate = $('#bs-datepicker-inline'),
        bsDatepicker = $('.bs-datepicker'),
        lastFiveYears = $('.datepicker-last-five-years'),
        bsDatepickerMaxToday = $('.bs-datepicker-max-today'),
        bsDatepickerYear = $('.bs-datepicker-year'),
        bsDatepickerMonth = $('.bs-datepicker-month');

    if (bsDatepicker.length) {
        bsDatepicker.each(function () {
            $(this).datepicker({
                todayHighlight: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
                language: "id",
                clearBtn: true,
                orientation: isRtl ? 'auto right' : 'auto left'
            });
        });
    }

    if (lastFiveYears.length) {
        lastFiveYears.datepicker({
            todayHighlight: false,
            autoclose: true,
            format: 'yyyy-mm-dd',
            language: "id",
            clearBtn: true,
            orientation: isRtl ? 'auto right' : 'auto left',
            endDate: new Date(new Date().setFullYear(new Date().getFullYear() - 5)), // Maksimal bisa memilih 5 tahun yang lalu
            defaultViewDate: { year: new Date().getFullYear() - 5, month: new Date().getMonth() } // Langsung diarahkan ke 5 tahun lalu
        });
    }

    if (bsDatepickerMaxToday.length) {
        bsDatepickerMaxToday.datepicker({
            todayHighlight: true,
            autoclose: true,
            format: 'yyyy-mm-dd',
            language: "id",
            clearBtn: true,
            orientation: isRtl ? 'auto right' : 'auto left',
            endDate: new Date()
        });
    }

    if (bsDatepickerYear.length) {
        bsDatepickerYear.datepicker({
            language: "id",
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose:true,
            clearBtn: true,
            orientation: isRtl ? 'auto right' : 'auto left'
        });
    }

    if (bsDatepickerMonth.length) {
        bsDatepickerMonth.datepicker({
            language: "id",
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months",
            autoclose:true,
            clearBtn: true,
            orientation: isRtl ? 'auto right' : 'auto left'
        });
    }

    // Basic
    if (bsDatepickerBasic.length) {
        bsDatepickerBasic.datepicker({
            todayHighlight: true,
            orientation: isRtl ? 'auto right' : 'auto left'
        });
    }

    // Format
    if (bsDatepickerFormat.length) {
        bsDatepickerFormat.datepicker({
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            orientation: isRtl ? 'auto right' : 'auto left'
        });
    }

    // Range
    if (bsDatepickerRange.length) {
        bsDatepickerRange.datepicker({
            todayHighlight: true,
            orientation: isRtl ? 'auto right' : 'auto left'
        });
    }

    const monthsRange = $('.bs-datepicker-months-range');
    if (monthsRange.length) {
        monthsRange.datepicker({
            todayHighlight: true,
            orientation: isRtl ? 'auto right' : 'auto left',
            minViewMode: "months",
            format: "yyyy-mm",
            language: "id",
            autoclose: true,
            // hanya pada tahun ini
            startDate: new Date(new Date().getFullYear(), 0, 1),
            endDate: new Date(new Date().getFullYear(), 11, 31)
        });
    }

    // Disabled Days
    if (bsDatepickerDisabledDays.length) {
        bsDatepickerDisabledDays.datepicker({
            todayHighlight: true,
            daysOfWeekDisabled: [0, 6],
            orientation: isRtl ? 'auto right' : 'auto left'
        });
    }

    // Multiple
    if (bsDatepickerMultidate.length) {
        bsDatepickerMultidate.datepicker({
            multidate: true,
            todayHighlight: true,
            orientation: isRtl ? 'auto right' : 'auto left'
        });
    }

    // Options
    if (bsDatepickerOptions.length) {
        bsDatepickerOptions.datepicker({
            calendarWeeks: true,
            clearBtn: true,
            todayHighlight: true,
            orientation: isRtl ? 'auto left' : 'auto right'
        });
    }

    // Auto close
    if (bsDatepickerAutoclose.length) {
        bsDatepickerAutoclose.datepicker({
            todayHighlight: true,
            autoclose: true,
            orientation: isRtl ? 'auto right' : 'auto left'
        });
    }

    // Inline picker
    if (bsDatepickerInlinedate.length) {
        bsDatepickerInlinedate.datepicker({
            todayHighlight: true
        });
    }

    // Bootstrap Daterange Picker
    // --------------------------------------------------------------------
    var bsRangePickerBasic = $('#bs-rangepicker-basic'),
        bsRangePicker = $('#bs-rangepicker'),
        bsRangePickerSingle = $('#bs-rangepicker-single'),
        bsRangePickerTime = $('#bs-rangepicker-time'),
        bsRangePickerRange = $('#bs-rangepicker-range'),
        bsRangePickerWeekNum = $('#bs-rangepicker-week-num'),
        bsRangePickerDropdown = $('#bs-rangepicker-dropdown'),
        bsRangePickerDropdownCustom = $('.bs-rangepicker-dropdown-custom');

    // Basic
    if (bsRangePickerBasic.length) {
        bsRangePickerBasic.daterangepicker({
            opens: isRtl ? 'left' : 'right'
        });
    }

    if (bsRangePicker.length) {
        bsRangePicker.daterangepicker({
            opens: isRtl ? 'left' : 'right',
            locale: {
                format: 'YYYY-MM-DD',
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                monthNames: [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ],
                firstDay: 1 // Hari pertama dalam seminggu dimulai dari Senin
            },
            autoUpdateInput: false
        });
    }

    // Single
    if (bsRangePickerSingle.length) {
        bsRangePickerSingle.daterangepicker({
            singleDatePicker: true,
            opens: isRtl ? 'left' : 'right'
        });
    }

    // Time & Date
    if (bsRangePickerTime.length) {
        bsRangePickerTime.daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY h:mm A'
            },
            opens: isRtl ? 'left' : 'right'
        });
    }

    if (bsRangePickerRange.length) {
        bsRangePickerRange.daterangepicker({
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: isRtl ? 'left' : 'right'
        });
    }

    // Week Numbers
    if (bsRangePickerWeekNum.length) {
        bsRangePickerWeekNum.daterangepicker({
            showWeekNumbers: true,
            opens: isRtl ? 'left' : 'right'
        });
    }
    // Dropdown
    if (bsRangePickerDropdown.length) {
        bsRangePickerDropdown.daterangepicker({
            showDropdowns: true,
            opens: isRtl ? 'left' : 'right'
        });
    }

    // Daterangepicker Dropdown Custom
    // tanggal indonesia format YYYY-MM-DD - YYYY-MM-DD
    // default kosong
    if (bsRangePickerDropdownCustom.length) {
        bsRangePickerDropdownCustom.daterangepicker({
            showDropdowns: true,
            opens: isRtl ? 'left' : 'right',
            locale: {
                format: 'YYYY-MM-DD',
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                monthNames: [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ],
                firstDay: 1 // Hari pertama dalam seminggu dimulai dari Senin
            },
            autoUpdateInput: false
        });
    }

    // jQuery Timepicker
    // --------------------------------------------------------------------
    var basicTimepicker = $('#timepicker-basic'),
        minMaxTimepicker = $('#timepicker-min-max'),
        disabledTimepicker = $('#timepicker-disabled-times'),
        formatTimepicker = $('#timepicker-format'),
        stepTimepicker = $('#timepicker-step'),
        altHourTimepicker = $('#timepicker-24hours');

    // Basic
    if (basicTimepicker.length) {
        basicTimepicker.timepicker({
            orientation: isRtl ? 'r' : 'l'
        });
    }

    // Min & Max
    if (minMaxTimepicker.length) {
        minMaxTimepicker.timepicker({
            minTime: '2:00pm',
            maxTime: '7:00pm',
            showDuration: true,
            orientation: isRtl ? 'r' : 'l'
        });
    }

    // Disabled Picker
    if (disabledTimepicker.length) {
        disabledTimepicker.timepicker({
            disableTimeRanges: [
                ['12am', '3am'],
                ['4am', '4:30am']
            ],
            orientation: isRtl ? 'r' : 'l'
        });
    }

    // Format Picker
    if (formatTimepicker.length) {
        formatTimepicker.timepicker({
            timeFormat: 'H:i:s',
            orientation: isRtl ? 'r' : 'l'
        });
    }

    // Steps Picker
    if (stepTimepicker.length) {
        stepTimepicker.timepicker({
            step: 15,
            orientation: isRtl ? 'r' : 'l'
        });
    }

    // 24 Hours Format
    if (altHourTimepicker.length) {
        altHourTimepicker.timepicker({
            show: '24:00',
            timeFormat: 'H:i:s',
            orientation: isRtl ? 'r' : 'l'
        });
    }
});

// color picker (pickr)
// --------------------------------------------------------------------
(function () {
    const classicPicker = document.querySelector('#color-picker-classic'),
        monolithPicker = document.querySelector('#color-picker-monolith'),
        nanoPicker = document.querySelector('#color-picker-nano');

    // classic
    if (classicPicker) {
        pickr.create({
            el: classicPicker,
            theme: 'classic',
            default: 'rgba(102, 108, 232, 1)',
            swatches: [
                'rgba(102, 108, 232, 1)',
                'rgba(40, 208, 148, 1)',
                'rgba(255, 73, 97, 1)',
                'rgba(255, 145, 73, 1)',
                'rgba(30, 159, 242, 1)'
            ],
            components: {
                // Main components
                preview: true,
                opacity: true,
                hue: true,

                // Input / output Options
                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    hsva: true,
                    cmyk: true,
                    input: true,
                    clear: true,
                    save: true
                }
            }
        });
    }

    // monolith
    if (monolithPicker) {
        pickr.create({
            el: monolithPicker,
            theme: 'monolith',
            default: 'rgba(40, 208, 148, 1)',
            swatches: [
                'rgba(102, 108, 232, 1)',
                'rgba(40, 208, 148, 1)',
                'rgba(255, 73, 97, 1)',
                'rgba(255, 145, 73, 1)',
                'rgba(30, 159, 242, 1)'
            ],
            components: {
                // Main components
                preview: true,
                opacity: true,
                hue: true,

                // Input / output Options
                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    hsva: true,
                    cmyk: true,
                    input: true,
                    clear: true,
                    save: true
                }
            }
        });
    }

    // nano
    if (nanoPicker) {
        pickr.create({
            el: nanoPicker,
            theme: 'nano',
            default: 'rgba(255, 73, 97, 1)',
            swatches: [
                'rgba(102, 108, 232, 1)',
                'rgba(40, 208, 148, 1)',
                'rgba(255, 73, 97, 1)',
                'rgba(255, 145, 73, 1)',
                'rgba(30, 159, 242, 1)'
            ],
            components: {
                // Main components
                preview: true,
                opacity: true,
                hue: true,

                // Input / output Options
                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    hsva: true,
                    cmyk: true,
                    input: true,
                    clear: true,
                    save: true
                }
            }
        });
    }
})();
