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
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .request-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
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
            color: rgb(15, 116, 223);
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: rgb(215, 23, 42);
        }

        .request-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-view-details,
        .btn-edit-request,
        .btn-delete-request {
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
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 600px;
            animation: modalFadeIn 0.3s;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s;
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

        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            font-size: 0.95rem;
        }

        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #6a3093;
            box-shadow: 0 0 0 2px rgba(106, 48, 147, 0.2);
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn-submit {
            background: #6a3093;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s, transform 0.2s;
            width: 100%;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: #8e44ad;
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Loading spinner */
        .spinner {
            border: 3px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 3px solid #3498db;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Toast notification */
        .toast {
            visibility: hidden;
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 16px;
            position: fixed;
            z-index: 1100;
            right: 30px;
            bottom: 30px;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .toast.show {
            visibility: visible;
            animation: fadeIn 0.5s, fadeOut 0.5s 2.5s;
        }

        @keyframes fadeIn {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .modal-content {
                margin: 20% auto;
                width: 95%;
                padding: 20px;
            }

            .request-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .request-status {
                align-self: flex-end;
            }
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
                                            <span class="request-status status-<?php echo strtolower(str_replace(' ', '-', $request->status)); ?>">
                                                <?php echo htmlspecialchars($request->status); ?>
                                            </span>
                                            <span class="urgency-indicator urgency-<?php echo strtolower($request->urgency_level); ?>"></span>
                                            <span><?php echo htmlspecialchars(ucfirst($request->urgency_level)); ?></span>
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
            <p>Are you sure you want to delete this maintenance request? This action cannot be undone.</p>
            <input type="hidden" id="deleteRequestId">
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button id="confirmDeleteBtn" class="btn-submit" style="background-color: #e74c3c;">Delete</button>
                <button id="cancelDeleteBtn" class="btn-submit" style="background-color: #636e72;">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Success/Error Toast Notification -->
    <div id="toast" class="toast"></div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toast notification
            function showToast(message, isSuccess = true) {
                const toast = document.getElementById('toast');
                toast.textContent = message;
                toast.style.backgroundColor = isSuccess ? '#4CAF50' : '#f44336';
                toast.className = 'toast show';
                setTimeout(() => {
                    toast.className = toast.className.replace('show', '');
                }, 3000);
            }

            const modals = {
                newRequest: document.getElementById('newRequestModal'),
                editRequest: document.getElementById('editRequestModal'),
                deleteConfirm: document.getElementById('deleteConfirmModal')
            };

            function openModal(modal) {
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }

            function closeModal(modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }

            document.getElementById('newRequestBtn').addEventListener('click', () => {
                document.getElementById('maintenanceRequestForm').reset();
                openModal(modals.newRequest);
            });

            document.querySelectorAll('.close-modal').forEach(btn => {
                btn.addEventListener('click', function() {
                    closeModal(this.closest('.modal'));
                });
            });

            window.addEventListener('click', function(event) {
                if (event.target.classList.contains('modal')) {
                    closeModal(event.target);
                }
            });

            // Submit New Request
            document.getElementById('maintenanceRequestForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const formElements = e.target.elements;
                let isValid = true;

                document.querySelectorAll('#newRequestModal .error-message').forEach(el => el.textContent = '');

                if (!formElements.requestType.value) {
                    document.getElementById('requestType-error').textContent = 'Please select a request type';
                    isValid = false;
                }

                if (!formElements.description.value.trim()) {
                    document.getElementById('description-error').textContent = 'Please enter a description';
                    isValid = false;
                }

                if (!formElements.urgency.value) {
                    document.getElementById('urgency-error').textContent = 'Please select an urgency level';
                    isValid = false;
                }

                if (!isValid) return;

                const formData = new FormData(e.target);
                const submitBtn = e.target.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner"></span> Submitting...';

                try {
                    const response = await fetch('<?php echo URLROOT; ?>/resident/submit_request', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        showToast('Request submitted successfully!');
                        e.target.reset();
                        closeModal(modals.newRequest);
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        if (data.errors) {
                            for (const [field, message] of Object.entries(data.errors)) {
                                const errorElement = document.getElementById($ {
                                    field
                                } - error);
                                if (errorElement) errorElement.textContent = message;
                            }
                        }
                        throw new Error(data.message || 'Failed to submit request');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast(error.message || 'Failed to submit request', false);
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            });

            // Edit Request
            document.addEventListener('click', async function(e) {
                if (e.target.classList.contains('btn-edit-request')) {
                    const requestId = e.target.getAttribute('data-request-id');
                    const editBtn = e.target;
                    const originalBtnText = editBtn.innerHTML;

                    editBtn.disabled = true;
                    editBtn.innerHTML = '<span class="spinner"></span> Loading...';

                    try {
                        const response = await fetch(<?php echo URLROOT; ?> / resident / request_details / $ {
                            requestId
                        }, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });

                        if (response.redirected) {
                            window.location.href = response.url;
                            return;
                        }

                        const data = await response.json();

                        if (data.success && data.request) {
                            document.getElementById('editRequestId').value = data.request.request_id;
                            document.getElementById('editRequestType').value = data.request.type_id;
                            document.getElementById('editDescription').value = data.request.description;
                            document.getElementById('editUrgency').value = data.request.urgency_level;

                            document.querySelectorAll('#editRequestModal .error-message').forEach(el => el.textContent = '');
                            openModal(modals.editRequest);
                        } else {
                            throw new Error(data.message || 'Failed to load request details');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showToast(error.message || 'Failed to load request details', false);
                    } finally {
                        editBtn.disabled = false;
                        editBtn.innerHTML = originalBtnText;
                    }
                }
            });

            // Submit Edit
            // Submit Edit
            document.getElementById('editRequestForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const formElements = e.target.elements;
                let isValid = true;
                const fieldMap = {
                    requestType: 'RequestType',
                    description: 'Description',
                    urgency: 'Urgency'
                };

                // Clear previous errors
                document.querySelectorAll('#editRequestModal .error-message').forEach(el => el.textContent = '');

                // Validate form
                if (!formElements.requestType.value) {
                    document.getElementById('editRequestType-error').textContent = 'Please select a request type';
                    isValid = false;
                }

                if (!formElements.description.value.trim()) {
                    document.getElementById('editDescription-error').textContent = 'Please enter a description';
                    isValid = false;
                }

                if (!formElements.urgency.value) {
                    document.getElementById('editUrgency-error').textContent = 'Please select an urgency level';
                    isValid = false;
                }

                if (!isValid) return;

                const requestId = formElements.requestId.value;
                const formData = new FormData(e.target);
                const submitBtn = e.target.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner"></span> Updating...';

                try {
                    const response = await fetch(<?php echo URLROOT; ?> / resident / update_request / $ {
                        requestId
                    }, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams(formData)
                    });

                    const data = await response.json();

                    if (data.success) {
                        showToast('Request updated successfully!');
                        closeModal(modals.editRequest);
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        if (data.errors) {
                            for (const [field, message] of Object.entries(data.errors)) {
                                const key = fieldMap[field] || field;
                                const errorElement = document.getElementById(edit$ {
                                    key
                                } - error);
                                if (errorElement) errorElement.textContent = message;
                            }
                        }
                        throw new Error(data.message || 'Failed to update request');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast(error.message || 'Failed to update request', false);
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            });

            // Delete Request
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-delete-request')) {
                    const requestId = e.target.getAttribute('data-request-id');
                    document.getElementById('deleteRequestId').value = requestId;
                    openModal(modals.deleteConfirm);
                }
            });

            document.getElementById('cancelDeleteBtn').addEventListener('click', () => {
                closeModal(modals.deleteConfirm);
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
                const requestId = document.getElementById('deleteRequestId').value;
                const deleteBtn = this;
                const originalBtnText = deleteBtn.innerHTML;

                deleteBtn.disabled = true;
                deleteBtn.innerHTML = '<span class="spinner"></span> Deleting...';

                try {
                    const response = await fetch(<?php echo URLROOT; ?> / resident / delete_request / $ {
                        requestId
                    }, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            _method: 'DELETE'
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        showToast('Request deleted successfully!');
                        closeModal(modals.deleteConfirm);
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        throw new Error(data.message || 'Failed to delete request');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast(error.message || 'Failed to delete request', false);
                } finally {
                    deleteBtn.disabled = false;
                    deleteBtn.innerHTML = originalBtnText;
                }
            });
        });
    </script>
</body>

</html>