<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Manage_Incident_Reports.css">
    <title>Manage Incident Reports | <?php echo SITENAME; ?></title>

    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fb;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
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

.btn1 {
    width: 48%;
    padding: 15px;
    background-color: #4CAF50;
    color: white;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
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
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60%;
    max-width: 800px;
    z-index: 10;
    display: none;
}

.incident-report-form .form-group {
    margin-bottom: 15px;
}

.incident-report-form label {
    display: block;
    font-weight: bold;
    color: #333;
}

.incident-report-form input,
.incident-report-form textarea,
.incident-report-form select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
    box-sizing: border-box;
}

/* Incident Log Table */
.incident-log-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
    background-color: #fff;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.incident-log-table th,
.incident-log-table td {
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

.incident-filters select,
.incident-filters input {
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

/* Search Bar */
.search-bar {
    margin-bottom: 20px;
    display: flex;
    justify-content: flex-end;
}

.search-bar input {
    padding: 8px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 200px;
}

/* Layout for Content (to the right of the side panel) */
.dashboard-container {
    display: flex;
    margin-top: 5px; /* Gap between navbar and content */
}

main {
    flex: 1;
    padding: 20px;
    margin-left: 20px; /* Assuming the side panel width is around 200px */
    background-color: #fff;
}

.too {
    text-align: left;
    color: #800080;
    padding-right: 95px;
    padding-bottom: 20px;
  
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

    .incident-filters select,
    .incident-filters input {
        width: 100%;
        margin-bottom: 10px;
    }

    .incident-log-table th,
    .incident-log-table td {
        padding: 10px;
    }

    .incident-report-form {
        width: 100%;
    }

    .modal-content {
        width: 90%;
    }

    main {
        margin-left: 0;
        padding: 10px;
    }
}

    </style>
</head>
<body>

<?php require APPROOT . '/views/inc/components/navbar.php'; ?>

<div class="dashboard-container">
    <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

    <main>
        <h3 class="too">Manage Incident Reports</h3>
        <button class="btn1" onclick="showIncidentForm()">Create Incident Report</button>

        <!-- Search Bar and Filters -->
        <div class="search-bar">
            <input type="text" id="date_search" placeholder="Search by Date..." onkeyup="searchByDate()">
        </div>

        <div class="incident-filters">
            <label for="incident_type">Filter by Type:</label>
            <select id="incident_type" onchange="filterIncidents()">
                <option value="">All</option>
                <option value="fire">Fire</option>
                <option value="theft">Theft</option>
                <option value="accident">Accident</option>
            </select>

            <label for="incident_status">Filter by Status:</label>
            <select id="incident_status" onchange="filterIncidents()">
                <option value="">All</option>
                <option value="resolved">Resolved</option>
                <option value="unresolved">Unresolved</option>
            </select>

            <label for="incident_location">Filter by Location:</label>
            <input type="text" id="incident_location" onkeyup="filterIncidents()" placeholder="Location...">
        </div>

        <h3>Incident Log</h3>
        <table id="incident_log_table" class="incident-log-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example Incident Entries -->
                <tr class="incident-item" data-id="1" data-type="fire" data-status="resolved" data-location="Warehouse" data-date="2024-11-12" data-description="A fire broke out in the warehouse due to faulty wiring.">
                    <td>Fire</td>
                    <td>2024-11-12</td>
                    <td>08:30 AM</td>
                    <td>Resolved</td>
                    <td>Warehouse</td>
                    <td>
                        <button class="btn" onclick="viewIncidentDetails(1)">View</button>
                        <button class="btn" onclick="editIncident(1)">Edit</button>
                    </td>
                </tr>
                <tr class="incident-item" data-id="2" data-type="accident" data-status="unresolved" data-location="Office" data-date="2024-11-14" data-description="An employee slipped on a wet floor.">
                    <td>Accident</td>
                    <td>2024-11-14</td>
                    <td>10:00 AM</td>
                    <td>Unresolved</td>
                    <td>Office</td>
                    <td>
                        <button class="btn" onclick="viewIncidentDetails(2)">View</button>
                        <button class="btn" onclick="editIncident(2)">Edit</button>
                    </td>
                </tr>
                <tr class="incident-item" data-id="3" data-type="theft" data-status="resolved" data-location="Store" data-date="2024-11-10" data-description="Theft of goods from the back storage room." >
                    <td>Theft</td>
                    <td>2024-11-10</td>
                    <td>12:30 PM</td>
                    <td>Resolved</td>
                    <td>Store</td>
                    <td>
                        <button class="btn" onclick="viewIncidentDetails(3)">View</button>
                        <button class="btn" onclick="editIncident(3)">Edit</button>
                    </td>
                </tr>
                <tr class="incident-item" data-id="4" data-type="fire" data-status="unresolved" data-location="Office Kitchen" data-date="2024-11-11" data-description="A small fire started in the kitchen, but it was quickly extinguished.">
                    <td>Fire</td>
                    <td>2024-11-11</td>
                    <td>09:15 AM</td>
                    <td>Unresolved</td>
                    <td>Office Kitchen</td>
                    <td>
                        <button class="btn" onclick="viewIncidentDetails(4)">View</button>
                        <button class="btn" onclick="editIncident(4)">Edit</button>
                    </td>
                </tr>
                <tr class="incident-item" data-id="5" data-type="accident" data-status="unresolved" data-location="Parking Lot" data-date="2024-11-15" data-description="A car accident occurred in the parking lot with minor injuries.">
                    <td>Accident</td>
                    <td>2024-11-15</td>
                    <td>03:45 PM</td>
                    <td>Unresolved</td>
                    <td>Parking Lot</td>
                    <td>
                        <button class="btn" onclick="viewIncidentDetails(5)">View</button>
                        <button class="btn" onclick="editIncident(5)">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal to View Incident Details -->
        <div id="incidentModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h3 class="too">Description Of Incident Report</h3>
                <p id="incident_details"></p>
            </div>
        </div>

        <!-- Incident Report Form -->
        <div class="incident-report-form" id="incidentForm">
            <h3>Report New Incident</h3>
            <form id="incidentFormElement">
                <div class="form-group">
                    <label for="incident_type">Incident Type</label>
                    <select id="incident_type" name="incident_type">
                        <option value="fire">Fire</option>
                        <option value="theft">Theft</option>
                        <option value="accident">Accident</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="incident_date">Date</label>
                    <input type="date" id="incident_date" name="incident_date">
                </div>
                <div class="form-group">
                    <label for="incident_time">Time</label>
                    <input type="time" id="incident_time" name="incident_time">
                </div>
                <div class="form-group">
                    <label for="incident_location">Location</label>
                    <input type="text" id="incident_location" name="incident_location">
                </div>
                <div class="form-group">
                    <label for="incident_description">Description</label>
                    <textarea id="incident_description" name="incident_description"></textarea>
                </div>
                <div class="form-group">
                    <button type="button" class="btn1" onclick="submitIncidentForm()">Submit Report</button>
                    <button type="button" class="btn1" onclick="cancelIncidentForm()">Cancel</button>
                </div>
            </form>
        </div>

    </main>
</div>

<script>
    // Show the Incident Form
    function showIncidentForm() {
        document.getElementById("incidentForm").style.display = "block";
    }

    // Close the Modal
    function closeModal() {
        document.getElementById("incidentModal").style.display = "none";
    }

    // View Incident Details in Modal
    function viewIncidentDetails(id) {
        var incident = document.querySelector(`.incident-item[data-id='${id}']`);
        var description = incident.getAttribute('data-description');
        document.getElementById("incident_details").textContent = description;
        document.getElementById("incidentModal").style.display = "block";
    }

    // Edit Incident (populates the form with the selected incident details)
    function editIncident(id) {
        var incident = document.querySelector(`.incident-item[data-id='${id}']`);
        var type = incident.getAttribute('data-type');
        var date = incident.getAttribute('data-date');
        var location = incident.getAttribute('data-location');
        var description = incident.getAttribute('data-description');

        document.getElementById("incident_type").value = type;
        document.getElementById("incident_date").value = date;
        document.getElementById("incident_location").value = location;
        document.getElementById("incident_description").value = description;

        showIncidentForm(); // Show the form to edit
    }

    // Submit the Incident Report
    function submitIncidentForm() {
        // Collect the form data
        var type = document.getElementById("incident_type").value;
        var date = document.getElementById("incident_date").value;
        var time = document.getElementById("incident_time").value;
        var location = document.getElementById("incident_location").value;
        var description = document.getElementById("incident_description").value;

        // Assuming you'd handle the submission to the backend here

        alert("Incident Report Submitted!");
        cancelIncidentForm(); // Close the form after submission
    }

    // Cancel the Incident Form
    function cancelIncidentForm() {
        document.getElementById("incidentForm").style.display = "none";
    }

    // Search by Date
    function searchByDate() {
        var input = document.getElementById("date_search");
        var filter = input.value.toLowerCase();
        var table = document.getElementById("incident_log_table");
        var rows = table.getElementsByTagName("tr");

        for (var i = 1; i < rows.length; i++) {
            var dateCell = rows[i].getElementsByTagName("td")[1];
            if (dateCell) {
                var dateText = dateCell.textContent || dateCell.innerText;
                rows[i].style.display = dateText.toLowerCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    }

    // Filter Incidents
    function filterIncidents() {
        var typeFilter = document.getElementById("incident_type").value;
        var statusFilter = document.getElementById("incident_status").value;
        var locationFilter = document.getElementById("incident_location").value.toLowerCase();
        var table = document.getElementById("incident_log_table");
        var rows = table.getElementsByTagName("tr");

        for (var i = 1; i < rows.length; i++) {
            var type = rows[i].getAttribute('data-type').toLowerCase();
            var status = rows[i].getAttribute('data-status').toLowerCase();
            var location = rows[i].getAttribute('data-location').toLowerCase();

            if (
                (typeFilter === "" || type.includes(typeFilter)) &&
                (statusFilter === "" || status.includes(statusFilter)) &&
                (locationFilter === "" || location.includes(locationFilter))
            ) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
</script>

</body>
</html>
