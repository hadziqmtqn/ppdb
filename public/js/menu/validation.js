/**
 *  Pages Validation
 */

'use strict';
const formValidation = document.querySelector('#form');

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        if (formValidation) {
            const fv = FormValidation.formValidation(formValidation, {
                fields: {
                    serial_number: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom ini wajib diisi'
                            },
                        }
                    },
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom ini wajib diisi'
                            },
                        }
                    },
                    type: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom ini wajib diisi'
                            },
                        }
                    },
                    main_menu: {
                        validators: {
                            callback: {
                                message: 'Kolom ini wajib diisi jika Sub Menu',
                                callback: function (input) {
                                    const subMenuType = document.querySelector('#type');

                                    if (subMenuType && subMenuType.value === 'sub_menu') {
                                        return input.value.trim() !== '';
                                    }

                                    return true;
                                },
                            },
                        },
                    },
                    /*"visibility[]": {
                        validators: {
                            notEmpty: {
                                message: 'Kolom ini wajib diisi'
                            },
                        }
                    },*/
                    url: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom ini wajib diisi'
                            },
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        rowSelector: '.mb-3'
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),

                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                },
                init: instance => {
                    instance.on('plugins.message.placed', function (e) {
                        if (e.element.parentElement.classList.contains('input-group')) {
                            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                        }
                    });
                }
            });
        }
    })();
});

document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.querySelector('#type');
    const mainMenuVisibility = document.querySelector('#mainMenuVisibility');

    if (typeSelect) {
        // Inisialisasi Select2
        $(typeSelect).select2();

        // Event listener untuk Select2
        $(typeSelect).on('select2:select', function (e) {
            const selectedValue = e.params.data.id; // Mendapatkan nilai yang dipilih

            if (selectedValue === 'sub_menu') {
                // Tampilkan form "Main Menu"
                mainMenuVisibility.classList.remove('d-none');
            } else {
                // Sembunyikan form "Main Menu"
                mainMenuVisibility.classList.add('d-none');
            }
        });

        // Inisialisasi status awal (jika sudah ada nilai terpilih)
        const initialValue = typeSelect.value;
        if (initialValue === 'sub_menu') {
            mainMenuVisibility.classList.remove('d-none');
        }
    }
});
