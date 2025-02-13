'use strict';

(function () {
    // Full Toolbar
    // --------------------------------------------------------------------
    const fullToolbar = [
        [
            {
                font: []
            },
            {
                size: []
            }
        ],
        ['bold', 'italic', 'underline', 'strike'],
        [
            {
                color: []
            },
            {
                background: []
            }
        ],
        [
            {
                header: '1'
            },
            {
                header: '2'
            },
            'blockquote',
        ],
        [
            {
                list: 'ordered'
            },
            {
                list: 'bullet'
            },
        ],
        ['link'],
        ['clean']
    ];

    var quill = new Quill('.quill-editor', {
        bounds: '.quill-editor',
        placeholder: 'Type Something...',
        modules: {
            formula: true,
            toolbar: fullToolbar
        },
        theme: 'snow'
    });

    // Get the textarea element
    const textarea = document.querySelector('textarea[name="description"]');

    // Update the textarea with the content of the Quill editor
    quill.on('text-change', function () {
        textarea.value = quill.root.innerHTML;
    });

    // If there's initial content in the textarea, set it to the editor
    if (textarea.value) {
        quill.root.innerHTML = textarea.value;
    }
})();