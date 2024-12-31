<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/chats.css">
    <title>Chat | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        // Load appropriate side panel based on user role
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
                    <a href="<?php echo URLROOT; ?>/chat/index" class="btn-chat-active active">Chats</a>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="btn-chat-search">Find Users</a>
                    <a href="<?php echo URLROOT; ?>/chat/requests" class="btn-chat-requests">Chat Requests</a>

                </nav>
            </aside>

            <div class="chat-content">
                <div class="chat-header">
                    <h1>My Chats</h1>
                    <div class="chat-search-container">
                        <input type="text" placeholder="Search chats..." class="chat-search-input">
                        <button class="chat-search-btn"><i class="fas fa-search"></i></button>
                    </div>
                </div>

                <div class="chats-list">
                    <div class="chat-list-item">
                        <div class="chat-user-avatar">
                            <img src="<?php echo URLROOT; ?>/img/user-avatar.png" alt="User Avatar">
                        </div>
                        <div class="chat-user-info">
                            <h3 class="chat-user-name">Mr. Kamal</h3>
                            <p class="chat-last-message">Good Morning neighbour!</p>
                        </div>
                        <div class="chat-metadata">
                            <span class="chat-timestamp">2:30 PM</span>
                        </div>
                        <div class="chat-actions">
                            <button class="btn-chat-delete"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>

                <?php if (empty($data['chats'])): ?>
                    <div class="no-chats">
                        <p>No active chats.</p>
                        <a href="<?php echo URLROOT; ?>/chat/search" class="btn-start-chat">Find Users</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>