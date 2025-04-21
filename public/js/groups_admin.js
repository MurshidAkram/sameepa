document.getElementById('searchGroup').addEventListener('input', function(e) {
    const searchText = e.target.value.toLowerCase();
    const groupCards = document.querySelectorAll('.group-card');
    
    groupCards.forEach(card => {
        const groupTitle = card.querySelector('.group-title').textContent.toLowerCase();
        const groupInfo = card.querySelector('.group-info').textContent.toLowerCase();
        
        if (groupTitle.includes(searchText) || groupInfo.includes(searchText)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
});
