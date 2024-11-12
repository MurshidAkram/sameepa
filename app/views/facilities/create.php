<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
    <title>Create Facility | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    
    <div class="dashboard-container">
        <?php 
        // Load appropriate side panel based on user role
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

        <main class="content">
            <div class="create-facility-container">
                <h1>Create New Facility</h1>
                
                <?php if(!empty($data['errors'])): ?>
                    <div class="error-messages">
                        <?php foreach($data['errors'] as $error): ?>
                            <div class="error-message"><?php echo $error; ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo URLROOT; ?>/facilities/create" method="POST">
                    <div class="form-group">
                        <label for="name">Facility Name:</label>
                        <input type="text" name="name" id="name" value="<?php echo $data['name']; ?>" 
                               required maxlength="255" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" rows="6" required 
                                  class="form-control"><?php echo $data['description']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="capacity">Capacity:</label>
                        <input type="number" name="capacity" id="capacity" value="<?php echo $data['capacity']; ?>" 
                               required min="1" class="form-control">
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-submit">Create Facility</button>
                        <a href="<?php echo URLROOT; ?>/facilities" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>