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
        switch ($_SESSION['user_role_id']) {
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
                <a href="<?php echo ($_SESSION['user_role_id'] == 2) ? URLROOT . '/exchange/admin_dashboard' : URLROOT . '/exchange/index'; ?>" class="back-button">
                    <i class="fas fa-arrow-left"></i> Back to <?php echo ($_SESSION['user_role_id'] == 2) ? 'Admin Dashboard' : 'Listings'; ?>
                </a>

                <?php if (!empty($data['listing'])) :
                    $listing = $data['listing'];
                    // Remove the var_dump from the controller as it's causing output issues
                ?>
                    <div class="listing-full-view">
                        <div class="listing-header">
                            <h1 class="listing-title"><?php echo htmlspecialchars($listing['title']); ?></h1>
                            <div class="service-box">
                                <span class="listing-type"><?php echo ucfirst($listing['type']); ?></span>
                            </div>
                        </div>

                        <div class="listing-image-container">
                            <?php if (isset($listing['image_data']) && !empty($listing['image_data'])) : ?>
                                <img src="<?php echo URLROOT; ?>/exchange/image/<?php echo $listing['id']; ?>" alt="<?php echo htmlspecialchars($listing['title']); ?>" class="listing-full-image">
                            <?php else : ?>
                                <img src="<?php echo URLROOT; ?>/img/default.png" alt="No image available" class="listing-full-image">
                            <?php endif; ?>
                        </div>

                        <div class="listing-info">
                            <div class="listing-description">
                                <h3>Description</h3>
                                <p><?php echo nl2br(htmlspecialchars($listing['description'])); ?></p>
                            </div>

                            <div class="listing-metadata">
                                <p><strong>Posted by:</strong> <?php echo isset($listing['posted_by_name']) ? htmlspecialchars($listing['posted_by_name']) : 'Unknown'; ?></p>
                                <p><strong>Posted on:</strong> <?php echo date('F j, Y', strtotime($listing['date_posted'])); ?></p>
                            </div>

                            <div class="listing-contact">
                                <h3>Contact Information</h3>
                                <div class="listing-contact">
                                    <button class="btn-primary contact-seller" onclick="window.location.href='<?php echo URLROOT; ?>/exchange/contact_seller/<?php echo $listing['id']; ?>'">
                                        Contact Seller
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="no-listings">
                            <p>No listing found.</p>
                        </div>
                    <?php endif; ?>
                    </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>