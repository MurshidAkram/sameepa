<!-- app/views/chat/requests.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">

    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>Chat Requests | <?php echo SITENAME; ?></title>
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
                <h2>Chat Navigation</h2>
                <nav class="groups-nav">
                    <a href="<?php echo URLROOT; ?>/chat/index" class="btn-createds-group">My Chats</a>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="btn-views-group">Search Users</a>
                    <a href="<?php echo URLROOT; ?>/chat/requests" class="btn-joineds-groups">Chat Requests</a>
                    <a href="<?php echo URLROOT; ?>/chat/report" class="btn-views-members">Report</a>
                </nav>
            </aside>

            <div class="groups-content">
                <h1>Chat Requests</h1>
                <p>Pending and incoming chat invitations.</p>

                <div class="groups-grid">
                    <!-- Chat Request Card Template -->
                    <div class="group-card">
                        <div class="group-image">
                            <img src="<?php echo URLROOT; ?>/img/default-user.jpg" alt="Jane Smith">
                        </div>
                        <div class="group-details">
                            <h3 class="group-title">Mrs. Jeewa</h3>
                            <div class="group-info">
                                <p class="group-category">
                                    <i class="fas fa-user-tag"></i>
                                    Admin
                                </p>
                                <p class="group-creator">
                                    <i class="fas fa-clock"></i>
                                    Requested: 3 hours ago
                                </p>
                            </div>
                            <div class="group-actions">
                                <a href="<?php echo URLROOT; ?>/chat/accept/1" class="btn-update-group">Accept</a>
                                <a href="<?php echo URLROOT; ?>/chat/decline/1" class="btn-delete-group">Decline</a>
                            </div>
                        </div>
                    </div>

                    <!-- Repeat similar chat request card structures -->
                </div>

                <!-- No Requests Placeholder -->
                <div class="no-groups">
                    <p>No pending chat requests.</p>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="btn-view-group">Find Users to Chat</a>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>