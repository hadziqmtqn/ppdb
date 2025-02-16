async function fetchData(conversationSlug) {
    toastrOption();

    try {
        const response = await axios.get(`/message/${conversationSlug}`);
        if (response.data.type === 'success') {
            const data = response.data.data;
            const replyMessages = document.getElementById('replyMessages');

            // Clear existing replyMessages
            replyMessages.innerHTML = '';

            data.forEach(message => {
                const messageItem = `
                    <li class="timeline-item ps-4 border-left-dashed">
                        <div class="timeline-indicator-advanced border-0 shadow-none avatar">
                            <img src="${message.avatar}" alt="Avatar" class="rounded-circle">
                        </div>
                        <div class="timeline-event ps-1 pt-0">
                            <div class="card shadow-none bg-transparent border border-opacity-25 mb-3">
                                <h6 class="card-header fw-bold border-bottom pt-2 pb-2">
                                    ${message.username}
                                    <span class="text-muted fw-normal">on ${message.date}</span>
                                </h6>
                                <div class="card-body pb-2 messages">
                                    ${message.message}
                                </div>
                            </div>
                        </div>
                    </li>
                `;
                replyMessages.innerHTML += messageItem;
            });

            console.log(data);
        }
    } catch (error) {
        toastr.error(error.response.data.message);
    }
}

// Menambahkan event listener DOMContentLoaded
document.addEventListener('DOMContentLoaded', async function() {
    const messages = document.getElementById('replyMessages');
    const conversation = messages.dataset.conversation;

    if (!messages) {
        return;
    }

    await fetchData(conversation); // Memanggil fetchData saat halaman dibuka
});