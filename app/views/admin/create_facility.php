
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/create_facility.css">
    <title>Create Facility | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
        <main class="create-facility-dashboard">
            <a href="<?php echo URLROOT; ?>/admin/facilities" class="btn-back">Back</a>
            <section class="facility-form">
                <h1>Create New Facility</h1>
                <form action="<?php echo URLROOT; ?>/admin/create_facility" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="facility_name">Facility Name:</label>
                        <input type="text" id="facility_name" name="facility_name" required>
                    </div>

                    <div class="form-group">
                        <label for="capacity">Capacity:</label>
                        <input type="number" id="capacity" name="capacity" required>
                    </div>

                    <div class="form-group">
                        <label for="image">Facility Image:</label>
                        <input type="file" id="image" name="image" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn-submit">Create Facility</button>
                </form>
            </section>
        </main>
    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
