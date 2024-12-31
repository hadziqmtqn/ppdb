/**
 *  Pages Validation
 */

'use strict';
const form = document.querySelector('#form');

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        // Form validation for Add new record
        if (form) {
            const fv = FormValidation.formValidation(form, {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom ini wajib diisi'
                            },
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom ini wajib diisi'
                            },
                            emailAddress: {
                                message: 'Harap masukkan email valid'
                            }
                        }
                    },
                    whatsapp_number: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom ini wajib diisi'
                            },
                            stringLength: {
                                min: 10,
                                message: 'No. Whatsapp minimal 10 karakter'
                            }
                        }
                    },
                    is_active: {
                        validators: {
                            notEmpty: {
                                message: 'Kolom ini wajib diisi'
                            },
                        }
                    },
                    password: {
                        validators: {
                            stringLength: {
                                min: 8,
                                message: 'Kata sandi harus minimal 8 karakter unik'
                            }
                        }
                    },
                    password_confirmation: {
                        validators: {
                            identical: {
                                compare: function () {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'Konfirmasi kata sandi tidak sesuai'
                            },
                            stringLength: {
                                min: 8,
                                message: 'Konfirmasi kata sandi harus minimal 8 karakter unik'
                            }
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
