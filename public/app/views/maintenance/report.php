<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/report.css">
    <title>Report Issues | <?php echo SITENAME; ?></title>
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
                        <small class="tooltip">Select the most relevant issue category.</small>
                    </div>

                    <div class="form-group">
                        <label for="issue-location">Location of the Issue:</label>
                        <input type="text" id="issue-location" name="location" placeholder="Building Number, Flat Number" required />
                        <small class="tooltip">Provide a detailed location for faster resolution.</small>
                    </div>

                    <div class="form-group">
                        <label for="issue-description">Issue Description:</label>
                        <textarea id="issue-description" name="description" required></textarea>
                        <small class="tooltip">Describe the issue in detail to assist the maintenance team.</small>
                    </div>

                    <div class="form-group">
                        <label for="issue-image">Upload Images (if any):</label>
                        <input type="file" id="issue-image" name="image" accept="image/*" />
                        <progress id="file-upload-progress" value="0" max="100" style="display: none;"></progress>
                        <small class="tooltip">Optional: Upload images to better illustrate the issue.</small>
                    </div>

                    <button type="submit" class="btn-report">Report Issue</button>
                </form>
            </div>

            <!-- Issue Tracking Table with Search and Filters -->
            <div class="issue-tracking">
                <h2>Reported Issues</h2>
                <div class="filter-container">
                    <input type="text" id="issue-search" placeholder="Search issues..." />
                    <select id="status-filter">
                        <option value="all">All Statuses</option>
                        <option value="under-review">Under Review</option>
                        <option value="resolved">Resolved</option>
                    </select>
                </div>

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
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script src="<?php echo URLROOT; ?>/js/report.js"></script>
</body>

</html>
