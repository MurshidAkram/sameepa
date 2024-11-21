<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/facilities/facility_view.css">
    <title><?php echo $data['facility']['name']; ?> | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="facility-view-container">
        <a href="<?php echo URLROOT; ?>/facilities" class="back-button">
            <i class="fas fa-arrow-left"></i> Back to Facilities
        </a>

        <div class="facility-view-content">
            <div class="facility-details-section">
                <h1 class="facility-title"><?php echo $data['facility']['name']; ?></h1>
                
                <div class="facility-meta">
                    <div class="meta-item">
                        <i class="fas fa-users"></i>
                        <span>Capacity: <?php echo $data['facility']['capacity']; ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-info-circle"></i>
                        <span>Status: <?php echo $data['facility']['status']; ?></span>
                    </div>
                </div>

                <div class="facility-description">
                    <h2>About This Facility</h2>
                    <p><?php echo nl2br($data['facility']['description']); ?></p>
                </div>

                <?php if($_SESSION['user_role_id'] == 2): ?>
                    <a href="<?php echo URLROOT; ?>/facilities/edit/<?php echo $data['facility']['id']; ?>" class="btn-edit">Edit Facility</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>
