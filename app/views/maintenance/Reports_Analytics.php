<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>Reports & Analytics | Maintenance Dashboard</title>

    <style>
        /* Internal CSS for Reports & Analytics Dashboard */

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .section h2 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        /* Filter and Export Button Styles */
        .filters, .export-btn {
            display: inline-block;
            margin: 10px;
        }

        select, input {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn-export {
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-export:hover {
            background-color: #218838;
        }

        /* Analytics and Insights */
        .analytics-section {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .analytics-card {
            width: 30%;
            background-color: #f7f9fb;
            padding: 15px;
            margin: 10px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .analytics-card h3 {
            color: #3498db;
            margin-bottom: 5px;
        }

        .analytics-value {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>

<body>


<?php require APPROOT . '/views/inc/components/navbar.php'; ?>
<div class="dashboard-container">
    <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

   
        <h1>Reports & Analytics</h1>

        <!-- Customizable Report Templates Section -->
        <section class="section">
            <h2>Customizable Report Templates</h2>
            <div class="filters">
                <label for="report-type">Report Type:</label>
                <select id="report-type">
                    <option value="resident-requests">Resident Requests</option>
                    <option value="inventory-usage">Inventory Usage</option>
                    <option value="team-performance">Team Performance</option>
                    <option value="budget-utilization">Budget Utilization</option>
                </select>
            </div>
            <button class="btn-export">Generate Report</button>
        </section>

        <!-- Advanced Analytics Section -->
        <section class="section">
            <h2>Advanced Analytics</h2>
            <div class="analytics-section">
                <div class="analytics-card">
                    <h3>Resident Satisfaction</h3>
                    <div class="analytics-value">88%</div>
                </div>
                <div class="analytics-card">
                    <h3>Average Response Time</h3>
                    <div class="analytics-value">3 hrs</div>
                </div>
                <div class="analytics-card">
                    <h3>Team Productivity</h3>
                    <div class="analytics-value">75 tasks/month</div>
                </div>
            </div>
        </section>

        <!-- Resident Feedback Analysis -->
        <section class="section">
            <h2>Resident Feedback Analysis</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Resident Feedback</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-09-15</td>
                        <td>Quick response and professional service.</td>
                        <td>5/5</td>
                    </tr>
                    <tr>
                        <td>2024-09-18</td>
                        <td>Delay in repair but issue was resolved.</td>
                        <td>3/5</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Budget & Expense Tracking -->
        <section class="section">
            <h2>Budget & Expense Tracking</h2>
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Monthly Cost</th>
                        <th>Quarterly Cost</th>
                        <th>Annual Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Resident Repairs</td>
                        <td>$1,500</td>
                        <td>$4,500</td>
                        <td>$18,000</td>
                    </tr>
                    <tr>
                        <td>Scheme Maintenance</td>
                        <td>$800</td>
                        <td>$2,400</td>
                        <td>$9,600</td>
                    </tr>
                    <tr>
                        <td>Inventory</td>
                        <td>$600</td>
                        <td>$1,800</td>
                        <td>$7,200</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Maintenance Frequency Analysis -->
        <section class="section">
            <h2>Maintenance Frequency Analysis</h2>
            <table>
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Equipment</th>
                        <th>Times Serviced</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Building 1</td>
                        <td>Elevator</td>
                        <td>12</td>
                    </tr>
                    <tr>
                        <td>Building 2</td>
                        <td>HVAC System</td>
                        <td>8</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Export and Share Options -->
        <section class="section">
            <h2>Export and Share</h2>
            <div class="export-btn">
                <button class="btn-export">Export to PDF</button>
                <button class="btn-export">Export to Excel</button>
            </div>
        </section>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
