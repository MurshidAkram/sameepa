<!-- app/views/resident/maintenance.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/maintenance.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">

    <title>Maintenance Requests | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="maintenance-requests-main">
            <h1>Maintenance Requests</h1>
            <p>Submit new maintenance requests or view your past requests.</p>

            <div class="maintenance-container">
                <div class="new-request-form">
                    <h2>New Maintenance Request</h2>
                    <form id="maintenanceForm">
                        <div class="form-group">
                            <label for="requestType">Request Type:</label>
                            <select id="requestType" name="requestType" required>
                                <option value="">Select request type</option>
                                <option value="plumbing">Plumbing</option>
                                <option value="electrical">Electrical</option>
                                <option value="appliance">Appliance Repair</option>
                                <option value="structural">Structural</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="urgency">Urgency Level:</label>
                            <select id="urgency" name="urgency" required>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="images">Upload Images:</label>
                            <input type="file" id="images" name="images" accept="image/*" multiple>
                        </div>
                        <button type="submit" class="btn-submit">Submit Request</button>
                    </form>
                </div>

                <div class="request-history">
                    <h2>Your Maintenance Request History</h2>
                    <div id="requestList"></div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal for editing requests -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Maintenance Request</h2>
            <form id="editForm">
                <input type="hidden" id="editId">
                <div class="form-group">
                    <label for="editRequestType">Request Type:</label>
                    <select id="editRequestType" name="editRequestType" required>
                        <option value="plumbing">Plumbing</option>
                        <option value="electrical">Electrical</option>
                        <option value="appliance">Appliance Repair</option>
                        <option value="structural">Structural</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editDescription">Description:</label>
                    <textarea id="editDescription" name="editDescription" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="editUrgency">Urgency Level:</label>
                    <select id="editUrgency" name="editUrgency" required>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit">Update Request</button>
            </form>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script src="<?php echo URLROOT; ?>/js/maintenance.js"></script>
</body>

</html>