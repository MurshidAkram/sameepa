<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>Report Issues | <?php echo SITENAME; ?></title>
    <style>
        /* Custom styling for the issue reporting form */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-group select,
        .form-group textarea,
        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .form-group textarea {
            resize: vertical;
            height: 100px;
        }

        .btn-report {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-report:hover {
            background-color: #0056b3;
        }

        /* Custom styling for the issue tracking table */
        .tracking-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }

        .tracking-table th,
        .tracking-table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        .tracking-table th {
            background-color: #f8f9fa;
        }

        .tracking-table .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .tracking-table .btn-view,
        .tracking-table .btn-comment {
            padding: 0.5rem;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        .btn-view {
            background-color: #17a2b8;
        }

        .btn-view:hover {
            background-color: #138496;
        }

        .btn-comment {
            background-color: #28a745;
        }

        .btn-comment:hover {
            background-color: #218838;
        }

        /* Styling for file input */
        .form-group input[type="file"] {
            padding: 0;
            border: none;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main>
            <h1>Report Issues</h1>
            <div class="card">
                <!-- Issue Reporting Form -->
                <form action="<?php echo URLROOT; ?>/maintenance/report" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="issue-category">Issue Category:</label>
                        <select id="issue-category" name="category" required>
                            <option value="electrical">Electrical</option>
                            <option value="plumbing">Plumbing</option>
                            <option value="HVAC">HVAC</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="issue-location">Location of the Issue:</label>
                        <input type="text" id="issue-location" name="location" placeholder="Building Number, Flat Number" required />
                    </div>

                    <div class="form-group">
                        <label for="issue-description">Issue Description:</label>
                        <textarea id="issue-description" name="description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="issue-image">Upload Images (if any):</label>
                        <input type="file" id="issue-image" name="image" accept="image/*" />
                    </div>

                    <button type="submit" class="btn-report">Report Issue</button>
                </form>
            </div>

            <!-- Issue Tracking Table -->
            <h2>Reported Issues</h2>
            <table class="tracking-table">
                <thead>
                    <tr>
                        <th>Issue ID</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Date Reported</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example rows; replace with dynamic data -->
                    <tr>
                        <td>ISS001</td>
                        <td>Electrical</td>
                        <td>Building 1, Flat 101</td>
                        <td>Power outage in the kitchen</td>
                        <td>Under Review</td>
                        <td>2024-09-15</td>
                        <td class="action-buttons">
                            <button class="btn-view">View</button>
                            <button class="btn-comment">Comment</button>
                        </td>
                    </tr>
                    <tr>
                        <td>ISS002</td>
                        <td>Plumbing</td>
                        <td>Building 2, Flat 205</td>
                        <td>Leaky faucet in the bathroom</td>
                        <td>Resolved</td>
                        <td>2024-09-16</td>
                        <td class="action-buttons">
                            <button class="btn-view">View</button>
                            <button class="btn-comment">Comment</button>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
