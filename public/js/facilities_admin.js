// Search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchFacility');
    const statusFilter = document.getElementById('statusFilter');
    const viewModal = document.getElementById('viewFacilityModal');
    const editModal = document.getElementById('editFacilityModal');
    const closeButtons = document.getElementsByClassName('close');
    const editFacilityForm = document.getElementById('editFacilityForm');

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchText = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.facilities-table tbody tr');
            
            rows.forEach(row => {
                const facilityName = row.cells[0].textContent.toLowerCase();
                row.style.display = facilityName.includes(searchText) ? '' : 'none';
            });
        });
    }

    // Status
    if (statusFilter) {
        statusFilter.addEventListener('change', function(e) {
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
    }

    if (viewModal && editModal) {
        Array.from(closeButtons).forEach(button => {
            button.onclick = function() {
                viewModal.style.display = "none";
                editModal.style.display = "none";
            }
        });

        window.onclick = function(event) {
            if (event.target == viewModal || event.target == editModal) {
                viewModal.style.display = "none";
                editModal.style.display = "none";
            }
        }
    }

    if (editFacilityForm) {
        editFacilityForm.addEventListener('submit', async (e) => {
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
    }
});

async function editFacility(id) {
    try {
        const response = await fetch(`${URLROOT}/facilities/getFacilityData/${id}`);
        const facility = await response.json();
        
        const editModal = document.getElementById('editFacilityModal');
        const editId = document.getElementById('editId');
        const editName = document.getElementById('editName');
        const editDescription = document.getElementById('editDescription');
        const editCapacity = document.getElementById('editCapacity');
        const editStatus = document.getElementById('editStatus');

        if (editModal && editId && editName && editDescription && editCapacity && editStatus) {
            editId.value = facility.id;
            editName.value = facility.name;
            editDescription.value = facility.description;
            editCapacity.value = facility.capacity;
            editStatus.value = facility.status;
            
            // Show modal
            editModal.style.display = "block";
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
