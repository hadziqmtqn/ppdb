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

        const div = document.createElement('div');
        div.setAttribute('data-bs-toggle', 'tooltip');
        div.setAttribute('title', category.name);

        const button = document.createElement('button');
        button.className = 'nav-link btn-white text-white waves-effect waves-light';
        button.setAttribute('data-bs-toggle', 'tab');
        button.setAttribute('data-bs-target', `#faq-category-${category.id}`);
        button.setAttribute('aria-selected', 'false');
        button.setAttribute('data-faq-category', `${category.id}`);
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
        div.appendChild(button);
        li.appendChild(div);
        faqCategoriesContainer.appendChild(li);
    });

    // Menambahkan event listener untuk kategori FAQ setelah kategori diperbarui
    const categoryButtons = document.querySelectorAll('button.nav-link[data-faq-category]');
    categoryButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const faqCategory = button.getAttribute('data-faq-category');
            const activeButton = document.querySelector('button.nav-link.active[data-educational-institution]');
            const educationalInstitutionId = activeButton ? activeButton.getAttribute('data-educational-institution') : '';
            const searchInput = document.getElementById('faqSearch').value;
            await fetchFaqs(searchInput, faqCategory, educationalInstitutionId); // Memanggil fetchFaqs saat kategori FAQ diklik
        });
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Function to fetch FAQs based on category and search term
async function fetchFaqs(search, faqCategory, educationalInstitutionId) {
    toastrOption();

    try {
        // Parse educationalInstitutionId to integer
        const educationalInstitutionIdInt = parseInt(educationalInstitutionId, 10);

        // Check if the parsed ID is a valid number
        if (isNaN(educationalInstitutionIdInt)) {
            console.log('Invalid educational institution ID');
            return;
        }

        const url = buildQueryUrl('/get-faqs', {
            search: search || '',
            faq_category_id: faqCategory, // wajib diisi
            educational_institution_id: educationalInstitutionIdInt || '',
        });

        const response = await axios.get(url);
        if (response.data.type === 'success') {
            const data = response.data.data;
            updateFaqs(data); // Update the FAQs based on the response data
        }
    } catch (error) {
        toastr.error(error.response?.data?.message || error.message);
    }
}

// Function to update the FAQs in the DOM
function updateFaqs(faqs) {
    const faqsContainer = document.getElementById('faqs');
    faqsContainer.innerHTML = ''; // Clear existing FAQs

    const categories = Array.from(new Set(faqs.map(faq => faq.faqCategory)));

    categories.forEach((category, index) => {
        const categoryFaqs = faqs.filter(faq => faq.faqCategory === category);

        const tabPane = document.createElement('div');
        tabPane.className = `tab-pane fade ${index === 0 ? 'show active' : ''}`;
        tabPane.id = `faq-category-${categoryFaqs[0].faqCategory}`;
        tabPane.setAttribute('role', 'tabpanel');

        const h5 = document.createElement('h5');
        h5.className = 'text-primary fw-bold';
        h5.textContent = category;

        const accordion = document.createElement('div');
        accordion.className = 'accordion';
        accordion.id = `accordion-${categoryFaqs[0].faqCategory}`;

        categoryFaqs.forEach((faq, key) => {
            const accordionItem = document.createElement('div');
            accordionItem.className = 'accordion-item';

            const accordionHeader = document.createElement('h2');
            accordionHeader.className = 'accordion-header';

            const button = document.createElement('button');
            button.className = `accordion-button fw-bold ${key === 0 ? '' : 'collapsed'}`;
            button.setAttribute('type', 'button');
            button.setAttribute('data-bs-toggle', 'collapse');
            button.setAttribute('aria-expanded', key === 0 ? 'true' : 'false');
            button.setAttribute('data-bs-target', `#faq-${key}`);
            button.setAttribute('aria-controls', `faq-${key}`);
            button.textContent = faq.title;

            const accordionCollapse = document.createElement('div');
            accordionCollapse.id = `faq-${key}`;
            accordionCollapse.className = `accordion-collapse collapse ${key === 0 ? 'show' : ''}`;

            const accordionBody = document.createElement('div');
            accordionBody.className = 'accordion-body';
            accordionBody.innerHTML = faq.description;

            accordionCollapse.appendChild(accordionBody);
            accordionHeader.appendChild(button);
            accordionItem.appendChild(accordionHeader);
            accordionItem.appendChild(accordionCollapse);
            accordion.appendChild(accordionItem);
        });

        tabPane.appendChild(h5);
        tabPane.appendChild(accordion);
        faqsContainer.appendChild(tabPane);
    });

    // Initialize collapses
    const collapseTriggerList = [].slice.call(document.querySelectorAll('.accordion-button'));
    collapseTriggerList.map(function (collapseTriggerEl) {
        return new bootstrap.Collapse(collapseTriggerEl);
    });
}

// Menambahkan event listener DOMContentLoaded
document.addEventListener('DOMContentLoaded', async function() {
    const activeButton = document.querySelector('button.nav-link.active[data-educational-institution]');

    if (activeButton) {
        const educationalInstitutionId = activeButton.getAttribute('data-educational-institution');
        await fetchData(educationalInstitutionId); // Memanggil fetchData saat halaman dibuka

        // Memanggil fetchFaqs saat halaman dibuka dengan kategori pertama
        const firstCategoryButton = document.querySelector('button.nav-link[data-faq-category]');
        if (firstCategoryButton) {
            const faqCategory = firstCategoryButton.getAttribute('data-faq-category');
            await fetchFaqs('', faqCategory, educationalInstitutionId);
        }
    }

    // Menambahkan event listener untuk menangani klik pada tombol
    const navButtons = document.querySelectorAll('button.nav-link[data-educational-institution]');
    navButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const educationalInstitutionId = button.getAttribute('data-educational-institution');
            await fetchData(educationalInstitutionId); // Memanggil fetchData saat tombol diklik

            // Memanggil fetchFaqs saat tombol diklik dengan kategori pertama
            const firstCategoryButton = document.querySelector('button.nav-link[data-faq-category]');
            if (firstCategoryButton) {
                const faqCategory = firstCategoryButton.getAttribute('data-faq-category');
                const searchInput = document.getElementById('faqSearch').value;
                await fetchFaqs(searchInput, faqCategory, educationalInstitutionId);
            }
        });
    });

    // Event listener untuk search input
    const searchInput = document.getElementById('faqSearch');
    searchInput.addEventListener('input', async function() {
        const search = searchInput.value;
        if (search.length >= 3) {
            const activeButton = document.querySelector('button.nav-link.active[data-educational-institution]');
            const educationalInstitutionId = activeButton ? activeButton.getAttribute('data-educational-institution') : '';
            const activeCategoryButton = document.querySelector('button.nav-link.active[data-faq-category]');
            const faqCategory = activeCategoryButton ? activeCategoryButton.getAttribute('data-faq-category') : '';
            await fetchFaqs(search, faqCategory, educationalInstitutionId); // Memanggil fetchFaqs saat input search berubah
        } else {
            toastr.warning('Minimal 3 karakter pencarian');
        }
    });
});