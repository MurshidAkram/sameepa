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
        /* Internal CSS for Resident Requests */
        .content-header {
            margin-bottom: 20px;
        }

        .filter-section {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-section select,
        .filter-section input {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            min-width: 150px;
        }

        .table-container {
            overflow-x: auto;
        }

        .dashboard-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .dashboard-table th,
        .dashboard-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .dashboard-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .action-buttons button {
            margin: 0 5px;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-urgent {
            background-color: #ff5a5f;
            color: white;
        }

        .btn-urgent:hover {
            background-color: #e04444;
        }

        .file-input {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .completion-rating select {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
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
