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
        }
        
        .btn-view-details:hover {
            background: #8e44ad;
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
                                <option value="plumbing">Plumbing</option>
                                <option value="electrical">Electrical</option>
                                <option value="hvac">HVAC</option>
                                <option value="appliance">Appliance Repair</option>
                                <option value="other">Other</option>
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
                            <div class="request-card">
                                <div class="request-details">
                                    <h3><?php echo htmlspecialchars($request->type); ?></h3>
                                    <p><?php echo htmlspecialchars($request->description); ?></p>
                                    <span class="request-status status-<?php echo strtolower($request->status); ?>">
                                        <?php echo htmlspecialchars($request->status); ?>
                                    </span>
                                </div>
                                <div class="request-actions">
                                    <button class="btn-view-details" data-request-id="<?php echo $request->id; ?>">View Details</button>
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

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const maintenanceForm = document.getElementById('maintenanceRequestForm');

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
                    submitBtn.textContent = 'Submitting...';
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
                            alert(data.message || 'Request submitted successfully!');
                            // Reset form
                            maintenanceForm.reset();
                            // Reload the page to show the new request
                            location.reload();
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
                                alert(data.message || 'Failed to submit request. Please try again.');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting the request. Please try again.');
                    })
                    .finally(() => {
                        // Restore button state
                        submitBtn.textContent = originalBtnText;
                        submitBtn.disabled = false;
                    });
                });
            }

            // View details functionality
            document.querySelectorAll('.btn-view-details').forEach(button => {
                button.addEventListener('click', function() {
                    const requestId = this.getAttribute('data-request-id');
                    
                    // Show loading state
                    this.textContent = 'Loading...';
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
                                // Display request details in a modal or alert
                                const details = `
                                    <h3>Request Details</h3>
                                    <p><strong>Type:</strong> ${data.request.type}</p>
                                    <p><strong>Description:</strong> ${data.request.description}</p>
                                    <p><strong>Urgency:</strong> ${data.request.urgency}</p>
                                    <p><strong>Status:</strong> ${data.request.status}</p>
                                    <p><strong>Submitted:</strong> ${new Date(data.request.created_at).toLocaleString()}</p>
                                    ${data.request.completed_at ? `<p><strong>Completed:</strong> ${new Date(data.request.completed_at).toLocaleString()}</p>` : ''}
                                `;
                                
                                // Simple alert for demo - replace with a modal in production
                                alert(details.replace(/<[^>]*>/g, ''));
                            } else {
                                alert(data.message || 'Failed to load request details');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to load request details. Please try again.');
                        })
                        .finally(() => {
                            // Restore button state
                            this.textContent = 'View Details';
                            this.disabled = false;
                        });
                });
            });
        });
    </script>
</body>
</html>