<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/chats.css">
    <title>Find Users | <?php echo SITENAME; ?></title>
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

        <main class="chat-main">
            <aside class="chat-sidebar">
                <h2>Chat Options</h2>
                <nav class="chat-nav">
                    <a href="<?php echo URLROOT; ?>/chat/index" class="btn-chat-active">Chats</a>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="btn-chat-search active">Find Users</a>
                    <a href="<?php echo URLROOT; ?>/chat/requests" class="btn-chat-requests">Chat Requests</a>
                </nav>
            </aside>

            <div class="chat-content">
                <div class="chat-header">
                    <h1>Find Users</h1>
                    <div class="chat-search-container">
                        <input type="text" placeholder="Search users by name, role..." class="chat-search-input">
                        <button class="chat-search-btn"><i class="fas fa-search"></i></button>
                    </div>
                </div>

                <div class="users-search-filters">
                    <select class="user-role-filter">
                        <option value="">All Roles</option>
                        <option value="1">Residents</option>
                        <option value="2">Admins</option>
                        <option value="3">Super Admins</option>
                    </select>
                </div>

                <div class="users-list">
                    <!-- User Search Result Template -->
                    <div class="user-search-item">
                        <div class="user-avatar">
                            <img src="<?php echo URLROOT; ?>/img/user-avatar.png" alt="User Avatar">
                        </div>
                        <div class="user-info">
                            <h3 class="user-name">Murshid</h3>
                            <p class="user-role">Resident</p>
                        </div>
                        <div class="user-actions">
                            <button class="btn-start-chat">Start Chat</button>
                        </div>
                    </div>

                    <!-- More user search results would be dynamically populated -->
                </div>

                <?php if (empty($data['users'])): ?>
                    <div class="no-users">
                        <p>No users found. Try a different search.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>