<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>Chat Reports | <?php echo SITENAME; ?></title>
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
                <?php $current_page = basename($_SERVER['REQUEST_URI']); ?>

                <nav class="groups-nav">
                    <a href="<?php echo URLROOT; ?>/chat/index" class="<?php echo ($current_page == 'index' ? 'active' : ''); ?>">My Chats</a>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="<?php echo ($current_page == 'search' ? 'active' : ''); ?>">Search Users</a>
                    <a href="<?php echo URLROOT; ?>/chat/requests" class="<?php echo ($current_page == 'requests' ? 'active' : ''); ?>">Chat Requests</a>
                    <a href="<?php echo URLROOT; ?>/chat/report" class="<?php echo ($current_page == 'report' ? 'active' : ''); ?>">Report</a>
                </nav>
            </aside>

            <div class="groups-content">
                <h1>Chat Reports</h1>
                <form class="groups-search" method="GET" action="<?php echo URLROOT; ?>/chat/viewreport">
                    <input type="text" name="search" placeholder="Search reports...">
                    <button type="submit">Search</button>
                </form>
                <p>Review and manage chat-related reports and incidents.</p>

                <div class="groups-grid">
                    <!-- Report Card Template -->
                    <div class="group-card">
                        <div class="group-image">
                            <img src="<?php echo URLROOT; ?>/img/default-user.png" alt="Report from John Doe">
                        </div>
                        <div class="group-details">
                            <h3 class="group-title">Inappropriate Message</h3>
                            <div class="group-info">
                                <p class="group-category">
                                    <i class="fas fa-flag"></i>
                                    Status: Pending
                                </p>
                                <p class="group-creator">
                                    <i class="fas fa-clock"></i>
                                    Reported: 3 hours ago
                                </p>
                            </div>
                            <div class="group-actions">
                                <a href="<?php echo URLROOT; ?>/chat/viewreport" class="btn-view-group">View Details</a>
                                <span class="member-count">
                                    <i class="fas fa-user"></i>
                                    Reported By
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Repeat similar report card structures -->
                </div>

                <!-- No Reports Placeholder -->
                <div class="no-groups" style="display: none;">
                    <p>No chat reports at this time.</p>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const links = document.querySelectorAll(".groups-nav a");

        links.forEach(link => {
            link.addEventListener("click", function() {
                // Remove active class from all links
                links.forEach(l => l.classList.remove("active"));

                // Add active class to the clicked link
                this.classList.add("active");
            });
        });
    });
</script>

</html>