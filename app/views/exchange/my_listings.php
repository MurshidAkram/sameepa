
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/exchange/my_listings.css">
    <title>My Listings | <?php echo SITENAME; ?></title>
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

        <main class="my-listings-main">
            <div class="my-listings-container">
                <a href="<?php echo URLROOT; ?>/exchange/index" class="back-button">
                    <i class="fas fa-arrow-left"></i> Back to Exchange Center
                </a>

                <div class="my-listings-header">
                    <h1>My Listings</h1>
                    <a href="<?php echo URLROOT; ?>/exchange/create" class="btn-new-listing">
                        <i class="fas fa-plus"></i> New Listing
                    </a>
                </div>

                <div class="listings-grid">
                    <!-- First Listing -->
                    <div class="listing-card">
                        <div class="listing-image">
                            <img src="<?php echo URLROOT; ?>/img/lawn-mower.jpg" alt="Lawn Mower">
                            <span class="listing-status active">Active</span>
                        </div>
                        <div class="listing-content">
                            <h2>Professional Lawn Mowing Service</h2>
                            <p class="listing-type">Service</p>
                            <p class="listing-description">Weekend lawn mowing service available. Professional equipment and reliable service.</p>
                            <div class="listing-meta">
                                <span><i class="far fa-calendar"></i> Posted: July 15, 2023</span>
                                <span><i class="far fa-eye"></i> Views: 45</span>
                            </div>
                            <div class="listing-actions">
                                <a href="<?php echo URLROOT; ?>/exchange/view_listing" class="btn-view">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <button class="btn-edit" onclick="window.location.href='<?php echo URLROOT; ?>/exchange/edit_listing'">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- Second Listing -->
                    <div class="listing-card">
                        <div class="listing-image">
                            <img src="<?php echo URLROOT; ?>/img/bookscol.jpg" alt="Books">
                            <span class="listing-status active">Active</span>
                        </div>
                        <div class="listing-content">
                            <h2>Programming Books Collection</h2>
                            <p class="listing-type">Exchange</p>
                            <p class="listing-description">Collection of programming books for exchange. Looking for design books.</p>
                            <div class="listing-meta">
                                <span><i class="far fa-calendar"></i> Posted: July 10, 2023</span>
                                <span><i class="far fa-eye"></i> Views: 32</span>
                            </div>
                            <div class="listing-actions">
                                <button class="btn-view"><i class="fas fa-eye"></i> View</button>
                                <button class="btn-edit"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn-delete"><i class="fas fa-trash"></i> Delete</button>
                            </div>
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
