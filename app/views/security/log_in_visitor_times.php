<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <title>Log Visitor Times | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h1>Log Visitor Times</h1>
            
            <!-- Form for Logging Visitor Times -->
            <form action="<?php echo URLROOT; ?>/security/log_in_visitor_times" method="POST">
                <div class="form-group">
                    <label for="visitor-id">Visitor ID:</label>
                    <input type="text" id="visitor-id" name="visitor_id" required>
                </div>
                <div class="form-group">
                    <label for="log-time">Log Time:</label>
                    <input type="datetime-local" id="log-time" name="log_time" required>
                </div>
                <button type="submit" class="btn-log">Log Time</button>
            </form>

            <!-- Manual Entry Button -->
            <section class="manual-entry">
                <h2>Manual Entry</h2>
                <a href="<?php echo URLROOT; ?>/security/manual_entry" class="btn">Add Manual Entry</a>
            </section>

            <!-- Login Times Table -->
            <section class="login-times">
                <h2>Visitor Check-In/Out Times</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Visitor ID</th>
                            <th>Check-In Time</th>
                            <th>Check-Out Time</th>
                            <th>Security Officer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example dynamic content; replace with actual data -->
                        <tr>
                            <td>V001</td>
                            <td>2024-09-15 08:30</td>
                            <td>2024-09-15 10:00</td>
                            <td>Officer A</td>
                        </tr>
                        <tr>
                            <td>V002</td>
                            <td>2024-09-15 09:00</td>
                            <td>2024-09-15 11:00</td>
                            <td>Officer B</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
