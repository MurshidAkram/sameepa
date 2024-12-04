<!-- app/views/resident/maintenance_requests.php -->
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
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="resident-maintenance-container">
            <div class="resident-maintenance-header">
                <h1>Maintenance Management</h1>
                <!--                 <a href="<?php echo URLROOT; ?>/resident/maintenance" class="btn-create-request">Create New Request</a>
 -->
            </div>

            <div class="maintenance-stats">
                <div class="maintenance-stat-card">
                    <h3>Total Requests</h3>
                    <p><?php echo $data['total_requests'] ?? 0; ?></p>
                </div>
                <div class="maintenance-stat-card">
                    <h3>Pending</h3>
                    <p><?php echo $data['pending_requests'] ?? 0; ?></p>
                </div>
                <div class="maintenance-stat-card">
                    <h3>In Progress</h3>
                    <p><?php echo $data['in_progress_requests'] ?? 0; ?></p>
                </div>
                <div class="maintenance-stat-card">
                    <h3>Completed</h3>
                    <p><?php echo $data['completed_requests'] ?? 0; ?></p>
                </div>
            </div>

            <div class="maintenance-request-section">
                <div class="new-request-form">
                    <h2>Submit Maintenance Request</h2>
                    <form id="maintenanceRequestForm" action="<?php echo URLROOT; ?>/maintenance/submit_request" method="POST" enctype="multipart/form-data">
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
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="4" placeholder="Describe the issue in detail" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="urgency">Urgency Level</label>
                            <select id="urgency" name="urgency" required>
                                <option value="">Select Urgency</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="images">Upload Images</label>
                            <input type="file" id="images" name="images[]" accept="image/*" multiple>
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
                                    <button class="btn-view-details">View Details</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No maintenance requests found.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="maintenance-team-section">
                <h2>Maintenance Team</h2>
                <div class="team-member-grid">
                    <?php if (!empty($data['team_members'])): ?>
                        <?php foreach ($data['team_members'] as $member): ?>
                            <div class="team-member-card">
                                <img src="<?php echo URLROOT . '/img/' . $member->profile_image; ?>"
                                    alt="<?php echo htmlspecialchars($member->name); ?>"
                                    class="team-member-avatar">
                                <h3 class="team-member-name"><?php echo htmlspecialchars($member->name); ?></h3>
                                <p class="team-member-specialization"><?php echo htmlspecialchars($member->specialization); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No team members available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // app/public/js/maintenance_requests.js
        document.addEventListener('DOMContentLoaded', function() {
            const maintenanceForm = document.getElementById('maintenanceRequestForm');

            if (maintenanceForm) {
                maintenanceForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    fetch(this.action, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Refresh the page or update the request history section
                                alert('Maintenance request submitted successfully!');
                                location.reload();
                            } else {
                                alert('Error submitting request: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while submitting the request.');
                        });
                });
            }

            // Optional: Add more interactivity like viewing request details
            const viewDetailsButtons = document.querySelectorAll('.btn-view-details');
            viewDetailsButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const requestId = this.getAttribute('data-request-id');
                    // Implement modal or detailed view logic here
                });
            });
        });
    </script>
</body>

</html>