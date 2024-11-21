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
            background-color: #f0f4f7; /* Light background */
            margin: 0;
            padding: 0;
            color: #333;
        }

        .dashboard-container {
            display: flex;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        /* Side Panel */
        .side-panel {
            width: 250px; /* Fixed width for the side panel */
            margin-right: 20px;
        }

        /* Main Content Area */
        .main-content {
            flex-grow: 1;
        }

        h1 {
            color: #34495e; /* Darker shade for the main title */
            text-align: center;
            margin-bottom: 20px;
            font-size: 2.5em;
        }

        .section {
            background-color: #fff;
            border: 1px solid #e1e8f0; /* Light border color */
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); /* Light shadow for sections */
        }

        .section h2 {
            color: #2980b9; /* Blue color for section headings */
            margin-bottom: 20px;
            font-size: 1.8em;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #dfe6e9; /* Light border for table */
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #3498db; /* Vibrant blue */
            color: #fff;
            font-size: 1.1em;
        }

        td {
            background-color: #ecf0f1; /* Light gray background for data rows */
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9; /* Alternate row colors for readability */
        }

        /* Filter and Export Button Styles */
        .filters, .export-btn {
            display: inline-block;
            margin: 10px;
        }

        select, input {
            padding: 8px;
            border: 1px solid #bdc3c7; /* Gray border for input fields */
            border-radius: 5px;
            background-color: #fff;
            font-size: 1em;
        }

        .btn-export {
            padding: 10px 16px;
            background-color: #28a745; /* Green button for export */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
        }

        .btn-export:hover {
            background-color: #218838; /* Darker green on hover */
        }

        /* Analytics and Insights */
        .analytics-section {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .analytics-card {
            width: 30%;
            background-color: #f4f6f9; /* Light background for analytics cards */
            padding: 20px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .analytics-card:hover {
            transform: translateY(-5px); /* Card hover effect */
        }

        .analytics-card h3 {
            color: #2980b9; /* Blue color for card headings */
            margin-bottom: 15px;
        }

        .analytics-value {
            font-size: 2.5em;
            font-weight: bold;
            color: #e74c3c; /* Red color for values */
        }

        .analytics-card:nth-child(2) .analytics-value {
            color: #f39c12; /* Orange color for second card */
        }

        .analytics-card:nth-child(3) .analytics-value {
            color: #8e44ad; /* Purple color for third card */
        }

        /* Responsive Design for Small Screens */
        @media (max-width: 768px) {
            .analytics-card {
                width: 48%;
            }

            .dashboard-container {
                flex-direction: column;
                align-items: center;
            }

            .side-panel {
                width: 100%;
                margin-bottom: 20px;
            }

            .main-content {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .analytics-card {
                width: 100%;
            }

            .filters, .export-btn {
                display: block;
                margin: 10px 0;
            }
        }

    </style>
</head>

<body>

    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <div class="dashboard-container">
        <!-- Side Panel on the Left -->
        <div class="side-panel">
            <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>
        </div>

        <!-- Main Content on the Right -->
        <div class="main-content">
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
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>