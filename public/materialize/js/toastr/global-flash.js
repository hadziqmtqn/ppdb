function toastrOption(){
    toastr.options = {
        maxOpened: 1,
        autoDismiss: true,
        closeButton: false,
        progressBar: false,
        positionClass: 'toast-top-right',
        onclick: null,
        timeOut: 5000,
        showDuration: false,
        hideDuration: true,
        extendedTimeOut: true,
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut',
        tapToDismiss: false,
        rtl: $('html').attr('dir') === 'rtl'
    };
}
