$(document).ready(function () {
    const toastrData = $('#toastr-data'),
        sessionSuccess = toastrData.data('session-success'),
        sessionError = toastrData.data('session-error'),
        sessionInfo = toastrData.data('session-info'),
        sessionWarning = toastrData.data('session-warning');

    toastrOption();

    if (sessionSuccess){
        toastr.success(sessionSuccess);
    }
    if (sessionError){
        toastr.error(sessionError);
    }
    if (sessionInfo){
        toastr.info(sessionInfo);
    }
    if (sessionWarning){
        toastr.warning(sessionWarning);
    }
});
