<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Emergency_Contacts.css">
    <title>Manage Emergency Contacts | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Manage Emergency Contacts</h2>

            <form method="POST" class="emergency-contacts-form">
                <div class="form-group">
                    <label for="contact_name">Contact Name:</label>
                    <input type="text" id="contact_name" name="contact_name" required>
                </div>
                <div class="form-group">
                    <label for="contact_phone">Phone Number:</label>
                    <input type="text" id="contact_phone" name="contact_phone" required>
                </div>
                <div class="form-group">
                    <label for="relationship">Relationship:</label>
                    <input type="text" id="relationship" name="relationship" required>
                </div>
                <button type="submit" class="btn" onclick="manageEmergencyContact(event)">Save Contact</button>
            </form>

            <p id="success-message" style="display: none; color: green;">Emergency contact saved successfully!</p>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        function manageEmergencyContact(event) {
            event.preventDefault();
            document.getElementById('success-message').style.display = 'block';
        }
    </script>
</body>

</html>
