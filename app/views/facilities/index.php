<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/facilities/facilities.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/facilities/facility_view.css">
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
                        <a href="<?php echo URLROOT; ?>/facilities/viewFacility/<?php echo $facility->id; ?>" class="fac-btn-view">View</a>
                        <h3><?php echo $facility->name; ?></h3>
                        <p><?php echo $facility->description; ?></p>
                        <div class="facility-details">
                            <span><i class="fas fa-users"></i> Capacity: <?php echo $facility->capacity; ?></span>
                            <span><i class="fas fa-info-circle"></i> Status: <?php echo $facility->status; ?></span>
                        </div>
                        <div class="facility-actions">
                            <?php if($facility->status == 'available'): ?>
                                <a href="<?php echo URLROOT; ?>/facilities/book/<?php echo $facility->id; ?>" class="fac-btn-book">Booking</a>
                            <?php else: ?>
                                <button disabled class="fac-btn-book unavailable">Booking</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
      </div>

      <?php require APPROOT . '/views/inc/components/footer.php'; ?>

      <script>
        function showUnavailableMessage() {
            alert('This facility is currently unavailable for booking.');
        }
    </script>

  </body>
  </html>
