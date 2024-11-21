<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>Resident Requests | <?php echo SITENAME; ?></title>
    <style>
/* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(to bottom, #eef2f3, #ffffff);
    margin: 0;
    color: #333;
}

.dashboard-container {
    display: flex;
    min-height: 100vh;
    padding: 20px;
    gap: 20px;
}

main {
    flex: 1;
    padding: 20px;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Content Header */
.content-header h1 {
    margin: 0 0 10px;
    font-size: 2rem;
    color: #3f51b5;
}

.content-header p {
    margin: 0;
    color: #555;
}

/* Filter Section */
.filter-section {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 20px;
}

.filter-section input,
.filter-section select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s;
    min-width: 200px;
}

.filter-section input:focus,
.filter-section select:focus {
    border-color: #3f51b5;
    outline: none;
}

/* Table Styles */
.table-container {
    overflow-x: auto;
}

.dashboard-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
    font-size: 1rem;
}

.dashboard-table th {
    background: linear-gradient(to right, #42a5f5, #1e88e5);
    color: #fff;
    padding: 15px;
    font-weight: bold;
    text-align: center;
}

.dashboard-table td {
    padding: 12px;
    text-align: center;
    border: 1px solid #ddd;
    color: #555;
}

.dashboard-table tbody tr:nth-child(even) {
    background: #f9f9f9;
}

.dashboard-table tbody tr:hover {
    background: #f1f7ff;
}

/* Action Buttons */
.action-buttons button {
    padding: 8px 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    color: #fff;
    transition: transform 0.2s, background-color 0.3s;
}

.btn-edit {
    background: #4caf50;
}

.btn-edit:hover {
    background: #43a047;
    transform: scale(1.05);
}

.btn-delete {
    background: #f44336;
}

.btn-delete:hover {
    background: #e53935;
    transform: scale(1.05);
}

.btn-urgent {
    background: #ff9800;
}

.btn-urgent:hover {
    background: #fb8c00;
    transform: scale(1.05);
}

/* Attachments & Media Upload */
.file-input {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 20px 0;
}

.file-input input[type="file"] {
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
}

.file-input button {
    padding: 8px 15px;
    background: #1976d2;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.file-input button:hover {
    background: #1565c0;
}

/* Completion Rating */
.completion-rating {
    margin-top: 20px;
}

.completion-rating select {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-right: 10px;
}

.completion-rating button {
    padding: 8px 15px;
    background: #9c27b0;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.completion-rating button:hover {
    background: #8e24aa;
}

/* Request History Section */
h2 {
    color: #3f51b5;
    font-size: 1.8rem;
    margin: 20px 0 10px;
}

/* Footer */
footer {
    text-align: center;
    padding: 15px;
    font-size: 0.9rem;
    color: #666;
}

    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main>
            <div class="content-header">
                <h1>Resident Requests</h1>
                <p>Manage and view detailed requests from residents. Track history, assign technicians, and ensure timely resolutions.</p>
            </div>

            <!-- Enhanced Search & Filters -->
            <section class="filter-section">
                <input type="text" placeholder="Search by Request ID..." />
                <select>
                    <option value="" disabled selected>Filter by Request Type</option>
                    <option value="repair">Repair</option>
                    <option value="installation">Installation</option>
                </select>
                <select>
                    <option value="" disabled selected>Filter by Building Area</option>
                    <option value="north-wing">North Wing</option>
                    <option value="south-tower">South Tower</option>
                </select>
                <select>
                    <option value="" disabled selected>Filter by Priority Level</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
                <select>
                    <option value="" disabled selected>Filter by Satisfaction Score</option>
                    <option value="5">Excellent</option>
                    <option value="4">Good</option>
                    <option value="3">Fair</option>
                    <option value="2">Poor</option>
                    <option value="1">Very Poor</option>
                </select>
            </section>

            <!-- Request Table with Expanded Columns -->
            <div class="table-container">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Resident Details</th>
                            <th>Type of Request</th>
                            <th>Urgency</th>
                            <th>Status</th>
                            <th>Assigned Technician</th>
                            <th>Estimated Completion</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>R001</td>
                            <td>John Doe, Apt 12B</td>
                            <td>Repair</td>
                            <td>High</td>
                            <td>Pending</td>
                            <td>Technician A</td>
                            <td>2024-09-18</td>
                            <td class="action-buttons">
                                <button class="btn-edit">Edit</button>
                                <button class="btn-delete">Delete</button>
                                <button class="btn-urgent">Mark as Urgent</button>
                            </td>
                        </tr>
                        <tr>
                            <td>R002</td>
                            <td>Jane Smith, Apt 10A</td>
                            <td>Installation</td>
                            <td>Medium</td>
                            <td>In Progress</td>
                            <td>Technician B</td>
                            <td>2024-09-19</td>
                            <td class="action-buttons">
                                <button class="btn-edit">Edit</button>
                                <button class="btn-delete">Delete</button>
                                <button class="btn-urgent">Mark as Urgent</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Request History -->
            <h2>Request History</h2>
            <div class="table-container">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Resident</th>
                            <th>Past Requests</th>
                            <th>Frequency</th>
                            <th>Common Issues</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>5</td>
                            <td>Monthly</td>
                            <td>Plumbing, AC</td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>3</td>
                            <td>Quarterly</td>
                            <td>Electrical</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Attachments & Media Upload -->
            <h2>Attachments & Media</h2>
            <form action="<?php echo URLROOT; ?>/maintenance/upload_media" method="POST" enctype="multipart/form-data">
                <div class="file-input">
                    <label for="media-upload">Upload Image/Video:</label>
                    <input type="file" id="media-upload" name="media[]" multiple />
                    <button type="submit">Upload</button>
                </div>
            </form>

            <!-- Completion Rating -->
            <h2>Completion Rating</h2>
            <div class="completion-rating">
                <label for="rating">Rate the completion:</label>
                <select id="rating" name="rating">
                    <option value="" disabled selected>Select rating</option>
                    <option value="5">Excellent</option>
                    <option value="4">Good</option>
                    <option value="3">Fair</option>
                    <option value="2">Poor</option>
                    <option value="1">Very Poor</option>
                </select>
                <button>Submit Rating</button>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>