<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
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
        h1,
        h2 {
            color: #800080;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2rem;
        }

        h2 {
            padding-top: 20px;
            font-size: 1.5rem;
        }

        /* Tables */
        .task-table,
        .tracker-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 0.95rem;
        }

        .task-table th,
        .tracker-table th {
            background-color: #800080;
            color: #fff;
            padding: 12px;
            text-align: center;
            font-weight: bold;
        }

        .task-table td,
        .tracker-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .task-table tbody tr:nth-child(odd),
        .tracker-table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .task-table tbody tr:hover,
        .tracker-table tbody tr:hover {
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
            color: #800080;
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

            .task-table,
            .tracker-table {
                font-size: 0.85rem;
            }

            .task-card {
                padding: 10px;
            }

            .urgent-alert {
                padding: 10px;
            }
        }

        .search-container {
            margin-bottom: 20px;
            text-align: right;
        }

        .search-container input {
            width: 50%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            outline: none;
            transition: box-shadow 0.3s ease;
        }

        .search-container input:focus {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-color: #800080;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <!-- Side Panel -->
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <!-- Main Content -->
        <!-- Main Content -->
        <main class="main-content">
            <h1>Scheme Maintenance</h1>

            <!-- Maintenance Task List -->
            <h2>Maintenance Task List</h2>

            <!-- Search Bar for Maintenance Task List -->
            <div class="search-container">
                <input type="text" id="task-search" placeholder="Search tasks..." onkeyup="filterTasks()">
            </div>

            <table class="task-table" id="task-table">
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Type</th>

                        <th>Priority</th>
                        <th>Frequency</th>
                        <th>Assigned Maintainer</th>
                        <th>Specialization</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>MT-001</td>
                        <td>Inspection</td>

                        <td>High</td>
                        <td>Monthly</td>
                        <td>Team A</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>MT-002</td>
                        <td>Repair</td>

                        <td>Medium</td>
                        <td>Quarterly</td>
                        <td>Team B</td>
                        <td>HVAC Inspection</td>
                    </tr>
                    <tr>
                        <td>MT-003</td>
                        <td>Replacement</td>

                        <td>High</td>
                        <td>Annually</td>
                        <td>Team C</td>
                        <td>Plumbing Inspection</td>
                    </tr>
                </tbody>
            </table>

            <!-- Maintenance History -->
            <h2>Maintenance History</h2>

            <!-- Search Bar for Maintenance History -->
            <div class="search-container">
                <input type="text" id="history-search" placeholder="Search history..." onkeyup="filterHistory()">
            </div>

            <div class="task-card-container" id="history-container">
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
            </div>
        </main>

    </div>

    <!-- Footer -->
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

<script>
    function filterTasks() {
        const query = document.getElementById("task-search").value.toLowerCase();
        const rows = document.querySelectorAll("#task-table tbody tr");
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? "" : "none";
        });
    }

    function filterHistory() {
        const query = document.getElementById("history-search").value.toLowerCase();
        const cards = document.querySelectorAll("#history-container .task-card");
        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(query) ? "" : "none";
        });
    }
</script>


</html>