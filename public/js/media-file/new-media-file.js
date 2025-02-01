document.addEventListener('DOMContentLoaded', function () {
    const createNewRadio = document.querySelectorAll('input[name="create_new"]');
    const newMediaFile = document.getElementById('newMediaFile');
    const selectMediaFile = document.getElementById('select-media-file');

    const toggleInputNewFileName = () => {
        const selectedCreateNewElement = document.querySelector('input[name="create_new"]:checked');
        if (selectedCreateNewElement) {
            const selectedNewValue = selectedCreateNewElement.value;
            if (selectedNewValue === 'YA') {
                newMediaFile.style.display = 'block';
                selectMediaFile.disabled = true; // Disable select element
            } else {
                newMediaFile.style.display = 'none';
                selectMediaFile.disabled = false; // Enable select element
            }
        } else {
            newMediaFile.style.display = 'none';
            selectMediaFile.disabled = false; // Enable select element
        }
    };

    createNewRadio.forEach(radio => {
        radio.addEventListener('change', toggleInputNewFileName);
    });

    toggleInputNewFileName();
})