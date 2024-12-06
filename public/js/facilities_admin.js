// Search functionality
document.getElementById('searchFacility').addEventListener('input', function(e) {
    const searchText = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.facilities-table tbody tr');
    
    rows.forEach(row => {
        const facilityName = row.cells[0].textContent.toLowerCase();
        row.style.display = facilityName.includes(searchText) ? '' : 'none';
    });
});

// Status filter
document.getElementById('statusFilter').addEventListener('change', function(e) {
    const status = e.target.value;
    const rows = document.querySelectorAll('.facilities-table tbody tr');
    
    rows.forEach(row => {
        const facilityStatus = row.cells[2].textContent.trim().toLowerCase();
        if (status === 'all' || facilityStatus === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Get modal elements
const viewModal = document.getElementById('viewFacilityModal');
const editModal = document.getElementById('editFacilityModal');
const closeButtons = document.getElementsByClassName('close');

// Close modal when clicking (x)
Array.from(closeButtons).forEach(button => {
    button.onclick = function() {
        viewModal.style.display = "none";
        editModal.style.display = "none";
    }
});

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target == viewModal || event.target == editModal) {
        viewModal.style.display = "none";
        editModal.style.display = "none";
    }
}

async function viewFacility(id) {
    try {
        const response = await fetch(`${URLROOT}/facilities/getFacilityData/${id}`);
        const facility = await response.json();
        
        // Populate modal with facility data
        document.getElementById('viewName').textContent = facility.name;
        document.getElementById('viewDescription').textContent = facility.description;
        document.getElementById('viewCapacity').textContent = facility.capacity;
        document.getElementById('viewStatus').textContent = facility.status;
        document.getElementById('viewCreator').textContent = facility.creator_name;
        
        // Show modal
        viewModal.style.display = "block";
    } catch (error) {
        console.error('Error:', error);
    }
}

async function editFacility(id) {
    try {
        const response = await fetch(`${URLROOT}/facilities/getFacilityData/${id}`);
        const facility = await response.json();
        
        // Populate form with facility data
        document.getElementById('editId').value = facility.id;
        document.getElementById('editName').value = facility.name;
        document.getElementById('editDescription').value = facility.description;
        document.getElementById('editCapacity').value = facility.capacity;
        document.getElementById('editStatus').value = facility.status;
        
        // Show modal
        editModal.style.display = "block";
    } catch (error) {
        console.error('Error:', error);
    }
}

// Handle form submission
document.getElementById('editFacilityForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const facilityId = document.getElementById('editId').value;
    const formData = {
        name: document.getElementById('editName').value,
        description: document.getElementById('editDescription').value,
        capacity: document.getElementById('editCapacity').value,
        status: document.getElementById('editStatus').value
    };

    try {
        const response = await fetch(`${URLROOT}/facilities/edit/${facilityId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const result = await response.json();
        
        if (result.success) {
            window.location.reload();
        } else {
            alert(result.message || 'Error updating facility');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error updating facility');
    }
});
