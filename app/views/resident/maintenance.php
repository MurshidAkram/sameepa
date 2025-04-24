<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/resident_maintenance.css">
    <title>Maintenance Requests | <?php echo SITENAME; ?></title>
    <style>
        .maintenance-request-section {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }
        
        .request-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 15px;
            width: 100%;
            box-sizing: border-box;
        }
        
        .request-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .request-status {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-in-progress {
            background-color: #cce5ff;
            color:rgb(15, 116, 223);
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color:rgb(215, 23, 42);
        }
        
        .request-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        .btn-view-details, .btn-edit-request, .btn-delete-request {
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        
        .btn-view-details {
            background: #6a3093;
            color: white;
        }
        
        .btn-view-details:hover {
            background: #8e44ad;
        }
        
        .btn-edit-request {
            background: #3498db;
            color: white;
        }
        
        .btn-edit-request:hover {
            background: #2980b9;
        }
        
        .btn-delete-request {
            background: #e74c3c;
            color: white;
        }
        
        .btn-delete-request:hover {
            background: #c0392b;
        }
        
        .urgency-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }
        
        .urgency-high {
            background-color: #e74c3c;
        }
        
        .urgency-medium {
            background-color: #f39c12;
        }
        
        .urgency-low {
            background-color: #2ecc71;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            width: 80%;
            max-width: 600px;
        }
        
        .close-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close-modal:hover {
            color: #333;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-group select, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .form-group textarea {
            min-height: 100px;
        }
        
        .btn-submit {
            background: #6a3093;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }
        
        .btn-submit:hover {
            background: #8e44ad;
        }
        
        /* Loading spinner */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid #3498db;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="resident-maintenance-container">
            <div class="resident-maintenance-header">
                <h1>Maintenance Management</h1>
                <button id="newRequestBtn" class="btn-submit">Create New Request</button>
            </div>

            <div class="maintenance-request-section">
                <div class="request-history">
                    <h2>Your Maintenance Requests</h2>
                    <div id="requestsContainer">
                        <?php if (!empty($data['requests'])): ?>
                            <?php foreach ($data['requests'] as $request): ?>
                                <div class="request-card" data-request-id="<?php echo $request->request_id; ?>">
                                    <div class="request-header">
                                        <h3><?php echo htmlspecialchars($request->type); ?></h3>
                                        <div>
                                            <span class="request-status status-<?php echo strtolower($request->status); ?>">
                                                <?php echo htmlspecialchars($request->status); ?>
                                            </span>
                                            <span class="request-status status-<?php echo strtolower($request->status); ?>">
                                                <?php echo htmlspecialchars($request->urgency_level); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <p><?php echo htmlspecialchars($request->description); ?></p>
                                    <div class="request-actions">
                                        <?php if ($request->status == 'Pending'): ?>
                                            <button class="btn-edit-request" data-request-id="<?php echo $request->request_id; ?>">Edit</button>
                                            <button class="btn-delete-request" data-request-id="<?php echo $request->request_id; ?>">Delete</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No maintenance requests found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- New Request Modal -->
    <div id="newRequestModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Submit Maintenance Request</h2>
            <form id="maintenanceRequestForm">
                <div class="form-group">
                    <label for="requestType">Request Type</label>
                    <select id="requestType" name="requestType" required>
                        <option value="">Select Type</option>
                        <?php foreach ($data['types'] as $type): ?>
                            <option value="<?php echo $type->type_id; ?>"><?php echo htmlspecialchars($type->type_name); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span id="requestType-error" class="error-message"></span>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Describe the issue in detail" required></textarea>
                    <span id="description-error" class="error-message"></span>
                </div>
                <div class="form-group">
                    <label for="urgency">Urgency Level</label>
                    <select id="urgency" name="urgency" required>
                        <option value="">Select Urgency</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                    <span id="urgency-error" class="error-message"></span>
                </div>
                <button type="submit" class="btn-submit">Submit Request</button>
            </form>
        </div>
    </div>

    <!-- Edit Request Modal -->
    <div id="editRequestModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Edit Maintenance Request</h2>
            <form id="editRequestForm">
                <input type="hidden" id="editRequestId" name="requestId">
                <div class="form-group">
                    <label for="editRequestType">Request Type</label>
                    <select id="editRequestType" name="requestType" required>
                        <option value="">Select Type</option>
                        <?php foreach ($data['types'] as $type): ?>
                            <option value="<?php echo $type->type_id; ?>"><?php echo htmlspecialchars($type->type_name); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span id="editRequestType-error" class="error-message"></span>
                </div>
                <div class="form-group">
                    <label for="editDescription">Description</label>
                    <textarea id="editDescription" name="description" rows="4" required></textarea>
                    <span id="editDescription-error" class="error-message"></span>
                </div>
                <div class="form-group">
                    <label for="editUrgency">Urgency Level</label>
                    <select id="editUrgency" name="urgency" required>
                        <option value="">Select Urgency</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                    <span id="editUrgency-error" class="error-message"></span>
                </div>
                <button type="submit" class="btn-submit">Update Request</button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this maintenance request?</p>
            <input type="hidden" id="deleteRequestId">
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button id="confirmDeleteBtn" class="btn-submit" style="background-color: #e74c3c;">Delete</button>
                <button id="cancelDeleteBtn" class="btn-submit" style="background-color: #636e72;">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Success/Error Toast Notification -->
    <div id="toast" class="toast" style="display: none;"></div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal elements
        const newRequestModal = document.getElementById('newRequestModal');
        const editRequestModal = document.getElementById('editRequestModal');
        const deleteConfirmModal = document.getElementById('deleteConfirmModal');
        
        // Buttons
        const newRequestBtn = document.getElementById('newRequestBtn');
        const closeModalBtns = document.querySelectorAll('.close-modal');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        
        // Forms
        const maintenanceForm = document.getElementById('maintenanceRequestForm');
        const editRequestForm = document.getElementById('editRequestForm');
        
        // Modal functions
        function openModal(modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal(modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }

        // Show toast notification
        function showToast(message, isSuccess = true) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.style.backgroundColor = isSuccess ? '#4CAF50' : '#f44336';
            toast.style.display = 'block';
            
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }

        // Event listeners
        newRequestBtn.addEventListener('click', () => {
            maintenanceForm.reset();
            openModal(newRequestModal);
        });

        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const modal = this.closest('.modal');
                closeModal(modal);
            });
        });

        cancelDeleteBtn.addEventListener('click', () => {
            closeModal(deleteConfirmModal);
        });

        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                closeModal(event.target);
            }
        });

        // CREATE NEW REQUEST
        maintenanceForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Clear errors
            document.querySelectorAll('#newRequestModal .error-message').forEach(el => el.textContent = '');
            
            // Validate
            let isValid = true;
            const requestType = document.getElementById('requestType').value;
            const description = document.getElementById('description').value.trim();
            const urgency = document.getElementById('urgency').value;
            
            if (!requestType) {
                document.getElementById('requestType-error').textContent = 'Please select a request type';
                isValid = false;
            }
            if (!description) {
                document.getElementById('description-error').textContent = 'Please enter a description';
                isValid = false;
            }
            if (!urgency) {
                document.getElementById('urgency-error').textContent = 'Please select an urgency level';
                isValid = false;
            }
            if (!isValid) return;
            
            // Prepare data
            const formData = new FormData(this);
            
            // Loading state
            const submitBtn = maintenanceForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.textContent;
            submitBtn.innerHTML = '<div class="spinner" style="width: 20px; height: 20px;"></div>';
            submitBtn.disabled = true;
            
            try {
                // Submit request
                location.reload();
                const response = await fetch('<?php echo URLROOT; ?>/resident/submit_request', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Request submitted successfully!');
                    maintenanceForm.reset();
                    closeModal(newRequestModal);
                    
                    // Refresh the requests list
                    loadRequests();
                } else {
                    // Show validation errors
                    if (data.errors) {
                        for (const [field, message] of Object.entries(data.errors)) {
                            const errorElement = document.getElementById(`${field}-error`);
                            if (errorElement) errorElement.textContent = message;
                        }
                    }
                    throw new Error(data.message || 'Submission failed');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast(error.message || 'Failed to submit request', false);
            } finally {
                submitBtn.textContent = originalBtnText;
                submitBtn.disabled = false;
            }
        });

        // EDIT REQUEST - Event delegation for dynamically loaded edit buttons
        document.addEventListener('click', async function(e) {
            if (e.target.classList.contains('btn-edit-request')) {
                const requestId = e.target.getAttribute('data-request-id');
                
                // Loading state
                e.target.textContent = 'Loading...';
                e.target.disabled = true;
                
                try {
                    // Fetch request details
                    const response = await fetch(`<?php echo URLROOT; ?>/resident/request_details/${requestId}`);
                    const data = await response.json();
                    
                    if (data.success && data.request) {
                        const request = data.request;
                        
                        // Populate form
                        document.getElementById('editRequestId').value = request.request_id;
                        document.getElementById('editRequestType').value = request.type_id;
                        document.getElementById('editDescription').value = request.description;
                        document.getElementById('editUrgency').value = request.urgency_level;
                        
                        // Clear errors
                        document.querySelectorAll('#editRequestModal .error-message').forEach(el => {
                            el.textContent = '';
                        });
                        
                        // Show modal
                        openModal(editRequestModal);
                    } else {
                        throw new Error(data.message || 'Failed to load request');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast(error.message || 'Failed to load request details', false);
                } finally {
                    e.target.textContent = 'Edit';
                    e.target.disabled = false;
                }
            }
        });

        // EDIT FORM SUBMISSION
        editRequestForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Clear errors
            document.querySelectorAll('#editRequestModal .error-message').forEach(el => el.textContent = '');
            
            // Validate
            let isValid = true;
            const requestType = document.getElementById('editRequestType').value;
            const description = document.getElementById('editDescription').value.trim();
            const urgency = document.getElementById('editUrgency').value;

            if (!requestType) {
                document.getElementById('editRequestType-error').textContent = 'Please select a request type';
                isValid = false;
            }
            if (!description) {
                document.getElementById('editDescription-error').textContent = 'Please enter a description';
                isValid = false;
            }
            if (!urgency) {
                document.getElementById('editUrgency-error').textContent = 'Please select an urgency level';
                isValid = false;
            }
            if (!isValid) return;
            
            // Prepare data
            const formData = new FormData(this);
            const requestId = document.getElementById('editRequestId').value;
            
            // Loading state
            const submitBtn = editRequestForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.textContent;
            submitBtn.innerHTML = '<div class="spinner" style="width: 20px; height: 20px;"></div>';
            submitBtn.disabled = true;
            
            try {
                // Submit update
                const response = await fetch(`<?php echo URLROOT; ?>/resident/update_request/${requestId}`, {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Request updated successfully!');
                    closeModal(editRequestModal);
                    
                    // Refresh the requests list
                    loadRequests();
                } else {
                    // Show validation errors
                    if (data.errors) {
                        for (const [field, message] of Object.entries(data.errors)) {
                            const errorElement = document.getElementById(`edit${field.charAt(0).toUpperCase() + field.slice(1)}-error`);
                            if (errorElement) errorElement.textContent = message;
                        }
                    }
                    throw new Error(data.message || 'Update failed');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast(error.message || 'Failed to update request', false);
            } finally {
                submitBtn.textContent = originalBtnText;
                submitBtn.disabled = false;
            }
        });

      // DELETE REQUEST - Event delegation for dynamically loaded delete buttons
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-delete-request')) {
        const requestId = e.target.getAttribute('data-request-id');
        document.getElementById('deleteRequestId').value = requestId;
        openModal(deleteConfirmModal);
    }
});

