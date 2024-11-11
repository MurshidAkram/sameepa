<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/superadmin/reports.css">
    <title>Super Admin Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>

        <main>
            <h1>Reports</h1>
            <section class="dashboard-overview">
                <div class="reports-section">

                    <!-- Resident Reports -->
                    <div class="report-category">
                        <h3>Resident Reports</h3>
                        <table class="report-list">
                            <thead>
                                <tr>
                                    <th>Report ID</th>
                                    <th>Resident Name</th>
                                    <th>Issue</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>RPT001</td>
                                    <td>John Doe</td>
                                    <td>Noise Complaint</td>
                                    <td>2024-09-15</td>
                                    <td>Resolved</td>
                                </tr>
                                <tr>
                                    <td>RPT002</td>
                                    <td>Jane Smith</td>
                                    <td>Maintenance Request</td>
                                    <td>2024-09-20</td>
                                    <td>Pending</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Admin & Security Reports -->
                    <div class="report-category">
                        <h3>Admin & Security Reports</h3>
                        <table class="report-list">
                            <thead>
                                <tr>
                                    <th>Report ID</th>
                                    <th>Staff Name</th>
                                    <th>Issue</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>RPT003</td>
                                    <td>Admin User</td>
                                    <td>Unauthorized Access</td>
                                    <td>2024-09-22</td>
                                    <td>Investigating</td>
                                </tr>
                                <tr>
                                    <td>RPT004</td>
                                    <td>Security Staff</td>
                                    <td>Incident Report</td>
                                    <td>2024-09-25</td>
                                    <td>Closed</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>

