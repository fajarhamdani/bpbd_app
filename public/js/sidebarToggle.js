const sidebarToggle = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
const header = document.getElementById('header');
const hamburger = document.querySelector('.hamburger');

// Toggle sidebar visibility
sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    mainContent.classList.toggle('shifted');
    header.classList.toggle('shifted');
    hamburger.classList.toggle('open');
});
