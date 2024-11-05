<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Manage_Visitor_Passes.css">
    <title>Manage Visitor Passes | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <!-- Page Title -->
            <h2>Create Visitor Pass</h2>

            <!-- Visitor Pass Form -->
            <form method="POST" class="visitor-pass-form">
                <div class="form-group">
                    <label for="visitor_name">Visitor Name:</label>
                    <input type="text" id="visitor_name" name="visitor_name" required>
                </div>
                <div class="form-group">
                    <label for="resident_id">Resident ID:</label>
                    <input type="number" id="resident_id" name="resident_id" required>
                </div>
                <div class="form-group">
                    <label for="visit_time">Visit Time:</label>
                    <input type="datetime-local" id="visit_time" name="visit_time" required>
                </div>
                <button type="submit" class="btn" onclick="createVisitorPass(event)">Create Visitor Pass</button>
            </form>

            <!-- Success Message -->
            <p id="success-message" style="display: none; color: green;">Visitor pass created successfully!</p>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- JavaScript to show success message -->
    <script>
        function createVisitorPass(event) {
            event.preventDefault();
            document.getElementById('success-message').style.display = 'block';
        }
    </script>
</body>

</html>
