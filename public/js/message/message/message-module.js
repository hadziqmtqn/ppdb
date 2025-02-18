document.addEventListener('DOMContentLoaded', function () {
    const replyMessageForm = document.getElementById('replyMessageForm');
    if (!replyMessageForm) {
        return;
    }

    const conversationSlug = replyMessageForm.dataset.conversation;
    const authenticatedUserId = replyMessageForm.dataset.userId; // Assume user ID is available as a data attribute

    toastrOption();

    if (window.Echo) {
        window.Echo.channel('conversation.' + conversationSlug)
            .listen('MessageEvent', async (e) => {
                if (e.userId !== parseInt(authenticatedUserId)) {
                    toastr.success('Ada pesan baru dari ' + e.username);
                }

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