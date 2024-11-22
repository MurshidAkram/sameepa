<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/chats.css">
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

        <main class="chat-main">
            <aside class="chat-sidebar">
                <h2>Chat Options</h2>
                <nav class="chat-nav">
                    <a href="<?php echo URLROOT; ?>/chat/index" class="btn-chat-active">Chats</a>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="btn-chat-search">Find Users</a>
                    <a href="<?php echo URLROOT; ?>/chat/requests" class="btn-chat-requests active">Chat Requests</a>
                </nav>
            </aside>

            <div class="chat-content">
                <div class="chat-header">
                    <h1>Chat Requests</h1>
                </div>

                <div class="chat-requests-list">
                    <!-- Chat Request Item Template -->
                    <div class="chat-request-item">
                        <div class="request-user-avatar">
                            <img src="<?php echo URLROOT; ?>/img/user-avatar.png" alt="User Avatar">
                        </div>
                        <div class="request-user-info">
                            <h3 class="request-user-name">Michael Johnson</h3>
                            <p class="request-timestamp">Requested 2 hours ago</p>
                        </div>
                        <div class="request-actions">
                            <button class="btn-accept-request">Accept</button>
                            <button class="btn-decline-request">Decline</button>
                        </div>
                    </div>

                    <!-- More chat request items would be dynamically populated -->
                </div>

                <?php if (empty($data['requests'])): ?>
                    <div class="no-requests">
                        <p>No pending chat requests.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>