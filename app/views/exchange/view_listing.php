<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/exchange/view_listing.css">
    <title>View Listing | <?php echo SITENAME; ?></title>
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

        <main class="exchange-main">
            <div class="listing-details-container">
                <a href="<?php echo URLROOT; ?>/exchange/index" class="btn-back">← Back to Listings</a>
                
                <div class="listing-full-view">
                    <div class="listing-header">
                        <h1>Lawn Mowing Service</h1>
                        <div class="service-box">
                            <span class="listing-type">Service</span>
                        </div>
                    </div>

                    <div class="listing-image-container">
                        <img src="<?php echo URLROOT; ?>/img/lawn-mower.jpg" 
                             alt="Lawn Mowing Service" 
                             class="listing-full-image">
                    </div>

                    <div class="listing-info">
                        <div class="listing-description">
                            <h3>Description</h3>
                            <p>Professional lawn mowing service available on weekends. Please contact.</p>
                        </div>

                        <div class="listing-metadata">
                            <p><strong>Posted by:</strong> John Doe</p>
                            <p><strong>Posted on:</strong> 2023-07-10</p>
                        </div>

                        <div class="listing-contact">
                            <h3>Contact Information</h3>
                            <button class="btn-primary contact-seller" onclick="window.location.href='<?php echo URLROOT; ?>/exchange/contact_seller'">
                                Contact Seller
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>