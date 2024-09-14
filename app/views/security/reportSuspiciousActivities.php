<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <title>Report Suspicious Activities | <?php echo SITENAME; ?></title>
</head>

<body>
    <!-- Include the navbar and sidebar -->
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

    <main>
        <h1>Report Suspicious Activities</h1>
        <form action="<?php echo URLROOT; ?>/security/reportSuspiciousActivities" method="POST">
            <div class="form-group">
                <label for="activity_description">Activity Description:</label>
                <textarea id="activity_description" name="activity_description" required></textarea>
            </div>
            <button type="submit" class="btn-report">Report Activity</button>
        </form>
    </main>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
