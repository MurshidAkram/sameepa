<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/facilities/view_facility.css">
    <title>View Facility | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php 
            // Load appropriate side panel based on user role
            switch($_SESSION['user_role_id']) {
                case 1:
                    require APPROOT . '/views/inc/components/side_panel_resident.php';
                    break;
                case 2:
                    require APPROOT . '/views/inc/components/side_panel_admin.php';
                    break;
                case 3:
                    require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                    break;
            }
        ?>

        <main class="facility-main">
                <?php if ($_SESSION['user_role_id'] == 1): ?>
                    <a href="<?php echo URLROOT; ?>/facilities" class="back-button">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?php echo URLROOT; ?>/facilities/admin_dashboard" class="back-button">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                <?php endif; ?>
            <div class="facility-details-container">                
                <div class="facility-full-view">
                    <div class="facility-header">
                        <h1><?php echo $data['facility']['name']; ?></h1>
                        <div class="status-box">
                            <span class="facility-status <?php echo $data['facility']['status'] == 'available' ? 'available' : 'unavailable'; ?>">
                                <?php echo ucfirst($data['facility']['status']); ?>
                            </span>
                        </div>
                    </div>

                    <div class="facility-info">
                        <div class="facility-description">
                            <h4>Description</h4>
                            <p><?php echo $data['facility']['description']; ?></p>
                        </div>

                        <div class="facility-metadata">
                            <p><strong>Capacity:</strong> <?php echo $data['facility']['capacity']; ?> people</p>
                            <p><strong>Created By:</strong> <?php echo $data['facility']['creator_name']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>
