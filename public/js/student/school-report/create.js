document.addEventListener('DOMContentLoaded', function() {
    let timeoutId;
    const username = document.getElementById('username').value;

    toastrOption();

    document.querySelectorAll('.score-input').forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(timeoutId);

            const semester = this.getAttribute('data-semester');
            const lessonId = this.getAttribute('data-lesson-id');
            const score = this.value;

            timeoutId = setTimeout(async () => {
                const formData = new FormData();
                formData.append('semester', semester);
                formData.append('lesson_id', lessonId);
                formData.append('score', score);

                try {
                    const response = await axios.post(`/school-report/${username}/store`, formData);

                    if (response.data.type === 'success') {
                        toastr.success(response.data.message);
                    } else {
                        const errors = response.data.errors;
                        let message = '';
                        for (const key in errors) {
                            message += errors[key].join(', ') + '\n';
                        }
                        toastr.error(message);
                    }
                } catch (error) {
                    toastr.error(error.response.data.message);
                }
            }, 2000); // Jeda 2 detik
        });
    });
});