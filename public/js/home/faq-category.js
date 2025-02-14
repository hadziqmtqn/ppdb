// JavaScript

function buildQueryUrl(baseUrl, params) {
    const queryString = new URLSearchParams(params).toString();
    return `${baseUrl}?${queryString}`;
}

// Mendeklarasikan fetchData di level global
async function fetchData(educationalInstitutionId) {
    toastrOption();

    try {
        // Parse educationalInstitutionId to integer
        const educationalInstitutionIdInt = parseInt(educationalInstitutionId, 10);

        // Check if the parsed ID is a valid number
        if (isNaN(educationalInstitutionIdInt)) {
            console.log('Invalid educational institution ID');
            return;
        }

        const url = buildQueryUrl('/get-faq-categories', {
            educational_institution_id: educationalInstitutionIdInt,
        });

        const response = await axios.get(url);
        if (response.data.type === 'success') {
            const data = response.data.data;
            updateFaqCategories(data);  // Update the FAQ categories based on the response data
        }
    } catch (error) {
        toastr.error(error.response?.data?.message || error.message);
    }
}

// Function to update the FAQ categories in the DOM
function updateFaqCategories(categories) {
    const faqCategoriesContainer = document.querySelector('#faqCategories .nav');
    faqCategoriesContainer.innerHTML = ''; // Clear existing categories

    categories.forEach((category, index) => {
        const li = document.createElement('li');
        li.className = 'nav-item';
        li.setAttribute('role', 'presentation');

        const button = document.createElement('button');
        button.className = 'nav-link btn-white text-white waves-effect waves-light';
        button.setAttribute('data-bs-toggle', 'tab');
        button.setAttribute('data-bs-target', `#faq-category-${category.id}`);
        button.setAttribute('aria-selected', 'false');
        button.setAttribute('role', 'tab');

        // Add 'active' class to the first button
        if (index === 0) {
            button.classList.add('active');
            button.setAttribute('aria-selected', 'true');
        }

        const icon = document.createElement('i');
        icon.className = 'mdi mdi-check me-1';

        const span = document.createElement('span');
        span.className = 'align-middle';
        span.textContent = category.name;

        button.appendChild(icon);
        button.appendChild(span);
        li.appendChild(button);
        faqCategoriesContainer.appendChild(li);
    });
}

// Menambahkan event listener DOMContentLoaded
document.addEventListener('DOMContentLoaded', async function() {
    const activeButton = document.querySelector('button.nav-link.active[data-educational-institution]');

    if (activeButton) {
        const educationalInstitutionId = activeButton.getAttribute('data-educational-institution');
        await fetchData(educationalInstitutionId); // Memanggil fetchData saat halaman dibuka
    }

    // Menambahkan event listener untuk menangani klik pada tombol
    const navButtons = document.querySelectorAll('button.nav-link[data-educational-institution]');
    navButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const educationalInstitutionId = button.getAttribute('data-educational-institution');
            await fetchData(educationalInstitutionId); // Memanggil fetchData saat tombol diklik
        });
    });
});