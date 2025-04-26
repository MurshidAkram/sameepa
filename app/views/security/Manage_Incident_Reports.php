<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>Manage Incident Reports | <?php echo SITENAME; ?></title>
    <style>
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
            color: #800080;
            font-size: 1.6rem;
            margin-bottom: 15px;
        }

        .title {
            text-align: left;
            color: #800080;
            padding-right: 95px;
            padding-bottom: 20px;
        }

        /* Buttons */
        .btn,
        .btn-create,
        .btn-submit,
        .btn-cancel,
        .btn-view,
        .btn-edit {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-create {
            width: 48%;
            padding: 15px;
            background-color: #336699;
            color: white;
            font-size: 18px;
        }

        .btn-create:hover {
            background-color: #29547d;
        }

        .btn-submit {
            background-color: #6c5ce7;
            color: white;
            font-weight: bold;
            width: 65%;
            padding-left: 30px;
            margin: 0 auto;
            /* This centers the button */
            display: block;
            /* Ensures margin auto works as expected */
        }


        .btn-submit:hover {
            background-color: #5b4fe4;
        }

        .btn-cancel {
            background-color: #636e72;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #555;
        }

        .btn-view {
            background-color: #4CAF50;
            color: white;
            margin-right: 5px;
        }

        .btn-view:hover {
            background-color: #45a049;
        }

        .btn-edit {
            background-color: #f39c12;
            color: white;
        }

        .btn-edit:hover {
            background-color: #e67e22;
        }

        /* Dashboard Layout */
        .dashboard-container {
            display: flex;
            margin-top: 5px;
        }

        main {
            flex: 1;
            padding: 20px;
            margin-left: 20px;
            background-color: #fff;
        }

        /* Search and Filters */
        .search-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #ecf0f1;
            border-radius: 8px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .search-bar {
            flex: 1;
            display: flex;
            justify-content: flex-end;
        }

        .search-bar input,
        .filter-group select,
        .filter-group input {
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        .incident-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: #fff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .incident-table th,
        .incident-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .incident-table th {
            background-color: #800080;
            color: white;
            font-weight: bold;
        }

        .incident-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .incident-table tr:hover {
            background-color: #f1f1f1;
        }

        .incident-table .actions {
            display: flex;
            gap: 5px;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        /* Status Badges */
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: capitalize;
        }

        .status-open {
            background-color: #ff7675;
            color: white;
        }

        .status-in-progress {
            background-color: #74b9ff;
            color: white;
        }

        .status-resolved {
            background-color: #55efc4;
            color: white;
        }

        .status-closed {
            background-color: #a29bfe;
            color: white;
        }

        .status-pending {
            background-color: #ffeaa7;
            color: #333;
        }

        /* Modals */
        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 600px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: none;
        }

        .modal.active {
            display: block;
        }

        .modal-content {
            padding: 20px;
        }

        .modal-content h3 {
            font-size: 22px;
            color: #6c5ce7;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .modal-content .close {
            font-size: 2.5rem;
            cursor: pointer;
            color: rgb(244, 8, 209);
            float: right;
            line-height: 1;
            margin-top: -10px;
        }

        /* Modal Form */
        .modal-content form {
            display: flex;
            flex-direction: column;
        }

        .modal-content .form-group {
            margin-bottom: 15px;
        }

        .modal-content label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        .modal-content input,
        .modal-content select,
        .modal-content textarea {
            width: 100%;
            padding: 5px;
            border: 1px solid black;
            border-radius: 5px;
            background-color: #f6e4f7;
            color: black;
        }

        .modal-content input:disabled,
        .modal-content select:disabled,
        .modal-content textarea:disabled {
            background-color: #e9e9e9;
            color: #666;
        }

        .modal-content input:focus,
        .modal-content select:focus,
        .modal-content textarea:focus {
            outline: none;
            border-color: #e8c8e3;
            box-shadow: 0 0 5px rgba(232, 200, 227, 0.5);
        }

        .modal-content textarea {
            resize: vertical;
            height: 90px;
        }

        .modal-content .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        /* View Details */
        .incident-details p {
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .description-content {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            margin-top: 5px;
        }

        /* Loading and Alerts */
        .loading-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #0984e3;
            color: white;
            border-radius: 5px;
            z-index: 1001;
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 1001;
            animation: slideIn 0.5s forwards;
        }

        .alert-success {
            background-color: #00b894;
            color: white;
        }

        .alert-error {
            background-color: #d63031;
            color: white;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }

            main {
                margin-left: 0;
                padding: 10px;
            }

            .search-filters {
                flex-direction: column;
                gap: 10px;
            }

            .search-bar input,
            .filter-group select,
            .filter-group input {
                width: 100%;
            }

            .modal {
                width: 95%;
            }

            .incident-table .actions {
                flex-direction: column;
            }

            .btn-view,
            .btn-edit {
                width: 100%;
                margin-bottom: 5px;
            }
        }

        /* Description preview styles */
        .description-preview {
            max-height: 3.6em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            line-height: 1.4;
        }

        .more-lines-indicator {
            color: #666;
            font-size: 0.8em;
            font-style: italic;
            display: block;
            margin-top: 3px;
        }

        /* View modal styles */
        #viewIncidentModal .modal-content {
            max-width: 700px;
        }

        #viewIncidentDescription {
            max-height: 60vh;
            overflow-y: auto;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            white-space: pre-wrap;
            line-height: 1.6;
        }

        #viewIncidentModal h3 {
            color: #800080;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>

