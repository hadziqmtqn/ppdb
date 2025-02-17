document.addEventListener('DOMContentLoaded', function () {
    const replyMessageForm = document.getElementById('replyMessageForm');
    const conversationSlug = replyMessageForm.dataset.conversation;

    toastrOption();

    if (window.Echo) {
        window.Echo.channel('conversation.' + conversationSlug)
            .listen('MessageEvent', (e) => {
                toastr.success('Ada pesan baru dari ' + e.username);

                fetchData(conversationSlug);
            });
    } else {
        console.error('Laravel Echo not initialized');
    }
})

