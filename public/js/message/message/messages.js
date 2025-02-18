async function fetchData(conversationSlug) {
    toastrOption();

    try {
        const response = await axios.get(`/message/${conversationSlug}`);
        if (response.data.type === 'success') {
            return response.data.data;
        } else {
            toastr.error(response.data.message);
            return [];
        }
    } catch (error) {
        toastr.error(error.response.data.message);
        return [];
    }
}

async function fetchLatestMessage(conversationSlug) {
    toastrOption();

    try {
        const response = await axios.get(`/message/${conversationSlug}/latest`);
        if (response.data.type === 'success') {
            return response.data.data;
        } else {
            toastr.error(response.data.message);
            return null;
        }
    } catch (error) {
        toastr.error(error.response.data.message);
        return null;
    }
}

function appendMessage(message, isLatest = false) {
    const replyMessages = document.getElementById('replyMessages');
    const latestBadge = isLatest ? `<div><span class="spinner-grow text-primary spinner-grow-sm me-1" role="status" aria-hidden="true"></span>Terbaru</div>` : '';
    const myMessage = message.myMessage === 'NO' ?
        `<div class="d-flex justify-content-between mb-3 read-area-button">
            ${message.isSeen ? '<span class="badge bg-label-primary">Dibaca</span>' : `<button type="button" class="btn btn-xs btn-label-secondary btn-read-message" data-slug="${message.slug}">Belum Dibaca</button>`}
        </div>` : '';

    const messageItem = `
        <li class="timeline-item ps-4 border-left-dashed" data-slug="${message.slug}">
            <div class="timeline-indicator-advanced border-0 shadow-none avatar">
                <img src="${message.avatar}" alt="Avatar" class="rounded-circle">
            </div>
            <div class="timeline-event ps-1 pt-0">
                <div class="card shadow-none bg-transparent border border-opacity-25 mb-1">
                    <div class="card-header border-bottom pt-3 pb-3 d-flex justify-content-between">
                        <div><h6 class="fw-bold mb-0"><span class="${message.nameColor}">${message.username}</span> <span class="text-muted fw-normal">on ${message.date}</span></h6></div>
                        ${latestBadge}
                    </div>
                    <div class="card-body pb-2 messages">
                        ${message.message}
                    </div>
                </div>
                ${myMessage}
            </div>
        </li>
    `;
    replyMessages.insertAdjacentHTML('afterbegin', messageItem);
}

document.addEventListener('DOMContentLoaded', async function () {
    const replyMessages = document.getElementById('replyMessages');
    const conversation = replyMessages.dataset.conversation;

    if (!replyMessages) {
        return;
    }

    // Fetch the initial set of messages
    const initialMessages = await fetchData(conversation);
    initialMessages.forEach(message => appendMessage(message));

    // Add event listener for each read button after DOM is loaded
    const btnReadMessages = document.querySelectorAll('.btn-read-message');
    btnReadMessages.forEach(function (button) {
        button.addEventListener('click', async function () {
            const slug = button.dataset.slug;
            try {
                const response = await axios.patch(`/message/${slug}/read`);
                if (response.data.type === 'success') {
                    toastr.success(response.data.message);
                    const messageElement = document.querySelector(`li[data-slug="${slug}"]`);
                    if (messageElement) {
                        const buttonContainer = messageElement.querySelector('.read-area-button');
                        if (buttonContainer) {
                            button.remove();
                            const badge = document.createElement('span');
                            badge.className = 'badge bg-label-primary';
                            badge.textContent = 'Dibaca';
                            buttonContainer.appendChild(badge);
                        }
                    }
                } else {
                    toastr.error(response.data.message);
                }
            } catch (error) {
                toastr.error(error.response.data.message);
            }
        });
    });
});