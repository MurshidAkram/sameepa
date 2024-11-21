<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/form-styles.css">
    <title>Manage Alerts | <?php echo SITENAME; ?></title>
   
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f8fb;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .dashboard-container {
        display: flex;
        min-height: 100vh;
        padding: 20px;
    }

    main {
        flex: 1;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        margin-left: 30px;
    }

    h2, h3 {
        font-size: 2rem;
        color: #4A90E2;
        margin-bottom: 20px;
        font-weight: bold;
    }

    label {
        display: block;
        font-weight: bold;
        color: #4A90E2;
        margin-bottom: 8px;
    }

    input, textarea, select {
        width: 100%;
        padding: 12px;
        font-size: 1rem;
        border-radius: 8px;
        border: 2px solid #ddd;
        margin-bottom: 10px;
        transition: border 0.3s ease;
    }

    input:focus, textarea:focus, select:focus {
        border-color: #4A90E2;
        outline: none;
    }

    textarea {
        resize: vertical;
    }

    button {
        background-color: #4A90E2;
        color: #fff;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #357ABD;
    }

    button:active {
        background-color: #276C9D;
    }

    .search-bar input {
        padding: 12px;
        font-size: 1rem;
        width: 40%;
        border-radius: 8px;
        border: 2px solid #ddd;
        margin-bottom: 20px;
        transition: border 0.3s ease;
    }

    .search-bar input:focus {
        border-color: #4A90E2;
        outline: none;
    }

    .btn {
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

    .alerts-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        color: #333;
    }

    .alerts-table th, .alerts-table td {
        text-align: left;
        padding: 15px;
        border: 1px solid #ddd;
    }

    .alerts-table th {
        background-color: #4A90E2;
        color: white;
    }

    .alerts-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .edit-btn, .delete-btn {
        padding: 8px 15px;
        margin: 0 5px;
        border-radius: 8px;
        font-size: 0.9rem;
        cursor: pointer;
    }

    .edit-btn {
        background-color: #FFC107;
        color: white;
    }

    .edit-btn:hover {
        background-color: #FF9800;
    }

    .delete-btn {
        background-color: #E74C3C;
        color: white;
    }

    .delete-btn:hover {
        background-color: #C0392B;
    }

    .filter-bar select {
        padding: 10px;
        font-size: 1rem;
        border: 2px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        margin-bottom: 20px;
        transition: background-color 0.3s;
    }

    .filter-bar select:hover {
        background-color: #f2f2f2;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
        justify-content: center;
        align-items: center;
        transition: opacity 0.3s ease;
    }

    .modal.show {
        display: flex;
        opacity: 1;
    }

    .modal-content {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 450px;
        position: relative;
        max-height: 80vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close-btn {
        cursor: pointer;
        font-size: 1.5rem;
        color: #E74C3C;
    }

    .modal-content input,
    .modal-content select,
    .modal-content textarea {
        width: 90%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .modal-content button {
        width: 45%;
        margin: 10px;
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .modal-content button:hover {
        background-color: #6c5ce7;
        color: white;
    }

    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn {
        background-color: #6c5ce7;
        color: white;
    }

    .btn:hover {
        background-color: #5b4fe4;
    }

    /* Alerts Form Styles */
    .alerts-form {
        background-color: #f9f9f9;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
    }

    .alerts-form h3 {
        color: #4A90E2;
        font-size: 1.8em;
        margin-bottom: 15px;
    }

    .form-group input, 
    .form-group select, 
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        background-color: #f0f0f0;
        font-size: 1em;
        color: #333;
        transition: box-shadow 0.3s ease, background 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        background-color: #ffffff;
        border: 2px solid #4A90E2;
    }

    .form-buttons .cancel-btn,
    .form-buttons .submit-btn {
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 1em;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .form-buttons .cancel-btn {
        background-color: #d6d6d6;
        color: #333;
    }

    .form-buttons .cancel-btn:hover {
        background-color: #cccccc;
    }

    .form-buttons .submit-btn {
        background-color: #4A90E2;
        color: #fff;
    }

    .form-buttons .submit-btn:hover {
        background-color: #377ACB;
    }
</style>


</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Manage Alerts</h2>

            <!-- Filter Bar -->
            <div class="filter-bar">
                <select id="alert-filter" onchange="filterByTitle()">
                    <option value="all">All Alerts</option>
                    <option value="Scheduled Maintenance">Scheduled Maintenance</option>
                    <option value="Emergency Alert">Emergency Alert</option>
                </select>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" id="search-date" placeholder="Search by date (YYYY-MM-DD)" onkeyup="searchAlerts()">
            </div>

            <!-- Create Alert Button -->
            <button class="btn" onclick="showModal()">Create Alert</button>

            <!-- Alerts Table -->
            <div class="alerts-list-container">
                <h3>All Alerts</h3>
                <table class="alerts-table" id="alerts-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="alerts-tbody">
                        <!-- Example Data -->
                        <tr>
                            <td>Scheduled Maintenance</td>
                            <td>System maintenance is scheduled.</td>
                            <td>2024-11-20</td>
                            <td>10:00 AM</td>
                            <td>Active</td>
                            <td>
                                <button class="edit-btn" onclick="editAlert(this)">Edit</button>
                                <button class="delete-btn" onclick="deleteAlert(this)">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Emergency Alert</td>
                            <td>Critical system failure detected.</td>
                            <td>2024-11-22</td>
                            <td>12:30 PM</td>
                            <td>Active</td>
                            <td>
                                <button class="edit-btn" onclick="editAlert(this)">Edit</button>
                                <button class="delete-btn" onclick="deleteAlert(this)">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Scheduled Maintenance</td>
                            <td>Database maintenance tomorrow.</td>
                            <td>2024-11-21</td>
                            <td>2:00 PM</td>
                            <td>Active</td>
                            <td>
                                <button class="edit-btn" onclick="editAlert(this)">Edit</button>
                                <button class="delete-btn" onclick="deleteAlert(this)">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Scheduled Maintenance</td>
                            <td>Network upgrades planned.</td>
                            <td>2024-11-23</td>
                            <td>8:00 AM</td>
                            <td>Active</td>
                            <td>
                                <button class="edit-btn" onclick="editAlert(this)">Edit</button>
                                <button class="delete-btn" onclick="deleteAlert(this)">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Emergency Alert</td>
                            <td>Server overheating detected.</td>
                            <td>2024-11-24</td>
                            <td>5:00 PM</td>
                            <td>Active</td>
                            <td>
                                <button class="edit-btn" onclick="editAlert(this)">Edit</button>
                                <button class="delete-btn" onclick="deleteAlert(this)">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div class="modal" id="alert-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modal-title">Create Alert</h3>
            <span class="close-btn" onclick="hideModal()">&times;</span>
        </div>
        <form id="alert-form">
            <div class="form-group">
                <label for="alert-title">Title</label>
                <select id="alert-title" required>
                    <option value="">Select Title</option>
                    <option value="Scheduled Maintenance">Scheduled Maintenance</option>
                    <option value="Emergency Alert">Emergency Alert</option>
                    <option value="System Update">System Update</option>
                    <option value="Network Outage">Network Outage</option>
                </select>
            </div>
            <div class="form-group">
                <label for="alert-message">Message</label>
                <textarea id="alert-message" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="alert-date">Date</label>
                <input type="date" id="alert-date" required>
            </div>
            <div class="form-group">
                <label for="alert-time">Time</label>
                <input type="time" id="alert-time" required>
            </div>
            <div class="form-buttons">
                <button type="button" class="btn" onclick="saveAlert()">Save</button>
                <button type="button" class="btn" onclick="hideModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        function showModal() {
    document.getElementById('alert-modal').classList.add('show');
}

function hideModal() {
    document.getElementById('alert-modal').classList.remove('show');
}


        function saveAlert() {
            const title = document.getElementById('alert-title').value;
            const message = document.getElementById('alert-message').value;
            const date = document.getElementById('alert-date').value;
            const time = document.getElementById('alert-time').value;

            if (title && message && date && time) {
                const tbody = document.getElementById('alerts-tbody');
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${title}</td>
                    <td>${message}</td>
                    <td>${date}</td>
                    <td>${time}</td>
                    <td>Active</td>
                    <td>
                        <button class="edit-btn" onclick="editAlert(this)">Edit</button>
                        <button class="delete-btn" onclick="deleteAlert(this)">Delete</button>
                    </td>
                `;
                tbody.appendChild(row);

                document.getElementById('alert-form').reset();
                hideModal();
                alert('Alert created successfully!');
            }
        }

        function deleteAlert(button) {
            if (confirm('Are you sure you want to delete this alert?')) {
                const row = button.closest('tr');
                row.remove();
            }
        }

        function editAlert(button) {
            const row = button.closest('tr');
            const title = row.cells[0].textContent;
            const message = row.cells[1].textContent;
            const date = row.cells[2].textContent;
            const time = row.cells[3].textContent;

            document.getElementById('alert-title').value = title;
            document.getElementById('alert-message').value = message;
            document.getElementById('alert-date').value = date;
            document.getElementById('alert-time').value = time;

            row.remove();
            showModal();
        }

        function searchAlerts() {
            const filter = document.getElementById('search-date').value.toLowerCase();
            const rows = document.querySelectorAll('#alerts-tbody tr');

            rows.forEach(row => {
                const date = row.cells[2].textContent.toLowerCase();
                row.style.display = date.includes(filter) ? '' : 'none';
            });
        }

        function filterByTitle() {
            const filter = document.getElementById('alert-filter').value.toLowerCase();
            const rows = document.querySelectorAll('#alerts-tbody tr');

            rows.forEach(row => {
                const title = row.cells[0].textContent.toLowerCase();
                row.style.display = filter === 'all' || title.includes(filter) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
