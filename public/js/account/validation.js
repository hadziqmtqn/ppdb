'use strict';
const formValidation = document.querySelector('#form');

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        if (formValidation) {
            const fv = FormValidation.formValidation(formValidation, {
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
                    current_password: {
                        validators: {
                            stringLength: {
                                min: 6,
                                message: 'Kata sandi minimal 6 karakter'
                            },
                        },
                    },
                    password: {
                        validators: {
                            callback: {
                                message: 'Kolom ini wajib diisi jika Kata Sandi sekarang diisi',
                                callback: function (input) {
                                    const currentPassword = document.querySelector('#currentPassword');

                                    if (currentPassword && currentPassword.value.trim() !== '') {
                                        return input.value.trim() !== '';
                                    }

                                    return true;
                                },
                            },
                        },
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
