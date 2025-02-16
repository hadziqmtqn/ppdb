document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('replyMessage');
    const conversationSlug = form.dataset.conversation;
    const btnReplyMessage = document.getElementById('btnReplyMessage');
    const quillEditor = document.querySelector('.quill-editor'); // Assuming this is your Quill editor container

    if (!form || !btnReplyMessage || !quillEditor) {
        return;
    }

    btnReplyMessage.addEventListener('click', async function(event) {
        event.preventDefault();
        toastrOption();
        blockUi();

        // Clear previous errors
        form.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
        form.querySelectorAll('.invalid-feedback').forEach(element => {
            element.remove();
        });

        // Update the textarea with the content of the Quill editor
        const messageTextarea = form.querySelector('textarea[name="message"]');
        const quillContent = quillEditor.__quill.root.innerHTML.trim();

        // Check if the Quill content is empty or contains only HTML tags like <p><br></p>
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

                // Clear the Quill editor and textarea
                quillEditor.__quill.root.innerHTML = '';
                messageTextarea.value = '';

                console.log(response.data);

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
                        // Add is-invalid class to the input field
                        input.classList.add('is-invalid');

                        // Create error message element
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
});