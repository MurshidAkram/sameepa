<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Duty_Schedule.css">
    <title>Manage Duty Schedule | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Manage Duty Schedule</h2>

            <form method="POST" class="duty-schedule-form">
                <div class="form-group">
                    <label for="duty_officer">Duty Officer:</label>
                    <input type="text" id="duty_officer" name="duty_officer" required>
                </div>
                <div class="form-group">
                    <label for="duty_date">Duty Date:</label>
                    <input type="date" id="duty_date" name="duty_date" required>
                </div>
                <div class="form-group">
                    <label for="duty_shift">Shift Time:</label>
                    <input type="text" id="duty_shift" name="duty_shift" placeholder="e.g., 9 AM - 5 PM" required>
                </div>
                <button type="submit" class="btn" onclick="manageDutySchedule(event)">Save Schedule</button>
            </form>

            <p id="success-message" style="display: none; color: green;">Duty schedule saved successfully!</p>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        function manageDutySchedule(event) {
            event.preventDefault();
            document.getElementById('success-message').style.display = 'block';
        }
    </script>
</body>

</html>
