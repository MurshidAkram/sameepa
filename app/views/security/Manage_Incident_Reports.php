<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Manage_Incident_Reports.css">
    <title>Manage Incident Reports | <?php echo SITENAME; ?></title>
</head>

<body>

<style>
/* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fb;
    margin: 0;
    padding: 0;
}

h2 {
    color: #333;
    font-size: 2rem;
    margin-bottom: 20px;
}

h3 {
    color: #444;
    font-size: 1.6rem;
    margin-bottom: 15px;
}

/* Button Styles */
.btn {
    background-color: #4CAF50; /* Green */
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #45a049;
}

.btn:active {
    background-color: #397d3a;
}

/* Incident Form */
.incident-report-form {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.incident-report-form .form-group {
    margin-bottom: 15px;
}

.incident-report-form label {
    display: block;
    font-weight: bold;
    color: #333;
}

.incident-report-form input, .incident-report-form textarea, .incident-report-form select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
    box-sizing: border-box;
}

.incident-report-form input[type="datetime-local"] {
    padding: 5px;
}

/* Incident Log Table */
.incident-log-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

.incident-log-table th, .incident-log-table td {
    padding: 12px 15px;
    text-align: left;
}

.incident-log-table th {
    background-color: #3498db; /* Blue */
    color: white;
    font-weight: bold;
}

.incident-log-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.incident-log-table tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}

.incident-log-table .btn {
    background-color: #f39c12; /* Orange */
}

.incident-log-table .btn:hover {
    background-color: #e67e22;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* Background Overlay */
    padding-top: 60px;
}

.modal-content {
    background-color: white;
    margin: 5% auto;
    padding: 20px;
    border-radius: 8px;
    width: 70%;
    max-width: 600px;
}

.modal-content h3 {
    margin-bottom: 15px;
    color: #333;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 25px;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Filters */
.incident-filters {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #ecf0f1;
    border-radius: 8px;
}

.incident-filters label {
    font-weight: bold;
    color: #333;
}

.incident-filters select, .incident-filters input {
    padding: 8px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: auto;
    margin-left: 10px;
}

.incident-filters input[type="text"] {
    width: 200px;
}

/* Success Message */
#success-message {
    color: green;
    font-size: 1.2rem;
    margin-top: 20px;
    font-weight: bold;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .incident-filters {
        flex-direction: column;
        align-items: flex-start;
    }

    .incident-filters label {
        margin-bottom: 5px;
    }

    .incident-filters select, .incident-filters input {
        width: 100%;
        margin-bottom: 10px;
    }

    .incident-log-table th, .incident-log-table td {
        padding: 10px;
    }

    .incident-report-form {
        width: 100%;
    }

    .modal-content {
        width: 90%;
    }
}

</style>   

