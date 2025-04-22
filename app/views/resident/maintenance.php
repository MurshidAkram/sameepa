<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/resident_maintenance.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Maintenance Requests | <?php echo SITENAME; ?></title>
    <style>
        /* Add these styles to your resident_maintenance.css or keep them here */
        .error-message {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }
        
        .request-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
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
            color: #004085;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .btn-view-details {
            background: #6a3093;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
            margin-left: 10px;
        }
        
        .btn-view-details:hover {
            background: #8e44ad;
        }

        .btn-edit {
            background: #3498db;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn-edit:hover {
            background: #2980b9;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
            margin-left: 10px;
        }
        
        .btn-delete:hover {
            background: #c0392b;
        }

        .request-actions {
            display: flex;
            align-items: center;
        }

        .request-time {
            font-size: 0.8rem;
            color: #666;
            margin-top: 5px;
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
            width: 60%;
            max-width: 600px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .modal-title {
            font-size: 1.5rem;
            margin: 0;
        }

        .close-btn {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #333;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .btn-cancel {
            background: #95a5a6;
            margin-right: 10px;
        }

        .btn-cancel:hover {
            background: #7f8c8d;
        }

        .edit-form {
            display: none;
            margin-top: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
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
            </div>

            <div class="maintenance-request-section">
                <div class="new-request-form">
                    <h2>Submit Maintenance Request</h2>
                    <form id="maintenanceRequestForm" action="<?php echo URLROOT; ?>/resident/maintenance/submit_request" method="POST">
                        <div class="form-group">
                            <label for="requestType">Request Type</label>
                            <select id="requestType" name="requestType" required>
                                <option value="">Select Type</option>
                                <?php foreach ($data['types'] as $type): ?>
                                    <option value="<?php echo $type->type_id; ?>"><?php echo $type->type_name; ?></option>
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

                <div class="request-history">
                    <h2>Request History</h2>
                    <?php if (!empty($data['requests'])): ?>
                        <?php foreach ($data['requests'] as $request): ?>
                            <div class="request-card" id="request-<?php echo $request->request_id; ?>">
                                <div class="request-details">
                                    <h3><?php echo htmlspecialchars($request->type); ?></h3>
                                    <p><?php echo htmlspecialchars($request->description); ?></p>
                                    <span class="request-status status-<?php echo strtolower(str_replace(' ', '-', $request->status)); ?>">
                                        <?php echo htmlspecialchars($request->status); ?>
                                    </span>
                                    <div class="request-time">
                                        Submitted: <?php echo date('M j, Y g:i A', strtotime($request->created_at)); ?>
                                    </div>
                                </div>
                                <div class="request-actions">
                                    <button class="btn-view-details" data-request-id="<?php echo $request->request_id; ?>">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <?php if ($request->status == 'Pending' && strtotime($request->created_at) > strtotime('-24 hours')): ?>
                                        <button class="btn-edit" data-request-id="<?php echo $request->request_id; ?>">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn-delete" data-request-id="<?php echo $request->request_id; ?>">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No maintenance requests found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Request Details Modal -->
    <div id="requestModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Request Details</h2>
                <span class="close-btn">&times;</span>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel">Close</button>
            </div>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const maintenanceForm = document.getElementById('maintenanceRequestForm');
            const requestModal = document.getElementById('requestModal');
            const closeBtn = document.querySelector('.close-btn');
            const modalCancelBtn = document.querySelector('.btn-cancel');

            // Form submission handler
            if (maintenanceForm) {
                maintenanceForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Clear previous errors
                    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                    
                    // Get form data
                    const formData = new FormData(this);

                    // Add client-side validation if needed
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

                    // Show loading state
                    const submitBtn = maintenanceForm.querySelector('button[type="submit"]');
                    const originalBtnText = submitBtn.textContent;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
                    submitBtn.disabled = true;

                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            showAlert('success', data.message || 'Request submitted successfully!');
                            // Reset form
                            maintenanceForm.reset();
                            // Reload the page to show the new request
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            // Display validation errors
                            if (data.errors) {
                                for (const [field, message] of Object.entries(data.errors)) {
                                    const errorElement = document.getElementById(`${field}-error`);
                                    if (errorElement) {
                                        errorElement.textContent = message;
                                    }
                                }
                            } else {
                                showAlert('error', data.message || 'Failed to submit request. Please try again.');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('error', 'An error occurred while submitting the request. Please try again.');
                    })
                    .finally(() => {
                        // Restore button state
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.disabled = false;
                    });
                });
            }

            // View details functionality
            document.querySelectorAll('.btn-view-details').forEach(button => {
                button.addEventListener('click', function() {
                    const requestId = this.getAttribute('data-request-id');
                    
                    // Show loading state
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                    this.disabled = true;
                    
                    fetch(`<?php echo URLROOT; ?>/resident/maintenance/request_details/${requestId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Format the date
                                const createdAt = new Date(data.request.created_at);
                                const completedAt = data.request.completed_at ? new Date(data.request.completed_at) : null;
                                
                                // Display request details in modal
                                const modalBody = document.getElementById('modalBody');
                                modalBody.innerHTML = `
                                    <p><strong>Type:</strong> ${data.request.type}</p>
                                    <p><strong>Description:</strong> ${data.request.description}</p>
                                    <p><strong>Urgency:</strong> ${data.request.urgency_level}</p>
                                    <p><strong>Status:</strong> <span class="request-status status-${data.request.status.toLowerCase().replace(' ', '-')}">${data.request.status}</span></p>
                                    <p><strong>Submitted:</strong> ${createdAt.toLocaleString()}</p>
                                    ${completedAt ? `<p><strong>Completed:</strong> ${completedAt.toLocaleString()}</p>` : ''}
                                `;
                                
                                // Show modal
                                requestModal.style.display = 'block';
                            } else {
                                showAlert('error', data.message || 'Failed to load request details');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('error', 'Failed to load request details. Please try again.');
                        })
                        .finally(() => {
                            // Restore button state
                            this.innerHTML = '<i class="fas fa-eye"></i> View';
                            this.disabled = false;
                        });
                });
            });

            // Edit request functionality
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    const requestId = this.getAttribute('data-request-id');
                    const requestCard = document.getElementById(`request-${requestId}`);
                    const requestDetails = requestCard.querySelector('.request-details');
                    
                    // Check if edit form already exists
                    if (requestCard.querySelector('.edit-form')) {
                        requestCard.querySelector('.edit-form').remove();
                        return;
                    }
                    
                    // Get current request data
                    const type = requestDetails.querySelector('h3').textContent;
                    const description = requestDetails.querySelector('p').textContent;
                    const urgency = requestDetails.querySelector('.request-status').textContent;
                    
                    // Create edit form
                    const editForm = document.createElement('div');
                    editForm.className = 'edit-form';
                    editForm.innerHTML = `
                        <form class="edit-request-form" data-request-id="${requestId}">
                            <div class="form-group">
                                <label>Request Type</label>
                                <select name="requestType" required>
                                    <?php foreach ($data['types'] as $type): ?>
                                        <option value="<?php echo $type->type_id; ?>"><?php echo $type->type_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" rows="4" required>${description}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Urgency Level</label>
                                <select name="urgency" required>
                                    <option value="low" ${urgency === 'low' ? 'selected' : ''}>Low</option>
                                    <option value="medium" ${urgency === 'medium' ? 'selected' : ''}>Medium</option>
                                    <option value="high" ${urgency === 'high' ? 'selected' : ''}>High</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-submit">Update Request</button>
                                <button type="button" class="btn-cancel-edit">Cancel</button>
                            </div>
                        </form>
                    `;
                    
                    // Insert after request details
                    requestDetails.parentNode.insertBefore(editForm, requestDetails.nextSibling);
                    
                    // Set the current type as selected
                    const typeSelect = editForm.querySelector('select[name="requestType"]');
                    const typeOptions = Array.from(typeSelect.options);
                    const selectedOption = typeOptions.find(opt => opt.textContent === type);
                    if (selectedOption) {
                        typeSelect.value = selectedOption.value;
                    }
                    
                    // Form submission
                    const form = editForm.querySelector('form');
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const formData = new FormData(this);
                        const submitBtn = this.querySelector('button[type="submit"]');
                        const originalBtnText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                        submitBtn.disabled = true;
                        
                        fetch(`<?php echo URLROOT; ?>/resident/maintenance/update_request/${requestId}`, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                showAlert('success', data.message || 'Request updated successfully!');
                                setTimeout(() => location.reload(), 1500);
                            } else {
                                showAlert('error', data.message || 'Failed to update request');
                                if (data.errors) {
                                    console.error(data.errors);
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('error', 'An error occurred while updating the request. Please try again.');
                        })
                        .finally(() => {
                            submitBtn.innerHTML = originalBtnText;
                            submitBtn.disabled = false;
                        });
                    });
                    
                    // Cancel button
                    const cancelBtn = editForm.querySelector('.btn-cancel-edit');
                    cancelBtn.addEventListener('click', function() {
                        editForm.remove();
                    });
                });
            });

            // Delete request functionality
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const requestId = this.getAttribute('data-request-id');
                    
                    if (confirm('Are you sure you want to delete this request?')) {
                        // Show loading state
                        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
                        this.disabled = true;
                        
                        fetch(`<?php echo URLROOT; ?>/resident/maintenance/delete_request/${requestId}`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                showAlert('success', data.message || 'Request deleted successfully!');
                                // Remove the request card from UI
                                document.getElementById(`request-${requestId}`).remove();
                            } else {
                                showAlert('error', data.message || 'Failed to delete request');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('error', 'An error occurred while deleting the request. Please try again.');
                        })
                        .finally(() => {
                            this.innerHTML = '<i class="fas fa-trash"></i> Delete';
                            this.disabled = false;
                        });
                    }
                });
            });

            // Modal close handlers
            closeBtn.addEventListener('click', function() {
                requestModal.style.display = 'none';
            });

            modalCancelBtn.addEventListener('click', function() {
                requestModal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target === requestModal) {
                    requestModal.style.display = 'none';
                }
            });

            // Helper function to show alerts
            function showAlert(type, message) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type}`;
                alertDiv.textContent = message;
                
                // Position the alert (you might need to adjust this based on your layout)
                alertDiv.style.position = 'fixed';
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.padding = '15px';
                alertDiv.style.borderRadius = '5px';
                alertDiv.style.zIndex = '10000';
                
                if (type === 'success') {
                    alertDiv.style.backgroundColor = '#d4edda';
                    alertDiv.style.color = '#155724';
                    alertDiv.style.border = '1px solid #c3e6cb';
                } else {
                    alertDiv.style.backgroundColor = '#f8d7da';
                    alertDiv.style.color = '#721c24';
                    alertDiv.style.border = '1px solid #f5c6cb';
                }
                
                document.body.appendChild(alertDiv);
                
                // Remove after 3 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            }
        });
    </script>
</body>
</html>