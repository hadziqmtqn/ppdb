document.addEventListener('DOMContentLoaded', function () {
    const replyMessageForm = document.getElementById('replyMessageForm');
    if (!replyMessageForm) {
        return;
    }

    const conversationSlug = replyMessageForm.dataset.conversation;

    toastrOption();

    if (window.Echo) {
        window.Echo.channel('conversation.' + conversationSlug)
            .listen('MessageEvent', async (e) => {
                toastr.success('Ada pesan baru dari ' + e.username);

                // Fetch the latest message and append it to the DOM
                const latestMessage = await fetchLatestMessage(conversationSlug);
                if (latestMessage) {
                    appendMessage(latestMessage, true);
                }
            });
    } else {
        console.error('Laravel Echo not initialized');
    }
});