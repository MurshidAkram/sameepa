<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/events/admin_dashboard.css">
    <title>Admin Dashboard - Events | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        switch ($_SESSION['user_role_id']) {
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>
        <main class="admin-events-main">
            <div class="admin-header">
                <h1>Events Management</h1>
                <div class="search-container">
                    <input type="search" id="searchEvents" placeholder="Search events..." class="search-input">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            
            <div class="admin-actions">
                <a href="<?php echo URLROOT; ?>/events/create" class="btn-create">
                    <i class="fas fa-plus"></i> Create New Event
                </a>
            </div>

              <div class="events-table-container">
                  <div class="table-header">
                      <h2>All Events</h2>
                  </div>

                  <table class="events-table">
                      <thead>
                          <tr>
                              <th onclick="sortTable(0)" style="cursor: pointer;">Event Name ↕</th>
                              <th onclick="sortTable(1)" style="cursor: pointer;">Date ↕</th>
                              <th onclick="sortTable(2)" style="cursor: pointer;">Time ↕</th>
                              <th onclick="sortTable(3)" style="cursor: pointer;">Location ↕</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach($data['events'] as $event): ?>
                              <tr>
                                  <td><?php echo $event->title; ?></td>
                                  <td><?php echo $event->date; ?></td>
                                  <td><?php echo $event->time; ?></td>
                                  <td><?php echo $event->location; ?></td>
                                  <td class="action-buttons">
                                      <a href="<?php echo URLROOT; ?>/events/viewevent/<?php echo $event->id; ?>" class="ebtnview">
                                          <i class="fas fa-eye"></i>
                                      </a>
                                      <a href="<?php echo URLROOT; ?>/events/update/<?php echo $event->id; ?>" class="ebtnedit">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                      <form action="<?php echo URLROOT; ?>/events/admindelete/<?php echo $event->id; ?>" method="post">
                                            <button type="submit" class="ebtndelete" onclick="return confirm('Are you sure you want to delete this facility?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                  </td>
                              </tr>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
              </div>
          </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="<?php echo URLROOT; ?>/js/events_admin.js"></script>
</body>
</html>
