document.addEventListener('DOMContentLoaded', function () {
    const replyMessageForm = document.getElementById('replyMessageForm');
    const conversationSlug = replyMessageForm.dataset.conversation;

    if (window.Echo) {
        console.log('Laravel Echo ada');
        window.Echo.channel('conversation.' + conversationSlug)
            .listen('MessageEvent', (e) => {
                console.log('Event received:', e);
                fetchData(conversationSlug);
            });
    } else {
        console.error('Laravel Echo not initialized');
    }
})

