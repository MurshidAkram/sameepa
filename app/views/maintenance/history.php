<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>View Maintenance History | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main>
            <h1>Maintenance History</h1>
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
                        <tr>
                            <td>MH001</td>
                            <td>2024-09-10</td>
                            <td>AC unit repair</td>
                            <td>Completed</td>
                        </tr>
                        <tr>
                            <td>MH002</td>
                            <td>2024-09-12</td>
                            <td>Light fixture replacement</td>
                            <td>In Progress</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
