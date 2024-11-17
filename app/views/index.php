<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <title>Welcome | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="home-content-wrapper">
        <main>
            <div class="left-section">
                <h1>Welcome to <?php echo SITENAME; ?></h1>
                <p>Your community management system. SAMEEPA is designed to streamline and enhance your community living experience.</p>
                <ul class="dashboard-links">
                    <!-- Links to all dashboards -->
                    <li><a href="<?php echo URLROOT; ?>/admin/dashboard">Admin</a></li>
                    <li><a href="<?php echo URLROOT; ?>/resident/dashboard">Resident</a></li>
                    <li><a href="<?php echo URLROOT; ?>/security/dashboard">Security</a></li>
                    <li><a href="<?php echo URLROOT; ?>/maintenance/dashboard">Maintenance</a></li>
                    <li><a href="<?php echo URLROOT; ?>/external/dashboard">External Service Provider</a></li>
                    <li><a href="<?php echo URLROOT; ?>/superadmin/dashboard">Super Admin</a></li>
                </ul>
            </div>
            <div class="right-section" style="background-image: url('<?php echo URLROOT; ?>/public/img/homelogo.jpg');"></div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>