<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <title>Manage Visitor Passes | <?php echo SITENAME; ?></title>
</head>

<body>
    <!-- Include the navbar and sidebar -->
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

    <main>
        <h1>Manage Visitor Passes</h1>
        <div class="form-group">
            <label for="visitor_passes">Visitor Passes:</label>
            <textarea id="visitor_passes" name="visitor_passes" readonly>Passes will be displayed here...</textarea>
        </div>
    </main>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
