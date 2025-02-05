/**
 * Form Extras
 */

'use strict';

(function () {
    const textarea = document.querySelectorAll('.textarea-autosize'),
        creditCard = document.querySelector('.credit-card-mask'),
        phoneMask = document.querySelector('.phone-number-mask'),
        dateMask = document.querySelector('.date-mask'),
        timeMask = document.querySelector('.time-mask'),
        numeralMask = $('.numeral-mask'),
        blockMask = document.querySelector('.block-mask'),
        uppercaseMask = document.querySelector('.uppercase-mask'),
        delimiterMask = document.querySelector('.delimiter-mask'),
        customDelimiter = document.querySelector('.custom-delimiter-mask'),
        prefixMask = document.querySelector('.prefix-mask'),
        postalCodeMask = document.querySelector('.postal-code-mask'),
        numberOnly = $('.number-only'),
        phoneNumber = $('.phone-number');

    // Autosize
    // --------------------------------------------------------------------
    if (textarea) {
        //autosize(textarea);
        textarea.forEach(function (element) {
            autosize(element);
        });
    }

    // Cleave JS Input Mask
    // --------------------------------------------------------------------

    // Credit Card
    if (creditCard) {
        new Cleave(creditCard, {
            creditCard: true,
            onCreditCardTypeChanged: function (type) {
                if (type !== '' && type !== 'unknown') {
                    document.querySelector('.card-type').innerHTML =
                        '<img src="' + assetsPath + 'img/icons/payments/' + type + '-cc.png" height="28" alt="icon"/>';
                } else {
                    document.querySelector('.card-type').innerHTML = '';
                }
            }
        });
    }

    // Phone Number
    if (phoneMask) {
        new Cleave(phoneMask, {
            phone: true,
            phoneRegionCode: 'ID'
        });
    }

    // Postal Code
    if (postalCodeMask) {
        new Cleave(postalCodeMask, {
            blocks: [5],
            delimiter: '',
            numericOnly: true
        });
    }

    // Number Only
    if (numberOnly.length) { // Check if numberOnly is not empty
        numberOnly.each(function () {
            new Cleave(this, {  // Apply Cleave.js to each element
                numeral: true,
                numeralDecimalMark: '',
                delimiter: '',
                numeralPositiveOnly: true
            });
        });
    }

    // Date
    if (dateMask) {
        new Cleave(dateMask, {
            date: true,
            delimiter: '-',
            datePattern: ['Y', 'm', 'd']
        });
    }

    // Time
    if (timeMask) {
        new Cleave(timeMask, {
            time: true,
            timePattern: ['h', 'm', 's']
        });
    }

    //Numeral
    if (numeralMask.length) {
        numeralMask.each(function () {
            new Cleave(this, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });
        });
    }

    //Block
    if (blockMask) {
        new Cleave(blockMask, {
            blocks: [4, 3, 3],
            uppercase: true
        });
    }

    if (uppercaseMask) {
        new Cleave(uppercaseMask, {
            blocks: [4, 3, 3],
            uppercase: true
        });
    }

    // Delimiter
    if (delimiterMask) {
        new Cleave(delimiterMask, {
            delimiter: '·',
            blocks: [3, 3, 3],
            uppercase: true
        });
    }

    // Custom Delimiter
    if (customDelimiter) {
        new Cleave(customDelimiter, {
            delimiters: ['.', '.', '-'],
            blocks: [3, 3, 3, 2],
            uppercase: true
        });
    }

    // Prefix
    if (prefixMask) {
        new Cleave(prefixMask, {
            prefix: '+62',
            blocks: [3, 4, 4, 4],
            uppercase: true
        });
    }

    // Phone Number
    if (phoneNumber) {
        new Cleave(phoneNumber, {
            prefix: '+62',
            blocks: [3, 4, 4, 4],
        });
    }
})();

// max length
$(function () {
    const maxlengthInput = $('.maxlength');

    // Bootstrap Max Length
    // --------------------------------------------------------------------
    if (maxlengthInput.length) {
        maxlengthInput.each(function () {
            $(this).maxlength({
                warningClass: 'label label-success bg-success text-white',
                limitReachedClass: 'label label-danger',
                separator: ' dari ',
                preText: 'Mengetik ',
                postText: ' karakter tersedia',
                validate: true,
                threshold: +this.getAttribute('maxlength')
            });
        });
    }
});
