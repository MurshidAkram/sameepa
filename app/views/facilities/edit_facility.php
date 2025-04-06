<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/facilities/edit_facility.css">
    <title>Edit Facility | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    
    <div class="dashboard-container">
        <?php 
        switch($_SESSION['user_role_id']) {
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>

        <main class="facility-main">
            <div class="edit-facility-container">
                <a href="<?php echo URLROOT; ?>/facilities/admin_dashboard" class="back-button">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
              
                <h1>Edit Facility</h1>
                
                <form action="<?php echo URLROOT; ?>/facilities/edit/<?php echo $data['facility']['id']; ?>" method="POST" class="facility-form">
                    <div class="form-group">
                        <label for="name">Facility Name:</label>
                        <input type="text" name="name" id="name" value="<?php echo $data['facility']['name']; ?>" required maxlength="255" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" rows="6" required class="form-control"><?php echo $data['facility']['description']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="capacity">Capacity:</label>
                        <input type="number" name="capacity" id="capacity" value="<?php echo $data['facility']['capacity']; ?>" min="1" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select name="status" id="status" required class="form-control">
                            <option value="available" <?php echo $data['facility']['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
                            <option value="unavailable" <?php echo $data['facility']['status'] == 'unavailable' ? 'selected' : ''; ?>>Unavailable</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="facility_image">Facility Image:</label>
                        <?php if (!empty($data['facility']['image_path'])): ?>
                            <div class="current-image">
                                <img src="<?php echo URLROOT . '/' . $data['facility']['image_path']; ?>" 
                                    alt="Current facility image" style="max-width: 200px;">
                                <p>Current image</p>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="facility_image" id="facility_image" class="form-control">
                        <small class="form-text text-muted">Upload a new image to replace the current one (JPG, PNG, GIF)</small>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-submit">Save Changes</button>
                        <a href="<?php echo URLROOT; ?>/facilities/admin_dashboard" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>
