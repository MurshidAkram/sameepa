<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/exchange/edit_listing.css">
    <title>Edit Listing | <?php echo SITENAME; ?></title>
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

        <main class="exchange-main">
            <div class="edit-listing-container">
                <a href="<?php echo ($_SESSION['user_role_id'] == 2) ? URLROOT . '/exchange/admin_dashboard' : URLROOT . '/exchange/my_listings'; ?>" class="back-button">
                    <i class="fas fa-arrow-left"></i> Back to <?php echo ($_SESSION['user_role_id'] == 2) ? 'Admin Dashboard' : 'My Listings'; ?>
                </a>
              
                <h1>Edit Listing</h1>
                
                <form action="<?php echo URLROOT; ?>/exchange/edit" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Listing Title:</label>
                        <input type="text" name="title" id="title" value="Professional Lawn Mowing Service" required maxlength="255" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="type">Listing Type:</label>
                        <select name="type" id="type" required class="form-control">
                            <option value="service" selected>Service</option>
                            <option value="sale">For Sale</option>
                            <option value="exchange">Exchange</option>
                            <option value="lost">Lost & Found</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" rows="6" required class="form-control">Weekend lawn mowing service available. Professional equipment and reliable service.</textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price (if applicable):</label>
                        <input type="number" name="price" id="price" value="30" min="0" step="0.01" class="form-control">
                    </div>

                    <div class="current-image">
                        <label>Current Image:</label>
                        <img src="<?php echo URLROOT; ?>/img/lawn-mower.jpg" alt="Current listing image">
                    </div>

                    <div class="form-group">
                        <label for="image">Update Image:</label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif" class="form-control">
                        <small class="form-text">Leave empty to keep current image. Allowed formats: JPG, PNG, GIF (Max size: 5MB)</small>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-submit">Save Changes</button>
                            <a href="<?php echo ($_SESSION['user_role_id'] == 2) ? URLROOT . '/exchange/admin_dashboard' : URLROOT . '/exchange/index'; ?>" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>
