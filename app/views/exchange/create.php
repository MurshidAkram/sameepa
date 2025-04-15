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
                <a href="<?php echo ($_SESSION['user_role_id'] == 2) ? URLROOT . '/exchange/admin_dashboard' : URLROOT . '/exchange/index'; ?>" class="back-button">
                    <i class="fas fa-arrow-left"></i> Back to <?php echo ($_SESSION['user_role_id'] == 2) ? 'Admin Dashboard' : 'Listings'; ?>
                </a>

                <h1><?php echo isset($data['id']) ? 'Update listing' : 'Create'; ?> New Listing</h1>
                
                <form 
                    action="<?php echo isset($data['id']) ? URLROOT . '/exchange/update_listing' : URLROOT . '/exchange/create'; ?>" 
                    method="POST" 
                    enctype="multipart/form-data" 
                    class="create-listing-form"
                >
                    <?php if (isset($data['id'])): ?>
                        <input type="hidden" name="listing_id" value="<?php echo $data['id']; ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="title">Listing Title:</label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               class="form-control"
                               placeholder="Enter the listing title"
                               value="<?php echo isset($data['title']) ? htmlspecialchars($data['title']) : ''; ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="service" <?php echo (isset($data['type']) && $data['type'] == 'service') ? 'selected' : ''; ?>>Service</option>
                            <option value="sale" <?php echo (isset($data['type']) && $data['type'] == 'sale') ? 'selected' : ''; ?>>Sale</option>
                            <option value="exchange" <?php echo (isset($data['type']) && $data['type'] == 'exchange') ? 'selected' : ''; ?>>Exchange</option>
                            <option value="lost" <?php echo (isset($data['type']) && $data['type'] == 'lost') ? 'selected' : ''; ?>>Lost</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" 
                                  name="description" 
                                  class="form-control" 
                                  rows="5"
                                  placeholder="Enter a detailed description"
                                  required><?php echo isset($data['description']) ? htmlspecialchars($data['description']) : ''; ?></textarea>
                    </div>

                    <!-- Optional Price Field -->
                    <!--
                    <div class="form-group">
                        <label for="price">Price (LKR):</label>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               class="form-control"
                               placeholder="Enter the price in LKR"
                               min="0"
                               step="0.01"
                               value="<?php echo isset($data['price']) ? htmlspecialchars($data['price']) : ''; ?>">
                    </div>
                    -->

                    <div class="form-group">
                        <label for="image">Image:</label>
                        <?php if(isset($data['id'])): ?>
                            <div class="current-image">
                                <img src="<?php echo URLROOT; ?>/exchange/image/<?php echo $data['id']; ?>" alt="Current listing image" style="max-width: 200px;">
                            </div>
                            <p>Upload new image (leave empty to keep current):</p>
                        <?php endif; ?>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*" <?php echo !isset($data['id']) ? 'required' : ''; ?>>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <?php echo isset($data['id']) ? 'Update Listing' : 'Submit Listing'; ?>
                        </button>
                        
                        <a href="<?php echo isset($data['id']) ? URLROOT . '/exchange/my_listings' : URLROOT . '/exchange/index'; ?>" class="btn-cancel">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>
