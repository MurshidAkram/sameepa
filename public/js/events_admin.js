// Search functionality
document.getElementById('searchEvents').addEventListener('input', function(e) {
    const searchText = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.events-table tbody tr');
    
    rows.forEach(row => {
        const eventName = row.cells[0].textContent.toLowerCase();
        row.style.display = eventName.includes(searchText) ? '' : 'none';
    });
});

let sortDirections = {
    0: 'asc', // Event Name
    1: 'asc', // Date
    2: 'asc', // Time
    3: 'asc', // Location
};

function sortTable(n) {
    let table = document.querySelector(".events-table");
    let rows = Array.from(table.rows).slice(1); // Convert to array, skip header
    let direction = sortDirections[n] === 'asc' ? 1 : -1;

    // Sort the rows
    rows.sort((a, b) => {
        let x = a.cells[n].textContent.trim();
        let y = b.cells[n].textContent.trim();

        switch(n) {
            case 1: // Date
                return direction * (new Date(x) - new Date(y));
            case 2: // Time
                return direction * (new Date('1970/01/01 ' + x) - new Date('1970/01/01 ' + y));
            default: // Event Name, Location, Status
                return direction * x.localeCompare(y);
        }
    });

    // Update sort direction for next click
    sortDirections[n] = sortDirections[n] === 'asc' ? 'desc' : 'asc';

    // Update arrow indicators
    let headers = table.getElementsByTagName('th');
    for(let i = 0; i < headers.length - 1; i++) {
        headers[i].textContent = headers[i].textContent.replace(/[↑↓]/, '');
        if(i === n) {
            headers[i].textContent += sortDirections[i] === 'asc' ? ' ↓' : ' ↑';
        }
    }

    // Reorder the table
    let tbody = table.getElementsByTagName('tbody')[0];
    rows.forEach(row => tbody.appendChild(row));
}
