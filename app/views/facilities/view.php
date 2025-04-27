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

                    <?php if (!empty($data['facility']['image_data'])): ?>
                    <div class="facility-image">
                        <img src="<?php echo URLROOT; ?>/facilities/getImage/<?php echo $data['facility']['id']; ?>" 
                            alt="<?php echo $data['facility']['name']; ?>">
                    </div>
                    <?php endif; ?>

                    <div class="facility-info">
                        <div class="facility-description">
                            <h4>Description</h4>
                            <p><?php echo $data['facility']['description']; ?></p>
                        </div>

                        <div class="facility-metadata">
                            <p><strong>Capacity:</strong> <?php echo $data['facility']['capacity']; ?> people</p>
                            <p><strong>Created By:</strong> <?php echo $data['facility']['creator_name']; ?></p>
                        </div>
                        
                        <?php if (in_array($_SESSION['user_role_id'], [2, 3])): ?>
                            <div class="admin-actions">
                                <a href="<?php echo URLROOT; ?>/facilities/edit/<?php echo $data['facility']['id']; ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit Facility
                                </a>
                                <form action="<?php echo URLROOT; ?>/facilities/delete/<?php echo $data['facility']['id']; ?>" method="POST" style="display: inline;">
                                    <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this facility?')">
                                        <i class="fas fa-trash"></i> Delete Facility
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>