// CONFIRM DELETE
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    const requestId = document.getElementById('deleteRequestId').value;
    
    // Loading state
    const button = this;
    const originalBtnText = button.textContent;
    button.innerHTML = '<div class="spinner" style="width: 20px; height: 20px;"></div>';
    button.disabled = true;
    
    fetch(`<?php echo URLROOT; ?>/resident/delete_request/${requestId}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Request deleted successfully!',
                timer: 2000,
                showConfirmButton: false
            });
            closeModal(deleteConfirmModal);
            loadRequests();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to delete request'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to delete request'
        });
    })
    .finally(() => {
        button.textContent = originalBtnText;
        button.disabled = false;
    });
});

// Function to load requests (for refreshing the list)
function loadRequests() {
    const container = document.getElementById('requestsContainer');
    container.innerHTML = '<div class="spinner"></div>';
    
    fetch('<?php echo URLROOT; ?>/resident/request_details')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.requests && data.requests.length > 0) {
                let html = '';
                data.requests.forEach(request => {
                    html += `
                        <div class="request-card" data-request-id="${request.request_id}">
                            <div class="request-header">
                                <h3>${escapeHtml(request.type)}</h3>
                                <div>
                                    <span class="request-status status-${request.status.toLowerCase()}">
                                        ${escapeHtml(request.status)}
                                    </span>
                                    <span class="urgency-level urgency-${request.urgency_level.toLowerCase()}">
                                        ${escapeHtml(request.urgency_level)}
                                    </span>
                                </div>
                            </div>
                            <p>${escapeHtml(request.description)}</p>
                            <div class="request-actions">
                                ${request.status === 'Pending' ? `
                                    <button class="btn-edit-request" data-request-id="${request.request_id}">Edit</button>
                                    <button class="btn-delete-request" data-request-id="${request.request_id}">Delete</button>
                                ` : ''}
                            </div>
                        </div>
                    `;
                });
                container.innerHTML = html;
            } else {
                container.innerHTML = '<p>No maintenance requests found.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading requests:', error);
            container.innerHTML = '<p>Error loading requests. Please try again.</p>';
        });
}

// Helper function to escape HTML
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
} });
    </script>
</body>
</html>