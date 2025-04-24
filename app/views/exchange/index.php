<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/exchange/exchange.css?v=1.1">
    <title>Exchange Center | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        // Load appropriate side panel based on user role
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
            <h1>Product and Resource Exchange Center</h1>
            <p>Connect with your community! Offer services, sell or exchange products, or report lost and found items.</p>

            <div class="exchange-actions">
                <a href="<?php echo URLROOT; ?>/exchange/create" class="btn-create-listing">Create Listing</a>
                <a href="<?php echo URLROOT; ?>/exchange/my_listings" class="btn-my-listings">My Listings</a>
            </div>

            <!-- <form class="groups-search" method="GET" action="<?php echo URLROOT; ?>/exchange/index">
                    <input type="text" name="search" placeholder="Search listings...">
                    <button type="submit">Search</button>
                </form> -->

            <div class="exchange-grid">
                <?php if (!empty($data['listings'])) : ?>
                    <?php foreach ($data['listings'] as $listing) : ?>
                        <div class="listing-card <?php echo $listing->type; ?>">
                            <?php if (!empty($listing->image_data)) : ?>
                                <img src="<?php echo URLROOT; ?>/exchange/image/<?php echo $listing->id; ?>" alt="<?php echo $listing->title; ?>" class="listing-image">
                            <?php else : ?>
                                <img src="<?php echo URLROOT; ?>/img/default.png" alt="No image available" class="listing-image">
                            <?php endif; ?>
                            <h2 class="listing-title"><?php echo $listing->title; ?></h2>
                            <p class="listing-description"><?php echo $listing->description; ?></p>
                            <div class="listing-details">
                                <p>Type: <span class="listing-type"><?php echo ucfirst($listing->type); ?></span></p>
                                <p>Posted on: <?php echo date('Y-m-d', strtotime($listing->date_posted)); ?></p>
                                <p>By: <?php echo $listing->posted_by_name; ?></p>
                            </div>
                            <div class="listing-actions">
    <a href="<?php echo URLROOT; ?>/exchange/view_listing/<?php echo $listing->id; ?>" class="btn-view-listing">View Listing</a>

    <?php if (in_array($_SESSION['user_role_id'], [ 3])):  ?>
            <form action="<?php echo URLROOT; ?>/exchange/adminDeletion/<?php echo $listing->id; ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?');" style="display: inline;">
                <button type="submit" class="btn-delete-listing"><i class="fas fa-trash-alt"></i></button>
            </form>
        <?php endif; ?>
</div>



                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="no-listings">
                        <p>No listings available at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>