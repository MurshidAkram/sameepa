<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Manage_Alerts.css">
    <title>Manage Alerts | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Manage Alerts</h2>

            <form method="POST" class="alerts-form">
                <div class="form-group">
                    <label for="alert_title">Alert Title:</label>
                    <input type="text" id="alert_title" name="alert_title" required>
                </div>
                <div class="form-group">
                    <label for="alert_message">Message:</label>
                    <textarea id="alert_message" name="alert_message" required></textarea>
                </div>
                <div class="form-group">
                    <label for="alert_date">Alert Date:</label>
                    <input type="date" id="alert_date" name="alert_date" required>
                </div>
                <button type="submit" class="btn" onclick="manageAlerts(event)">Create Alert</button>
            </form>

            <p id="success-message" style="display: none; color: green;">Alert created successfully!</p>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        function manageAlerts(event) {
            event.preventDefault();
            document.getElementById('success-message').style.display = 'block';
        }
    </script>
</body>

</html>
