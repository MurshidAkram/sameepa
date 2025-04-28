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
    
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main class="main-content">
            <h1>Scheme Maintenance</h1>

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