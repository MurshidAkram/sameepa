<!-- app/views/resident/exchange.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/exchange.css">
    <title>Exchange Center | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="exchange-main">
            <h1>Product and Resource Exchange Center</h1>
            <p>Connect with your community! Offer services, sell or exchange products, or report lost and found items.</p>

            <div class="exchange-actions">
                <a href="<?php echo URLROOT; ?>/resident/create_listing" class="btn-create-listing">Create Listing</a>
                <a href="<?php echo URLROOT; ?>/resident/my_listings" class="btn-my-listings">My Listings</a>
            </div>

            <div class="exchange-grid">
                <?php
                // Dummy listings data
                $listings = [
                    [
                        'id' => 1,
                        'title' => 'Lawn Mowing Service',
                        'type' => 'service',
                        'description' => 'Professional lawn mowing service available on weekends.',
                        'image' => 'lawn-mower.jpg',
                        'date_posted' => '2023-07-10',
                        'posted_by' => 'John Doe'
                    ],
                    [
                        'id' => 2,
                        'title' => 'Vintage Bicycle for Sale',
                        'type' => 'sale',
                        'description' => 'Beautiful vintage bicycle in excellent condition. $150 OBO.',
                        'image' => 'vintage-bike.jpg',
                        'date_posted' => '2023-07-12',
                        'posted_by' => 'Jane Smith'
                    ],
                    [
                        'id' => 3,
                        'title' => 'Book Exchange',
                        'type' => 'exchange',
                        'description' => 'Looking to exchange mystery novels for sci-fi books.',
                        'image' => 'books.jpg',
                        'date_posted' => '2023-07-14',
                        'posted_by' => 'Mike Johnson'
                    ],
                    [
                        'id' => 4,
                        'title' => 'Lost Cat',
                        'type' => 'lost',
                        'description' => 'Orange tabby cat missing since yesterday. Please contact if found.',
                        'image' => 'cat.jpg',
                        'date_posted' => '2023-07-15',
                        'posted_by' => 'Sarah Brown'
                    ]
                ];

                foreach ($listings as $listing) :
                ?>
                    <div class="listing-card <?php echo $listing['type']; ?>">
                        <img src="<?php echo URLROOT; ?>/img/cat.jpeg" alt="<?php echo $listing['title']; ?>" class="listing-image">
                        <h2 class="listing-title"><?php echo $listing['title']; ?></h2>
                        <p class="listing-description"><?php echo $listing['description']; ?></p>
                        <div class="listing-details">
                            <p>Type: <span class="listing-type"><?php echo ucfirst($listing['type']); ?></span></p>
                            <p>Posted on: <?php echo $listing['date_posted']; ?></p>
                            <p>By: <?php echo $listing['posted_by']; ?></p>
                        </div>
                        <a href="<?php echo URLROOT; ?>/resident/listing/<?php echo $listing['id']; ?>" class="btn-view-listing">View Listing</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>