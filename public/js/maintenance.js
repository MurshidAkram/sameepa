// app/public/js/maintenance_requests.js

document.addEventListener('DOMContentLoaded', function() {
    const maintenanceForm = document.getElementById('maintenanceForm');
    const requestList = document.getElementById('requestList');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const closeBtn = document.getElementsByClassName('close')[0];

    let requests = JSON.parse(localStorage.getItem('maintenanceRequests')) || [];

    function renderRequests() {
        requestList.innerHTML = '';
        requests.forEach((request, index) => {
            const requestCard = document.createElement('div');
            requestCard.classList.add('request-card');
            requestCard.innerHTML = `
                <h3>${request.requestType}</h3>
                <p><strong>Description:</strong> ${request.description}</p>
                <p><strong>Urgency:</strong> ${request.urgency}</p>
                <p><strong>Status:</strong> ${request.status}</p>
                <div class="request-actions">
                    <button class="btn-edit" data-id="${index}">Edit</button>
                    <button class="btn-delete" data-id="${index}">Delete</button>
                </div>
            `;
            requestList.appendChild(requestCard);
        });

        // Add event listeners to edit and delete buttons
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', editRequest);
        });
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', deleteRequest);
        });
    }

    maintenanceForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(maintenanceForm);
        const newRequest = {
            requestType: formData.get('requestType'),
            description: formData.get('description'),
            urgency: formData.get('urgency'),
            status: 'Pending',
            date: new Date().toISOString()
        };
        requests.push(newRequest);
        localStorage.setItem('maintenanceRequests', JSON.stringify(requests));
        renderRequests();
        maintenanceForm.reset();
    });

    function editRequest(e) {
        const id = e.target.getAttribute('data-id');
        const request = requests[id];
        document.getElementById('editId').value = id;
        document.getElementById('editRequestType').value = request.requestType;
        document.getElementById('editDescription').value = request.description;
        document.getElementById('editUrgency').value = request.urgency;
        editModal.style.display = 'block';
    }

    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editId').value;
        requests[id] = {
            ...requests[id],
            requestType: document.getElementById('editRequestType').value,
            description: document.getElementById('editDescription').value,
            urgency: document.getElementById('editUrgency').value
        };
        localStorage.setItem('maintenanceRequests', JSON.stringify(requests));
        renderRequests();
        editModal.style.display = 'none';
    });

    function deleteRequest(e) {
        const id = e.target.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this request?')) {
            requests.splice(id, 1);
            localStorage.setItem('maintenanceRequests', JSON.stringify(requests));
            renderRequests();
        }
    }

    closeBtn.onclick = function() {
        editModal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == editModal) {
            editModal.style.display = 'none';
        }
    }

    renderRequests();
});