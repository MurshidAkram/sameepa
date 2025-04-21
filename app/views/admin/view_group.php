
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/view_group.css">
    <title>View Group | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>

        <main class="group-main">
            <a href="<?php echo URLROOT; ?>/admin/groups" class="btn-back">← Back to Groups</a>
            
            <div class="group-header">
                <div class="group-info">
                    <img src="<?php echo URLROOT; ?>/img/group-icon.png" alt="Group Icon" class="group-icon">
                    <div class="group-details">
                        <h1 class="group-title">Fitness Enthusiasts</h1>
                        <div class="group-meta">
                            <span class="group-moderators">Moderators: John Doe, Jane Smith</span>
                            <span class="member-count">Members: 45</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chat-section">
                <div class="chat-messages">
                    <div class="message">
                        <div class="message-header">
                            <span class="message-author">John Doe</span>
                            <span class="message-time">10:30 AM</span>
                        </div>
                        <p class="message-content">Hey everyone! Who's joining the morning workout tomorrow?</p>
                    </div>

                    <div class="message">
                        <div class="message-header">
                            <span class="message-author">Sarah Wilson</span>
                            <span class="message-time">10:32 AM</span>
                        </div>
                        <p class="message-content">Count me in! What time are we meeting?</p>
                    </div>
                </div>

                <div class="message-form">
                    <textarea placeholder="Type your message..."></textarea>
                    <button class="btn-send-message">Send</button>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>