<?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Manage Incident Reports</h2>

            <!-- Report Incident Button -->
            <button class="btn" onclick="showIncidentForm()">Report New Incident</button>

            <!-- Incident Reports Filter Section -->
            <div class="incident-filters">
                <label for="incident_type">Filter by Type:</label>
                <select id="incident_type" onchange="filterIncidents()">
                    <option value="">All</option>
                    <option value="fire">Fire</option>
                    <option value="theft">Theft</option>
                    <option value="accident">Accident</option>
                    <!-- Add more types as needed -->
                </select>

                <label for="incident_status">Filter by Status:</label>
                <select id="incident_status" onchange="filterIncidents()">
                    <option value="">All</option>
                    <option value="resolved">Resolved</option>
                    <option value="unresolved">Unresolved</option>
                    <!-- Add more statuses as needed -->
                </select>

                <label for="incident_location">Filter by Location:</label>
                <input type="text" id="incident_location" onkeyup="filterIncidents()" placeholder="Location...">
            </div>

            <!-- Incident Log Table -->
            <h3>Incident Log</h3>
            <table id="incident_log_table" class="incident-log-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example incident entry, dynamically generated -->
                    <tr class="incident-item" data-type="fire" data-status="resolved" data-location="Warehouse">
                        <td>Fire</td>
                        <td>2024-11-12</td>
                        <td>Resolved</td>
                        <td>Warehouse</td>
                        <td><button class="btn" onclick="viewIncidentDetails(1)">View</button></td>
                    </tr>
                    <tr class="incident-item" data-type="theft" data-status="unresolved" data-location="Office">
                        <td>Theft</td>
                        <td>2024-11-10</td>
                        <td>Unresolved</td>
                        <td>Office</td>
                        <td><button class="btn" onclick="viewIncidentDetails(2)">View</button></td>
                    </tr>
                    <!-- More incident entries would be here -->
                </tbody>
            </table>

            <!-- Incident Details Modal -->
            <div id="incident_details_modal" class="modal" style="display:none;">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h3>Incident Report Details</h3>
                    <div id="incident_details"></div>
                    <div class="form-group">
                        <label for="incident_status_update">Update Status:</label>
                        <select id="incident_status_update">
                            <option value="resolved">Resolved</option>
                            <option value="unresolved">Unresolved</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="follow_up_actions">Follow-up Actions:</label>
                        <textarea id="follow_up_actions"></textarea>
                    </div>
                    <button class="btn" onclick="updateIncidentStatus()">Update Status</button>
                </div>
            </div>

            <!-- Incident Report Form -->
            <div id="incident_form" class="incident-report-form" style="display: none;">
                <form method="POST">
                    <div class="form-group">
                        <label for="incident_title">Incident Title:</label>
                        <input type="text" id="incident_title" name="incident_title" required>
                    </div>
                    <div class="form-group">
                        <label for="incident_description">Description:</label>
                        <textarea id="incident_description" name="incident_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="incident_location">Location:</label>
                        <input type="text" id="incident_location" name="incident_location" required>
                    </div>
                    <div class="form-group">
                        <label for="incident_date">Date and Time:</label>
                        <input type="datetime-local" id="incident_date" name="incident_date" required>
                    </div>
                    <div class="form-group">
                        <label for="involved_parties">Involved Parties:</label>
                        <input type="text" id="involved_parties" name="involved_parties" required>
                    </div>
                    <button type="submit" class="btn" onclick="submitIncidentForm(event)">Submit Report</button>
                </form>
            </div>

            <p id="success-message" style="display: none; color: green;">Incident report submitted successfully!</p>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- JavaScript to show success message and manage incident log actions -->
    <script>
        function showIncidentForm() {
            document.getElementById('incident_form').style.display = 'block';
        }

        function submitIncidentForm(event) {
            event.preventDefault();
            document.getElementById('success-message').style.display = 'block';
            document.getElementById('incident_form').style.display = 'none';
            // In a real scenario, you'd send this data to your server using AJAX or a form submit.
        }

        function filterIncidents() {
            let typeFilter = document.getElementById('incident_type').value;
            let statusFilter = document.getElementById('incident_status').value;
            let locationFilter = document.getElementById('incident_location').value.toLowerCase();

            let rows = document.querySelectorAll('.incident-item');
            rows.forEach(function(row) {
                let type = row.getAttribute('data-type').toLowerCase();
                let status = row.getAttribute('data-status').toLowerCase();
                let location = row.getAttribute('data-location').toLowerCase();

                let typeMatch = !typeFilter || type.includes(typeFilter.toLowerCase());
                let statusMatch = !statusFilter || status.includes(statusFilter.toLowerCase());
                let locationMatch = !locationFilter || location.includes(locationFilter);

                if (typeMatch && statusMatch && locationMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function viewIncidentDetails(incidentId) {
            // This is a placeholder. You'd fetch the actual incident details here from your server.
            document.getElementById('incident_details').innerHTML = `
                <p><strong>Title:</strong> Incident Title ${incidentId}</p>
                <p><strong>Description:</strong> Incident description goes here...</p>
                <p><strong>Location:</strong> Location ${incidentId}</p>
                <p><strong>Reported By:</strong> John Doe</p>
                <p><strong>Witnesses:</strong> Jane Smith, Mark Lee</p>
                <p><strong>Actions Taken:</strong> Fire department responded, area evacuated.</p>
            `;
            document.getElementById('incident_details_modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('incident_details_modal').style.display = 'none';
        }

        function updateIncidentStatus() {
            // Here you would update the incident's status and add follow-up actions.
            let status = document.getElementById('incident_status_update').value;
            let actions = document.getElementById('follow_up_actions').value;
            console.log(`Updating incident status to ${status} with follow-up actions: ${actions}`);
            closeModal();
        }
    </script>
</body>

</html>
