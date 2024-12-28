function blockUi (){
    $.blockUI({
        message: '<div class="spinner-border text-white" role="status"></div>',
        timeout: 3000,
        css: {
            backgroundColor: 'transparent',
            border: '0'
        },
        overlayCSS: {
            opacity: 0.5
        }
    });
}

function unBlockUi (){
    $.unblockUI();
}
