<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/exchange.css">
    <title>My Listings | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="exchange-main">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['message']); ?></div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <a href="<?php echo URLROOT; ?>/resident/exchange" class="back-button">
                    <i class="fas fa-arrow-left"></i> 
                </a>

            <h1>Product and Resource Exchange Center-My Listings</h1>

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
                            <button class="btn-view-listing" 
                                data-id="<?php echo $listing->id; ?>"
                                data-image="<?php echo URLROOT; ?>/Resident/image/<?php echo $listing->id; ?>"
                                data-title="<?php echo htmlspecialchars($listing->title); ?>"
                                data-description="<?php echo htmlspecialchars($listing->description); ?>"
                                data-type="<?php echo htmlspecialchars($listing->type); ?>"
                                data-date="<?php echo htmlspecialchars($listing->date_posted); ?>"
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
            
            <!-- Update form -->
            <form action="<?php echo URLROOT; ?>/resident/update_listing" method="get" style="display: inline;">
                <input type="hidden" name="listing_id" id="modal-listing-id">
                <button class="btn-update" type="submit">Update</button>
            </form>

            <!-- Delete form -->
<form action="<?php echo URLROOT; ?>/resident/delete" method="post" style="display: inline;">
    <input type="hidden" name="listing_id" id="modal-delete-id">
    <button class="btn-delete" type="submit" onclick="return confirm('Are you sure you want to delete this listing?');">Delete</button>
</form>

        </div>
    </div>

    <script>
    function openModal(button) {
        const listingId = button.getAttribute('data-id');
        document.getElementById('modal-delete-id').value = listingId;
        document.getElementById('modal-tit').textContent = button.dataset.title;
        document.getElementById('modal-desc').textContent = button.dataset.description;
        document.getElementById('modal-type').textContent = button.dataset.type;
        document.getElementById('modal-date').textContent = new Date(button.dataset.date).toLocaleDateString();
        document.getElementById('modal-image').src = button.dataset.image;
        
        document.getElementById('modal-listing-id').value = listingId;
        document.getElementById('modal-delete-id').value = listingId;
        
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