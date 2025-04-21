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
                    <?php if (!empty($data['listings'])) : ?>
                        <?php foreach ($data['listings'] as $listing) : ?>
                            <div class="listing-card">
                                <div class="listing-image">
                                    <?php if (!empty($listing->image_data)) : ?>
                                        <img src="<?php echo URLROOT; ?>/exchange/image/<?php echo $listing->id; ?>" alt="<?php echo htmlspecialchars($listing->title); ?>">
                                    <?php else : ?>
                                        <img src="<?php echo URLROOT; ?>/img/default.png" alt="No image available">
                                    <?php endif; ?>
                                    <span class="listing-status active">Active</span>
                                </div>
                                <div class="listing-content">
                                    <h2><?php echo htmlspecialchars($listing->title); ?></h2>
                                    <p class="listing-type"><?php echo ucfirst(htmlspecialchars($listing->type)); ?></p>
                                    <p class="listing-description">
                                        <?php echo htmlspecialchars(substr($listing->description, 0, 100)) . (strlen($listing->description) > 100 ? '...' : ''); ?>
                                    </p>
                                    <div class="listing-meta">
                                        <span><i class="far fa-calendar"></i> Posted: <?php echo date('F j, Y', strtotime($listing->date_posted)); ?></span>
                                    </div>
                                    <div class="listing-actions">
                                        <form method="POST" action="<?php echo URLROOT; ?>/exchange/view_listing/<?php echo $listing->id; ?>" style="display:inline;">
                                            <button type="submit" class="btn-view">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        </form>

                                        <form method="GET" action="<?php echo URLROOT; ?>/exchange/update_listing" style="display:inline;">
                                            <input type="hidden" name="listing_id" value="<?php echo $listing->id; ?>">
                                            <button type="submit" class="btn-edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        </form>



                                        <form method="POST" action="<?php echo URLROOT; ?>/exchange/delete" class="delete-form" style="display:inline;">
                                            <input type="hidden" name="listing_id" value="<?php echo $listing->id; ?>">
                                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this listing?');">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="no-listings">
                            <p>You haven't created any listings yet.</p>
                            <a href="<?php echo URLROOT; ?>/exchange/create_listing" class="btn-primary">Create Your First Listing</a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>