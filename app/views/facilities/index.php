<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/facilities/facilities.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/facilities/view_facility.css">
    <title>Facilities | <?php echo SITENAME; ?></title>
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
        <main class="facilities-main">
            <h1>Facility Management</h1>
            <div class="action-buttons">
                <a href="<?php echo URLROOT; ?>/facilities/allmybookings" class="fac-btn-bookings">My Bookings</a>
            </div>
                                    
            <div class="facilities-grid">
                <?php foreach($data['facilities'] as $facility): ?>
                    <div class="facility-card">
                    <a href="<?php echo URLROOT; ?>/facilities/viewFacility/<?php echo $facility->id; ?>" class="fac-btn-view">View Details</a>
                        <div class="facility-image">
                            <?php if(isset($facility->image_data) && $facility->image_data): ?>
                                <img src="data:<?php echo $facility->image_type; ?>;base64,<?php echo base64_encode($facility->image_data); ?>" alt="<?php echo $facility->name; ?>">
                            <?php else: ?>
                                <img src="<?php echo URLROOT; ?>/img/facility-placeholder.jpg" alt="Facility placeholder">
                            <?php endif; ?>
                            <div class="status-badge">
                                <span class="facility-status <?php echo strtolower($facility->status); ?>">
                                    <?php echo $facility->status; ?>
                                </span>
                            </div>
                        </div>
                        <div class="facility-content">
                            <h3><?php echo $facility->name; ?></h3>
                            <div class="facility-description">
                                <p><?php echo $facility->description; ?></p>
                            </div>
                            <div class="facility-metadata">
                                <p><strong>Capacity:</strong> <?php echo $facility->capacity; ?></p>
                            </div>
                            <div class="facility-actions">
                                <?php if($facility->status == 'available'): ?>
                                    <a href="<?php echo URLROOT; ?>/facilities/book/<?php echo $facility->id; ?>" class="fac-btn-book">Book Now</a>
                                <?php else: ?>
                                    <button disabled class="fac-btn-book unavailable">Unavailable</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
      </div>

      <?php require APPROOT . '/views/inc/components/footer.php'; ?>
      <script>
    document.addEventListener('DOMContentLoaded', function() {
        const descriptions = document.querySelectorAll('.facility-description p');
        
        descriptions.forEach(p => {
            if (p.scrollHeight > p.offsetHeight) {
                p.insertAdjacentHTML('beforeend', '<span style="position: absolute; right: 0; bottom: 0; background: white; padding-left: 4px;">...</span>');
            }
        });
    });
</script>

  </body>
  </html>
