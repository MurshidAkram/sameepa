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
            <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['message']) . '</div>';
                unset($_SESSION['message']);
            }

            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }
            ?>

            <h1>Product and Resource Exchange Center</h1>
            <p>Connect with your community! Offer services, sell or exchange products, or report lost and found items.</p>

            <div class="exchange-actions">
                <a href="<?php echo URLROOT; ?>/resident/create_listing" class="btn-create-listing">Create Listing</a>
                <a href="<?php echo URLROOT; ?>/resident/my_listing" class="btn-my-listings">My Listings</a>
            </div>

            <div class="exchange-grid">
                <?php foreach ($data['listings'] as $listing): ?>
                    <div class="listing-card">
                        <div class="listing-image">
                            <img src="<?php echo URLROOT; ?>/Resident/image/<?php echo $listing->id; ?>"
                                 alt="<?php echo htmlspecialchars($listing->title); ?>"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="listing-details">
                            <h3 class="listing-title"><?php echo htmlspecialchars($listing->title); ?></h3>
                            <span class="listing-type"><?php echo htmlspecialchars($listing->type); ?></span>
                            <span class="listing-date"><?php echo date('M d, Y', strtotime($listing->date_posted)); ?></span>
                            <!-- <span class="listing-posted"><?php echo htmlspecialchars($listing->posted_by_name); ?></span> -->
                            <button class="btn-view-listing" 
                                 data-image="<?php echo URLROOT; ?>/Resident/image/<?php echo $listing->id; ?>"
                                 data-title="<?php echo htmlspecialchars($listing->title); ?>"
                                 data-description="<?php echo htmlspecialchars($listing->description); ?>"
                                 data-type="<?php echo htmlspecialchars($listing->type); ?>"
                                 data-date="<?php echo htmlspecialchars($listing->date_posted); ?>"
                                 data-postedby="<?php echo htmlspecialchars($listing->posted_by_name); ?>"
                                                onclick="openModal(this)">View Details</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="modal-overlay"></div>
    <div class="modal" id="modal">
        <span class="modal-close" onclick="closeModal()">×</span>
        <div class="modal-header" id="modal-title"></div>
        <div class="modal-body">
            <p id="modal-description"></p>
            <p><strong></strong> <span id="modal-tit"></span></p>
            <img id="modal-image" src="" alt="" style="width: 100%; max-height: 250px; object-fit: cover; margin-bottom: 15px;">
            <p><strong>Description:</strong> <span id="modal-desc"></span></p>
            <p><strong>Type:</strong> <span id="modal-type"></span></p>
            <p><strong>Date Posted:</strong> <span id="modal-date"></span></p>
            <p><strong>Posted By:</strong> <span id="modal-post"></span></p>
            
        </div>
    </div>

    <script>
function openModal(button) {
    document.getElementById('modal-tit').textContent = button.dataset.title;
    document.getElementById('modal-desc').textContent = button.dataset.description;
    document.getElementById('modal-type').textContent = button.dataset.type;
    document.getElementById('modal-date').textContent = new Date(button.dataset.date).toLocaleDateString();
    document.getElementById('modal-post').textContent = button.dataset.postedby;
    document.getElementById('modal-image').src = button.dataset.image;
    
    document.getElementById('modal').style.display = 'block';
    document.getElementById('modal-overlay').style.display = 'block';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
    document.getElementById('modal-overlay').style.display = 'none';
}
</script>



    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>
