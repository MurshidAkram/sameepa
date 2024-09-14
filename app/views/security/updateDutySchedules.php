<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <title>Update Duty Schedules | <?php echo SITENAME; ?></title>
</head>

<body>
    <!-- Include the navbar and sidebar -->
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

    <main>
        <h1>Update Duty Schedules</h1>
        <form action="<?php echo URLROOT; ?>/security/updateDutySchedules" method="POST">
            <div class="form-group">
                <label for="duty_schedule">Duty Schedule:</label>
                <textarea id="duty_schedule" name="duty_schedule">Enter updated schedule...</textarea>
            </div>
            <button type="submit" class="btn-update">Update Schedule</button>
        </form>
    </main>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
