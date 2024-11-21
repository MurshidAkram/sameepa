<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>Scheme Maintenance | <?php echo SITENAME; ?></title>
    <style>
       /* General Styles */
body {
    font-family: 'Roboto', Arial, sans-serif;
    background: linear-gradient(to bottom, #f5f7fa, #e9eff3);
    margin: 0;
    color: #333;
}

.dashboard-container {
    display: flex;
    gap: 20px;
    padding: 20px;
}

.main-content {
    flex-grow: 1;
    padding: 20px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Headers */
h1, h2 {
    color: #3f51b5;
    border-bottom: 2px solid #3f51b5;
    padding-bottom: 5px;
    margin-bottom: 20px;
}

h1 {
    font-size: 2rem;
}

h2 {
    font-size: 1.5rem;
}

/* Tables */
.task-table, .tracker-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-size: 0.95rem;
}

.task-table th, .tracker-table th {
    background-color: #3f51b5;
    color: #fff;
    padding: 12px;
    text-align: center;
    font-weight: bold;
}

.task-table td, .tracker-table td {
    padding: 12px;
    text-align: center;
    border: 1px solid #ddd;
}

.task-table tbody tr:nth-child(odd), .tracker-table tbody tr:nth-child(odd) {
    background-color: #f9f9f9;
}

.task-table tbody tr:hover, .tracker-table tbody tr:hover {
    background-color: #f1f1f1;
}

/* Status and Priority Styling */
.status-overdue {
    color: #d32f2f;
    font-weight: bold;
}

.status-critical {
    color: #f57c00;
    font-weight: bold;
}

.status-normal {
    color: #388e3c;
    font-weight: bold;
}

.priority-high {
    color: #d32f2f;
}

.priority-medium {
    color: #ffa000;
}

.priority-low {
    color: #0288d1;
}

/* Task Cards */
.task-card {
    background: linear-gradient(to bottom right, #ffffff, #f7f8fa);
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.task-card:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
}

.task-card h3 {
    margin-top: 0;
    color: #3f51b5;
}

/* Urgent Alerts */
.urgent-alert {
    background: linear-gradient(to right, #fbe9e7, #ef9a9a);
    color: #d32f2f;
    padding: 15px;
    border-left: 5px solid #d32f2f;
    border-radius: 5px;
    font-weight: bold;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        flex-direction: column;
    }

    .task-table, .tracker-table {
        font-size: 0.85rem;
    }

    .task-card {
        padding: 10px;
    }

    .urgent-alert {
        padding: 10px;
    }
}
</style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <!-- Side Panel -->
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <h1>Scheme Maintenance</h1>

            <!-- Maintenance Task List -->
            <h2>Maintenance Task List</h2>
            <table class="task-table">
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Frequency</th>
                        <th>Assigned Team</th>
                        <th>Dependencies</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>MT-001</td>
                        <td>Inspection</td>
                        <td class="status-normal">Scheduled</td>
                        <td class="priority-high">High</td>
                        <td>Monthly</td>
                        <td>Team A</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>MT-002</td>
                        <td>Repair</td>
                        <td class="status-critical">In Progress</td>
                        <td class="priority-medium">Medium</td>
                        <td>Quarterly</td>
                        <td>Team B</td>
                        <td>HVAC Inspection</td>
                    </tr>
                    <tr>
                        <td>MT-003</td>
                        <td>Replacement</td>
                        <td class="status-overdue">Overdue</td>
                        <td class="priority-high">High</td>
                        <td>Annually</td>
                        <td>Team C</td>
                        <td>Plumbing Inspection</td>
                    </tr>
                </tbody>
            </table>

            <!-- Routine Maintenance Tracker -->
            <h2>Routine Maintenance Tracker</h2>
            <table class="tracker-table">
                <thead>
                    <tr>
                        <th>System</th>
                        <th>Last Checked</th>
                        <th>Frequency</th>
                        <th>Next Scheduled Check</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>HVAC</td>
                        <td>2024-09-01</td>
                        <td>Monthly</td>
                        <td>2024-10-01</td>
                        <td class="status-normal">Scheduled</td>
                    </tr>
                    <tr>
                        <td>Plumbing</td>
                        <td>2024-06-01</td>
                        <td>Quarterly</td>
                        <td class="status-overdue">2024-09-01</td>
                        <td class="status-overdue">Overdue</td>
                    </tr>
                    <tr>
                        <td>Electrical</td>
                        <td>2024-07-15</td>
                        <td>Annually</td>
                        <td>2025-07-15</td>
                        <td class="status-normal">Scheduled</td>
                    </tr>
                </tbody>
            </table>

            <!-- Service Life Tracking -->
            <h2>Service Life Tracking</h2>
            <table class="tracker-table">
                <thead>
                    <tr>
                        <th>Equipment</th>
                        <th>Install Date</th>
                        <th>Service Life (Years)</th>
                        <th>Current Age (Years)</th>
                        <th>Expected Replacement</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Boiler</td>
                        <td>2015-01-15</td>
                        <td>10</td>
                        <td>9</td>
                        <td>2025</td>
                    </tr>
                    <tr>
                        <td>Elevator</td>
                        <td>2018-06-01</td>
                        <td>15</td>
                        <td>6</td>
                        <td>2033</td>
                    </tr>
                    <tr>
                        <td>Generator</td>
                        <td>2010-09-10</td>
                        <td>12</td>
                        <td>14</td>
                        <td class="status-overdue">Due for Replacement</td>
                    </tr>
                </tbody>
            </table>

            <!-- Detailed Maintenance History -->
            <h2>Maintenance History</h2>
            <div class="task-card">
                <h3>Common Area - HVAC System</h3>
                <p>Last Maintenance Date: 2024-08-15</p>
                <p>Issue: Filter Replacement</p>
                <p>Actions Taken: Replaced filters and adjusted settings</p>
                <p>Status: Completed</p>
            </div>
            <div class="task-card">
                <h3>Electrical Room - Main Circuit</h3>
                <p>Last Maintenance Date: 2024-07-10</p>
                <p>Issue: Overload Protection</p>
                <p>Actions Taken: Installed new breaker</p>
                <p>Status: Completed</p>
            </div>

            <!-- Urgent Maintenance Alerts -->
            <h2>Urgent Maintenance Alerts</h2>
            <div class="urgent-alert">
                <p><strong>Overdue Maintenance:</strong> Plumbing check for North Wing was due on 2024-09-01.</p>
            </div>
            <div class="urgent-alert">
                <p><strong>Critical Task:</strong> Generator replacement is overdue. Immediate attention required.</p>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
