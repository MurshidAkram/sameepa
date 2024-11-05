<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Manage_Incident_Reports.css">
    <title>Manage Incident Reports | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <!-- Page Title -->
            <h2>Manage Incident Reports</h2>

            <!-- Incident Reports Form -->
            <form method="POST" class="incident-report-form">
                <div class="form-group">
                    <label for="incident_title">Incident Title:</label>
                    <input type="text" id="incident_title" name="incident_title" required>
                </div>
                <div class="form-group">
                    <label for="incident_description">Description:</label>
                    <textarea id="incident_description" name="incident_description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="reported_by">Reported By:</label>
                    <input type="text" id="reported_by" name="reported_by" required>
                </div>
                <button type="submit" class="btn" onclick="createIncidentReport(event)">Submit Report</button>
            </form>

            <!-- Success Message -->
            <p id="success-message" style="display: none; color: green;">Incident report submitted successfully!</p>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- JavaScript to show success message -->
    <script>
        function createIncidentReport(event) {
            event.preventDefault();
            document.getElementById('success-message').style.display = 'block';
        }
    </script>
</body>

</html>
