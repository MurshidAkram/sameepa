<!-- app/views/resident/exchange.php -->
<!-- app/views/resident/create_listing.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/create_listing.css">
    <title><?php echo isset($data['id']) ? 'Update' : 'Create'; ?> Listing | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="create-listing-main">
            <h1><?php echo isset($data['id']) ? 'Update Listing' : 'Create a New Listing'; ?></h1>
            <p><?php echo isset($data['id']) ? 'Update your listing information below.' : 'Fill out the form below to add a new listing to the exchange center.'; ?></p>

            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>

            <form action="<?php echo isset($data['id']) ? URLROOT . '/resident/update_listing' : URLROOT . '/resident/create_listing'; ?>" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="create-listing-form">
                
                <?php if(isset($data['id'])): ?>
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

                <div class="form-group">
               <label for="image">Image:</label>
               <?php if(isset($data['id'])): ?>
                 <div class="current-image">
                 <img src="<?php echo URLROOT; ?>/Resident/image/<?php echo $data['id']; ?>" alt="Current listing image" style="max-width: 200px;">
                 </div>
                  <p>Upload new image (leave empty to keep current):</p>
                <?php endif; ?>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*" <?php echo !isset($data['id']) ? 'required' : ''; ?>>
               </div>

                <button type="submit" class="btn-submit">
                    <?php echo isset($data['id']) ? 'Update Listing' : 'Submit Listing'; ?>
                </button>
            </form>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>