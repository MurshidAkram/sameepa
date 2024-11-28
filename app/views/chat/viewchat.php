<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>View Chat | <?php echo SITENAME; ?></title>
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

        <main class="groups-main group-chat-main">
            <aside class="groups-sidebar">
                <h2>Chat Navigation</h2>
                <nav class="groups-nav">
                    <a href="<?php echo URLROOT; ?>/chat/index" class="btn-creates-group">My Chats</a>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="btn-views-group">Search Users</a>
                    <a href="<?php echo URLROOT; ?>/chat/requests" class="btn-joineds-groups">Chat Requests</a>
                    <a href="<?php echo URLROOT; ?>/chat/report" class="btn-views-members">Report</a>
                </nav>
            </aside>

            <div class="group-view-container group-chat-container">
                <div class="group-chat-header">
                    <div class="group-chat-info">
                        <h2>Chat with Mrs. Jeewa</h2>
                        <span>Admin | Last active 2 hours ago</span>
                    </div>
                    <a href="<?php echo URLROOT; ?>/chat" class="back-to-group">
                        <i class="fas fa-arrow-left"></i> Back to Chats
                    </a>
                </div>

                <div class="group-chat-messages">
                    <!-- Sent Message Template -->
                    <div class="chat-message sent">
                        <img src="<?php echo URLROOT; ?>/img/default-user.jpg" alt="Your Avatar" class="message-avatar">
                        <div class="message-content">
                            <div class="message-info">
                                <span class="message-sender">You</span>
                                <span class="message-time">10:45 AM</span>
                            </div>
                            <p>Hi there,</p>
                        </div>
                    </div>

                    <!-- Received Message Template -->
                    <div class="chat-message received">
                        <img src="<?php echo URLROOT; ?>/img/default-user.jpg" alt="Mrs. Jeewa Avatar" class="message-avatar">
                        <div class="message-content">
                            <div class="message-info">
                                <span class="message-sender">Mrs. Jeewa</span>
                                <span class="message-time">10:47 AM</span>
                            </div>
                            <p>hello</p>
                        </div>
                    </div>
                </div>

                <div class="group-chat-input">
                    <input type="text" placeholder="Type your message...">
                    <button class="send-message">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>