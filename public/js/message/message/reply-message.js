document.addEventListener('DOMContentLoaded', async function() {
    const form = document.getElementById('replyMessageForm');
    const conversationSlug = form.dataset.conversation;
    const btnReplyMessage = document.getElementById('btnReplyMessage');
    const quillEditor = document.querySelector('.quill-editor');

    if (!form || !btnReplyMessage || !quillEditor) {
        return;
    }

    btnReplyMessage.addEventListener('click', async function(event) {
        event.preventDefault();
        toastrOption();
        blockUi();

        form.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
        form.querySelectorAll('.invalid-feedback').forEach(element => {
            element.remove();
        });

        const messageTextarea = form.querySelector('textarea[name="message"]');
        const quillContent = quillEditor.__quill.root.innerHTML.trim();

        if (quillContent === '<p><br></p>' || quillContent === '') {
            toastr.error('Pesan tidak boleh kosong.');
            unBlockUi();
            return;
        }

        messageTextarea.value = quillContent;
        const formData = new FormData(form);

        try {
            const response = await axios.post(`/message/${conversationSlug}/reply-message`, formData);

            if (response.data.type === 'success') {
                toastr.success(response.data.message);
                unBlockUi();

                const newConversationElement = document.getElementById('newConversation');
                if (newConversationElement) {
                    newConversationElement.remove();
                }

                quillEditor.__quill.root.innerHTML = '';
                messageTextarea.value = '';

                // Memastikan fetchData dipanggil setelah pesan dikirim
                fetchData(conversationSlug);

                return;
            }

            const errors = response.data.errors;
            let message = '';
            for (const key in errors) {
                message += errors[key].join(', ') + '<br>';
            }
            toastr.error(message);
            unBlockUi();
        } catch (error) {
            if (error.response.status === 422) {
                const errors = error.response.data.message;
                for (const key in errors) {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        const errorMessage = document.createElement('div');
                        errorMessage.classList.add('invalid-feedback');
                        errorMessage.innerHTML = errors[key].join('<br>');
                        if (input.parentNode.classList.contains('form-floating')) {
                            input.parentNode.appendChild(errorMessage);
                        } else {
                            input.parentNode.insertBefore(errorMessage, input.nextSibling);
                        }
                    }
                }
            } else {
                toastr.error(error.response.data.message);
            }
            unBlockUi();
        }
    });

    // Menggunakan Laravel Echo untuk real-time updates
    if (window.Echo) {
        console.log('Laravel Echo ada');
        window.Echo.private('conversation.' + conversationSlug)
            .listen('MessageEvent', (e) => {
                console.log('Event received:', e);
                fetchData(conversationSlug);
            });
    } else {
        console.error('Laravel Echo not initialized');
    }
});