<body>

    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h3 class="title">Manage Incident Reports</h3>
            <button class="btn-create" onclick="showIncidentForm()">Create Incident Report</button>

            <!-- Search and Filters -->
            <div class="search-filters">
                <div class="search-bar">
                    <input type="text" id="date_search" placeholder="Search by date...">
                </div>

                <div class="filter-group">
                    <label for="incident_type_filter">Type:</label>
                    <select id="incident_type_filter">
                        <option value="">All Types</option>
                        <option value="fire">Fire</option>
                        <option value="theft">Theft</option>
                        <option value="accident">Accident</option>
                        <option value="vandalism">Vandalism</option>
                        <option value="medical">Medical Emergency</option>
                        <option value="security_breach">Security Breach</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="incident_status_filter">Status:</label>
                    <select id="incident_status_filter">
                        <option value="">All Statuses</option>
                        <option value="Open">Open</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                        <option value="Closed">Closed</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="incident_location_filter">Location:</label>
                    <input type="text" id="incident_location_filter" placeholder="Filter by location...">
                </div>
            </div>

            <!-- Incident Table -->
            <div class="table-container">
                <table id="incidentTable" class="incident-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- View Incident Modal (Simplified to show only description) -->
            <div id="viewIncidentModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('viewIncidentModal')">&times;</span>
                    <h3>Incident Description</h3>
                    <div id="viewIncidentDescription" class="description-content"></div>
                </div>
            </div>

            <!-- Incident Form Modal -->
            <div id="incidentFormModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeIncidentForm()">&times;</span>
                    <h3 id="incidentFormTitle">Report New Incident</h3>
                    <form id="incidentForm">
                        <div class="form-group">
                            <label for="incident_type">Incident Type:</label>
                            <select id="incident_type" name="type" required>
                                <option value="">Select Incident Type</option>
                                <option value="fire">Fire</option>
                                <option value="theft">Theft</option>
                                <option value="accident">Accident</option>
                                <option value="vandalism">Vandalism</option>
                                <option value="medical">Medical Emergency</option>
                                <option value="security_breach">Security Breach</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="incident_date">Date:</label>
                            <input type="date" id="incident_date" name="date" required>
                        </div>

                        <div class="form-group">
                            <label for="incident_time">Time:</label>
                            <input type="time" id="incident_time" name="time" required>
                        </div>

                        <div class="form-group">
                            <label for="incident_location">Location:</label>
                            <input type="text" id="incident_location" name="location" required>
                        </div>

                        <div class="form-group">
                            <label for="incident_description">Description:</label>
                            <textarea id="incident_description" name="description" rows="4"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="incident_status">Status:</label>
                            <select id="incident_status" name="status" required>
                                <option value="Open">Open</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Resolved">Resolved</option>
                                <option value="Closed">Closed</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-submit">Save</button>

                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>




    <script>
        // Global variable to store incidents
        let incidentsData = [];

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            loadIncidents();

            // Set up form submission
            document.getElementById('incidentForm').addEventListener('submit', handleFormSubmit);

            // Set up search/filter listeners
            document.getElementById('date_search').addEventListener('input', filterIncidents);
            document.getElementById('incident_type_filter').addEventListener('change', filterIncidents);
            document.getElementById('incident_status_filter').addEventListener('change', filterIncidents);
            document.getElementById('incident_location_filter').addEventListener('input', filterIncidents);

            // Set current date as default for new incidents
            document.getElementById('incident_date').valueAsDate = new Date();
        });

        // Load incidents from server
        async function loadIncidents() {
            try {
                showLoading(true);

                const response = await fetch('<?php echo URLROOT; ?>/security/getAllIncidents');

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    incidentsData = data.incidents;
                    renderIncidentTable(incidentsData);
                } else {
                    throw new Error(data.message || 'Failed to load incidents');
                }
            } catch (error) {
                console.error('Error loading incidents:', error);
                showError('Failed to load incidents: ' + error.message);
            } finally {
                showLoading(false);
            }
        }

        // Render incidents in the table with description preview
        function renderIncidentTable(incidents) {
            const tableBody = document.createElement('tbody');

            if (incidents.length === 0) {
                tableBody.innerHTML = `
            <tr>
                <td colspan="7" class="no-data">No incidents found</td>
            </tr>
        `;
            } else {
                incidents.forEach(incident => {
                    const row = document.createElement('tr');
                    row.dataset.id = incident.report_id;

                    // Split description into multiple lines if it contains newlines
                    const descriptionLines = incident.description.split('\n');
                    const shortDescription = descriptionLines[0].substring(0, 50) + (descriptionLines[0].length > 50 ? '...' : '');

                    row.innerHTML = `
                <td>${capitalizeFirstLetter(incident.type.replace('_', ' '))}</td>
                <td>${formatDate(incident.date)}</td>
                <td>${formatTime(incident.time)}</td>
                <td>${escapeHtml(incident.location)}</td>
                <td>
                    <div class="description-preview">
                        ${escapeHtml(shortDescription)}
                        ${descriptionLines.length > 1 ? '<span class="more-lines-indicator">(+' + (descriptionLines.length - 1) + ' more lines)</span>' : ''}
                    </div>
                </td>
                <td><span class="status-badge ${getStatusClass(incident.status)}">${incident.status}</span></td>
                <td class="actions">
                    <button class="btn-view" onclick="viewIncident(${incident.report_id})">View</button>
                    <button class="btn-edit" onclick="editIncident(${incident.report_id})">Edit Status</button>
                </td>
            `;
                    tableBody.appendChild(row);
                });
            }

            // Replace table body
            const table = document.getElementById('incidentTable');
            const oldBody = table.querySelector('tbody');
            if (oldBody) table.removeChild(oldBody);
            table.appendChild(tableBody);
        }

        // View incident description only
        function viewIncident(id) {
            const incident = incidentsData.find(i => i.report_id == id);
            if (!incident) return;

            // Clear previous content
            const descContent = document.getElementById('viewIncidentDescription');
            descContent.innerHTML = '';

            // Split description by newlines and create paragraphs for each line
            const descriptionLines = incident.description.split('\n');
            descriptionLines.forEach(line => {
                if (line.trim() !== '') {
                    const p = document.createElement('p');
                    p.textContent = line;
                    descContent.appendChild(p);
                }
            });

            // Update modal title to show incident type
            document.querySelector('#viewIncidentModal h3').textContent = `${capitalizeFirstLetter(incident.type.replace('_', ' '))} Incident Description`;

            // Show modal
            document.getElementById('viewIncidentModal').style.display = 'block';
        }

        // Handle form submission
        async function handleFormSubmit(e) {
            e.preventDefault();

            try {
                showLoading(true, 'Processing...');

                const form = document.getElementById('incidentForm');
                const isEditing = form.dataset.editingId ? true : false;
                const formData = {
                    type: document.getElementById('incident_type').value,
                    date: document.getElementById('incident_date').value,
                    time: document.getElementById('incident_time').value,
                    location: document.getElementById('incident_location').value,
                    description: document.getElementById('incident_description').value,
                    status: document.getElementById('incident_status').value
                };

                let response, result;

                if (isEditing) {
                    // Update existing incident
                    response = await fetch(`<?php echo URLROOT; ?>/security/updateIncident/${form.dataset.editingId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            status: formData.status
                        })
                    });

                    result = await response.json();

                    if (!response.ok || !result.success) {
                        throw new Error(result.message || 'Failed to update incident status');
                    }

                    showSuccess('Incident status updated successfully!');
                } else {
                    // Create new incident
                    response = await fetch('<?php echo URLROOT; ?>/security/Add_Incident', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(formData)
                    });

                    result = await response.json();

                    if (!response.ok || !result.success) {
                        throw new Error(result.message || 'Failed to create new incident');
                    }

                    showSuccess('Incident created successfully!');
                }

                closeIncidentForm();
                await loadIncidents(); // Refresh the table

            } catch (error) {
                console.error('Error submitting form:', error);
                showError('Error: ' + error.message);
            } finally {
                showLoading(false);
            }
        }

        // Edit incident status
        function editIncident(id) {
            const incident = incidentsData.find(i => i.report_id == id);
            if (!incident) {
                showError('Incident not found');
                return;
            }

            // Reset form first
            const form = document.getElementById('incidentForm');
            form.reset();

            // Populate form
            document.getElementById('incident_type').value = incident.type;
            document.getElementById('incident_date').value = incident.date;
            document.getElementById('incident_time').value = incident.time;
            document.getElementById('incident_location').value = incident.location;
            document.getElementById('incident_description').value = incident.description;
            document.getElementById('incident_status').value = incident.status;

            // Disable all fields except status
            document.getElementById('incident_type').disabled = true;
            document.getElementById('incident_date').disabled = true;
            document.getElementById('incident_time').disabled = true;
            document.getElementById('incident_location').disabled = true;
            document.getElementById('incident_description').disabled = true;

            // Show only the status field
            document.querySelectorAll('#incidentForm .form-group').forEach(group => {
                group.style.display = 'none';
            });
            document.getElementById('incident_status').closest('.form-group').style.display = 'block';

            // Update form title
            document.getElementById('incidentFormTitle').textContent = 'Update Incident Status';

            // Store ID for submission
            form.dataset.editingId = id;

            // Show form
            document.getElementById('incidentFormModal').style.display = 'block';
        }

        // Filter incidents based on search criteria
        function filterIncidents() {
            const typeFilter = document.getElementById('incident_type_filter').value.toLowerCase();
            const statusFilter = document.getElementById('incident_status_filter').value.toLowerCase();
            const dateFilter = document.getElementById('date_search').value;
            const locationFilter = document.getElementById('incident_location_filter').value.toLowerCase();

            const filtered = incidentsData.filter(incident => {
                return (
                    (typeFilter === '' || incident.type.toLowerCase().includes(typeFilter)) &&
                    (statusFilter === '' || incident.status.toLowerCase().includes(statusFilter)) &&
                    (dateFilter === '' || incident.date.includes(dateFilter)) &&
                    (locationFilter === '' || incident.location.toLowerCase().includes(locationFilter))
                );
            });

            renderIncidentTable(filtered);
        }

        // Helper functions
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function truncateText(text, maxLength) {
            return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
        }

        function formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString();
        }

        function formatTime(timeString) {
            if (!timeString) return '';
            return timeString.substring(0, 5); // Display HH:MM
        }

        function getStatusClass(status) {
            const statusMap = {
                'open': 'status-open',
                'in progress': 'status-in-progress',
                'resolved': 'status-resolved',
                'closed': 'status-closed',
                'pending': 'status-pending'
            };
            return statusMap[status.toLowerCase()] || 'status-default';
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function showLoading(show, message = 'Loading...') {
            const loadingElement = document.getElementById('loadingIndicator') || createLoadingElement();
            loadingElement.textContent = message;
            loadingElement.style.display = show ? 'block' : 'none';
        }

        function createLoadingElement() {
            const loadingDiv = document.createElement('div');
            loadingDiv.id = 'loadingIndicator';
            loadingDiv.className = 'loading-indicator';
            document.body.appendChild(loadingDiv);
            return loadingDiv;
        }

        function showSuccess(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success';
            alertDiv.textContent = message;
            // document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 3000);
        }

        function showError(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-error';
            alertDiv.textContent = message;
          
            setTimeout(() => alertDiv.remove(), 5000);
        }

        // Modal functions
        function showIncidentForm() {
            const form = document.getElementById('incidentForm');

            // Reset form
            form.reset();

            // Enable all fields
            document.querySelectorAll('#incidentForm input, #incidentForm select, #incidentForm textarea').forEach(el => {
                el.disabled = false;
            });

            // Show all form groups
            document.querySelectorAll('#incidentForm .form-group').forEach(group => {
                group.style.display = 'block';
            });

            // Set default values
            document.getElementById('incident_date').valueAsDate = new Date();
            document.getElementById('incident_status').value = 'Open';

            // Update form title
            document.getElementById('incidentFormTitle').textContent = 'Report New Incident';

            // Remove editing ID if exists
            if (form.dataset.editingId) {
                delete form.dataset.editingId;
            }

            // Show modal
            document.getElementById('incidentFormModal').style.display = 'block';
        }

        function closeIncidentForm() {
            document.getElementById('incidentFormModal').style.display = 'none';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
    </script>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>