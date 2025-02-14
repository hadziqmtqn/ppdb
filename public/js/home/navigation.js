function navigateToSection(event, target) {
    event.preventDefault();
    document.querySelector(target).scrollIntoView({ behavior: 'smooth' });
}