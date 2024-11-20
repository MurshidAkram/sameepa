// app/public/js/announcements.js

document.addEventListener('DOMContentLoaded', function() {
    const reactionButtons = document.querySelectorAll('.btn-react');

    reactionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const announcementId = this.dataset.announcementId;
            const isLike = this.classList.contains('btn-like');
            const countSpan = this.querySelector('span');
            let count = parseInt(countSpan.textContent);

            // Toggle the reaction (in a real app, you'd send this to the server)
            count = this.classList.toggle('active') ? count + 1 : count - 1;
            countSpan.textContent = count;

            // Here you would typically send an AJAX request to update the server
            console.log(`Announcement ${announcementId} ${isLike ? 'liked' : 'disliked'}`);
        });
    });
});