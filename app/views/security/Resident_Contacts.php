<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Resident_Contacts.css">
    <title>Manage Residents Contacts | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Manage Residents Contacts</h2>
            <form method="POST" class="residents-contacts-form">
                <div class="form-group">
                    <label for="resident_name">Resident Name:</label>
                    <input type="text" id="resident_name" name="resident_name" required>
                </div>
                <div class="form-group">
                    <label for="resident_phone">Phone Number:</label>
                    <input type="text" id="resident_phone" name="resident_phone" required>
                </div>
                <div class="form-group">
                    <label for="resident_email">Email Address:</label>
                    <input type="email" id="resident_email" name="resident_email" required>
                </div>
                <button type="submit" class="btn" onclick="manageResidentContact(event)">Save Contact</button>
            </form>

            <p id="success-message" style="display: none; color: green;">Contact saved successfully!</p>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        function manageResidentContact(event) {
            event.preventDefault();
            document.getElementById('success-message').style.display = 'block';
        }
    </script>
</body>

</html>
