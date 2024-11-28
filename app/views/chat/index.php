<!-- app/views/chat/index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>Chats | <?php echo SITENAME; ?></title>
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
                    <a href="<?php echo URLROOT; ?>/chat/index" class="btn-creates-group">My Chats</a>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="btn-views-group">Search Users</a>
                    <a href="<?php echo URLROOT; ?>/chat/requests" class="btn-joined-groups">Chat Requests</a>
                    <a href="<?php echo URLROOT; ?>/chat/report" class="btn-views-members">Report</a>
                </nav>
            </aside>

            <div class="groups-content">
                <h1>My Chats</h1>
                <form class="groups-search" method="GET" action="<?php echo URLROOT; ?>/chat">
                    <input type="text" name="search" placeholder="Search chats...">
                    <button type="submit">Search</button>
                </form>
                <p>Connect and communicate with residents, admins, and community members!</p>

                <div class="groups-grid">
                    <!-- Chat Card Template -->
                    <div class="group-card">
                        <div class="group-image">
                            <img src="<?php echo URLROOT; ?>/img/default-user.jpg" alt="Chat with John Doe">
                        </div>
                        <div class="group-details">
                            <h3 class="group-title">Mr. Sunil</h3>
                            <div class="group-info">
                                <p class="group-category">
                                    <i class="fas fa-user-tag"></i>
                                    Resident
                                </p>
                                <p class="group-creator">
                                    <i class="fas fa-clock"></i>
                                    Last Message: 2 hours ago
                                </p>
                            </div>
                            <div class="group-actions">
                                <span class="member-count">
                                    <i class="fas fa-envelope"></i>
                                    3 Unread
                                </span>
                                <a href="<?php echo URLROOT; ?>/chat/viewchat/1" class="btn-view-group">View Chat</a>
                            </div>
                        </div>
                    </div>

                    <!-- Repeat similar chat card structures for other chats -->
                </div>

                <!-- No Chats Placeholder -->
                <div class="no-groups" style="display: none;">
                    <p>No active chats yet.</p>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="btn-view-group">Start a New Chat</a>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>