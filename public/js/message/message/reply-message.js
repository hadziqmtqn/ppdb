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

    // Fetch Pusher configuration
    const pusherConfigResponse = await axios.get('/get-pusher-config');
    const pusherConfig = pusherConfigResponse.data;

    // Pusher configuration for real-time updates
    const pusher = new Pusher(pusherConfig.key, {
        cluster: pusherConfig.cluster,
        encrypted: true
    });

    const channel = pusher.subscribe('private-conversation.' + conversationSlug);
    channel.bind('App\\Events\\MessageSent', function(data) {
        fetchData(conversationSlug);
    });
});