// sidebar.js
document.addEventListener('DOMContentLoaded', function() {
    const sidebarLinks = document.querySelectorAll('aside ul li a');

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Remove the 'active' class from all links
            sidebarLinks.forEach(link => link.classList.remove('active'));
            // Add the 'active' class to the clicked link
            this.classList.add('active');
        });
    });
});
