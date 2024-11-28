<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
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
    
    min-height: 100vh;
    padding: 20px;
    gap: 20px;
}

main {
   
    padding: 20px;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Content Header */
.content-header h1 {
    margin: 0 0 10px;
    font-size: 2rem;
    color: #800080;
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
    background: #800080;
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

/* Edit Button */
.btn-edit {
    background: #3498db; /* Blue color */
    border-radius: 8px; /* Rounded corners */
    padding: 10px 20px; /* Padding for a larger clickable area */
    color: white; /* White text color */
    font-weight: bold; /* Bold text */
    transition: background 0.3s, transform 0.3s; /* Smooth transition */
}

.btn-edit:hover {
    background: #2980b9; /* Darker blue on hover */
    transform: scale(1.1); /* Slightly larger on hover */
}

/* Delete Button */
.btn-delete {
    background: #e74c3c; /* Red color */
    border-radius: 8px;
    padding: 10px 20px;
    color: white;
    font-weight: bold;
    transition: background 0.3s, transform 0.3s;
}

.btn-delete:hover {
    background: #c0392b; /* Darker red on hover */
    transform: scale(1.1);
}

/* Urgent Button */
.btn-urgent {
    background: #f39c12; /* Orange color */
    border-radius: 8px;
    padding: 10px 20px;
    color: white;
    font-weight: bold;
    transition: background 0.3s, transform 0.3s;
}

.btn-urgent:hover {
    background: #e67e22; /* Darker orange on hover */
    transform: scale(1.1);
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
    color: #800080;
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
                <input type="text" placeholder="Searching ...." />
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
                            <th>Specialization</th>
                            <th>Urgency</th>
                            <th>Resident Contact</th>
                            <th>Assigned Maintainer</th>
                            <th>Maintenance Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>R001</td>
                            <td>Malith Damsara,12B</td>
                            <td>Repair</td>
                            <td>Electrical</td>
                            <td>High</td>
                            <td>0771178945</td>
                            <td>Technician A</td>
                            <td>2024-09-18</td>
                            <td class="action-buttons">
                                <!-- <button class="btn-edit">Edit</button> -->
                                <button class="btn-delete">Delete & Submit</button>
                                <button class="btn-urgent">Add Maintainer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>R002</td>
                            <td>Sasila Sadamsara,10A</td>
                            <td>Installation</td>
                            <td>Plumbing</td>
                            <td>Medium</td>
                            <td>0776270882</td>
                            <td>Technician B</td>
                            <td>2024-09-19</td>
                            <td class="action-buttons">
                                <!-- <button class="btn-edit">Edit</button> -->
                                <button class="btn-delete">Delete & Submit</button>
                                <button class="btn-urgent">Add Maintainer</button>
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
                            <td>Malith Damsara</td>
                            <td>5</td>
                            <td>Monthly</td>
                            <td>Plumbing, AC</td>
                        </tr>
                        <tr>
                            <td>Sasila Sadamsara</td>
                            <td>3</td>
                            <td>Quarterly</td>
                            <td>Electrical</td>
                        </tr>
                        <tr>
                            <td>Geeth Pasida</td>
                            <td>5</td>
                            <td>Monthly</td>
                            <td>Plumbing, AC</td>
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
