<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">

    <title>Report Details | <?php echo SITENAME; ?></title>
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
                <?php $current_page = basename($_SERVER['REQUEST_URI']);?>

<nav class="groups-nav">
    <a href="<?php echo URLROOT; ?>/chat/index" class="<?php echo ($current_page == 'index' ? 'active' : ''); ?>">My Chats</a>
    <a href="<?php echo URLROOT; ?>/chat/search" class="<?php echo ($current_page == 'search' ? 'active' : ''); ?>">Search Users</a>
    <a href="<?php echo URLROOT; ?>/chat/requests" class="<?php echo ($current_page == 'requests' ? 'active' : ''); ?>">Chat Requests</a>
    <a href="<?php echo URLROOT; ?>/chat/report" class="<?php echo ($current_page == 'report' ? 'active' : ''); ?>">Report</a>
</nav>
            </aside>

            <div class="group-view-container">
                <div class="top-actions">
                    <a href="<?php echo URLROOT; ?>/chat/report" class="back-button">
                        <i class="fas fa-arrow-left"></i> Back to Reports
                    </a>
                    <button class="adminremovegrp">
                        <i class="fas fa-times-circle"></i> Close Report
                    </button>
                </div>

                <div class="group-view-content">
                    <div>
                        <h1 class="group-title">Inappropriate Message Report</h1>

                        <div class="group-meta">
                            <div class="meta-item">
                                <i class="fas fa-user"></i>
                                Reported By: Jane Smith
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                Reported on: March 15, 2024, 10:45 AM
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-flag"></i>
                                Status: Pending Investigation
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-user-shield"></i>
                                Reported User: John Doe
                            </div>
                        </div>

                        <div class="group-description">
                            <h2>Report Details</h2>
                            <p>A message containing inappropriate and offensive language was sent in the chat. The message violated our community guidelines and created an uncomfortable environment for other users.</p>
                        </div>

                        <div class="group-description">
                            <h2>Reported Conversation</h2>
                            <div class="chat-message received" style="max-width: 100%; margin-bottom: 1rem;">
                                <img src="<?php echo URLROOT; ?>/img/default-user.jpg" alt="Reported User Avatar" class="message-avatar">
                                <div class="message-content">
                                    <div class="message-info">
                                        <span class="message-sender">Mr.Sunil</span>
                                        <span class="message-time">10:30 AM</span>
                                    </div>
                                    <p>Inappropriate message content would be displayed here</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-buttons">
                            <button class="btn-submit">
                                <i class="fas fa-check"></i> Validate Report
                            </button>
                            <button class="btn-cancel">
                                <i class="fas fa-ban"></i> Dismiss Report
                            </button>
                        </div>
                    </div>

                    <div>
                        <img src="<?php echo URLROOT; ?>/img/default-user.jpg" alt="Report Evidence" class="group-main-image">
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".groups-nav a");

    links.forEach(link => {
        link.addEventListener("click", function () {
            // Remove active class from all links
            links.forEach(l => l.classList.remove("active"));

            // Add active class to the clicked link
            this.classList.add("active");
        });
    });
});

    </script>
</html>