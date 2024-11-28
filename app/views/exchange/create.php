
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/exchange/create.css">
    <title>Create Listing | <?php echo SITENAME; ?></title>
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
            <div class="create-listing-container">
                <a href="<?php echo URLROOT; ?>/exchange/index" class="back-button">
                    <i class="fas fa-arrow-left"></i> Back to Listings
                </a>
                
                <h1>Create New Listing</h1>
                
                <form action="<?php echo URLROOT; ?>/exchange/create" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Listing Title:</label>
                        <input type="text" name="title" id="title" required maxlength="255" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="type">Listing Type:</label>
                        <select name="type" id="type" required class="form-control">
                            <option value="service">Service</option>
                            <option value="sale">For Sale</option>
                            <option value="exchange">Exchange</option>
                            <option value="lost">Lost & Found</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" rows="6" required class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price (if applicable):</label>
                        <input type="number" name="price" id="price" min="0" step="0.01" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="image">Listing Image:</label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif" class="form-control">
                        <small class="form-text">Allowed formats: JPG, PNG, GIF (Max size: 5MB)</small>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-submit">Create Listing</button>
                        <a href="<?php echo URLROOT; ?>/exchange/index" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>
