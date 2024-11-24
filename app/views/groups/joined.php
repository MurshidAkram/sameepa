
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>Joined Groups | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        switch ($_SESSION['user_role_id']) {
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

        <main class="groups-main">
            <aside class="groups-sidebar">
                <h2>Group Navigation</h2>
                <nav class="groups-nav">
                    <a href="<?php echo URLROOT; ?>/groups/index" class="btn-created-group">Groups</a>
                    <a href="<?php echo URLROOT; ?>/groups/create" class="btn-created-group">Create Group</a>
                    <a href="<?php echo URLROOT; ?>/groups/joined" class="btn-joined-groups active">Joined Groups</a>
                    <a href="<?php echo URLROOT; ?>/groups/my_groups" class="btn-my-groups">My Groups</a>
                </nav>
            </aside>

            <div class="groups-content">
                <h1>My Joined Groups</h1>
                <p>Here are all the groups you've joined!</p>

                <div class="groups-grid">
                    <div class="group-card">
                        <div class="group-image">
                            <img src="<?php echo URLROOT; ?>/img/default-group.jpg" alt="Book Club">
                        </div>
                        <div class="group-details">
                            <h3 class="group-title">Book Club</h3>
                            <div class="group-info">
                                <p class="group-category">
                                    <i class="fas fa-tag"></i>
                                    Literature
                                </p>
                                <p class="group-creator">
                                      <i class="fas fa-user"></i>
                                      By John Doe
                                </p>
                            </div>
                            <div class="group-actions">
                                <span class="member-count">
                                    <i class="fas fa-users"></i>
                                    15 Members
                                </span>
                                <a href="<?php echo URLROOT; ?>/groups/viewgroup/1" class="btn-view-group">View Group</a>
                            </div>
                        </div>
                    </div>
                    <div class="group-card">
                          <div class="group-image">
                              <img src="<?php echo URLROOT; ?>/img/default-group2.jpg" alt="Fitness Warriors">
                          </div>
                          <div class="group-details">
                              <h3 class="group-title">Fitness Warriors</h3>
                              <div class="group-info">
                                  <p class="group-category">
                                      <i class="fas fa-tag"></i>
                                      Health
                                  </p>
                                  <p class="group-creator">
                                      <i class="fas fa-user"></i>
                                      By Sarah Wilson
                                  </p>
                              </div>
                              <div class="group-actions">
                                  <span class="member-count">
                                      <i class="fas fa-users"></i>
                                      28 Members
                                  </span>
                                  <a href="#" class="btn-view-group">View Group</a>
                              </div>
                          </div>
                      </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>
