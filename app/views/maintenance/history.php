<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>View Maintenance History | <?php echo SITENAME; ?></title>
    <style>
        /* Custom styling for the history table and filters */
        .filters {
            margin-bottom: 1rem;
        }

        .filters label {
            margin-right: 0.5rem;
        }

        .filters select,
        .filters input {
            padding: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .btn-export {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-export:hover {
            background-color: #0056b3;
        }

        .card table {
            width: 100%;
            border-collapse: collapse;
        }

        .card table, .card th, .card td {
            border: 1px solid #ddd;
        }

        .card th, .card td {
            padding: 0.75rem;
            text-align: left;
        }

        .card th {
            background-color: #f8f9fa;
        }

        .card td {
            cursor: pointer;
        }

        .card td:hover {
            background-color: #f1f1f1;
        }

        /* Detailed View */
        .detailed-view {
            display: none;
            margin-top: 1rem;
        }

        .detailed-view.active {
            display: block;
        }

        .detailed-view h2 {
            margin-top: 0;
        }

        .detailed-view .details {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main>
            <h1>Maintenance History</h1>

            <!-- Filters -->
            <section class="filters">
                <form action="<?php echo URLROOT; ?>/maintenance/history" method="GET">
                    <label for="date-from">From:</label>
                    <input type="date" id="date-from" name="date_from">

                    <label for="date-to">To:</label>
                    <input type="date" id="date-to" name="date_to">

                    <label for="task-type">Type:</label>
                    <select id="task-type" name="task_type">
                        <option value="all">All</option>
                        <option value="repair">Repair</option>
                        <option value="replacement">Replacement</option>
                        <!-- Add more options as needed -->
                    </select>

                    <label for="status">Status:</label>
                    <select id="status" name="status">
                        <option value="all">All</option>
                        <option value="completed">Completed</option>
                        <option value="in-progress">In Progress</option>
                        <option value="pending">Pending</option>
                        <!-- Add more options as needed -->
                    </select>

                    <button type="submit" class="btn-filter">Apply Filters</button>
                </form>

                <!-- Export Options -->
                <form action="<?php echo URLROOT; ?>/maintenance/export" method="POST" class="export-form">
                    <button type="submit" name="export" value="csv" class="btn-export">Export as CSV</button>
                    <button type="submit" name="export" value="pdf" class="btn-export">Export as PDF</button>
                </form>
            </section>

            <!-- Maintenance History Table -->
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Maintenance ID</th>
                            <th>Date</th>
                            <th>Details</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example dynamic content; replace with actual data -->
                        <tr onclick="showDetails('MH001')">
                            <td>MH001</td>
                            <td>2024-09-10</td>
                            <td>AC unit repair</td>
                            <td>Completed</td>
                        </tr>
                        <tr onclick="showDetails('MH002')">
                            <td>MH002</td>
                            <td>2024-09-12</td>
                            <td>Light fixture replacement</td>
                            <td>In Progress</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>

            <!-- Detailed View -->
            <div id="details-MH001" class="detailed-view">
                <h2>Maintenance ID: MH001</h2>
                <div class="details">
                    <p><strong>Date:</strong> 2024-09-10</p>
                    <p><strong>Start Time:</strong> 08:00 AM</p>
                    <p><strong>End Time:</strong> 12:00 PM</p>
                    <p><strong>Personnel:</strong> John Doe</p>
                    <p><strong>Notes:</strong> The unit was repaired and tested successfully.</p>
                </div>
            </div>
            <div id="details-MH002" class="detailed-view">
                <h2>Maintenance ID: MH002</h2>
                <div class="details">
                    <p><strong>Date:</strong> 2024-09-12</p>
                    <p><strong>Start Time:</strong> 09:00 AM</p>
                    <p><strong>End Time:</strong> 03:00 PM</p>
                    <p><strong>Personnel:</strong> Jane Smith</p>
                    <p><strong>Notes:</strong> The light fixture was replaced with a new one.</p>
                </div>
            </div>
            <!-- Add more detailed views as needed -->
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        function showDetails(id) {
            // Hide all details
            const details = document.querySelectorAll('.detailed-view');
            details.forEach(detail => detail.classList.remove('active'));

            // Show the clicked detail
            const detailToShow = document.getElementById('details-' + id);
            if (detailToShow) {
                detailToShow.classList.add('active');
            }
        }
    </script>
</body>

</html>
