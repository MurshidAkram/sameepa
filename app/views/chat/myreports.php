<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>My Chat Reports | <?php echo SITENAME; ?></title>
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
                    <a href="<?php echo ($_SESSION['user_role_id'] == 3) ? URLROOT . '/chat/report' : URLROOT . '/chat/myreports'; ?>"
   class="<?php echo ($current_page == 'myreports' ? 'active' : ''); ?>">
    <?php echo ($_SESSION['user_role_id'] == 3) ? 'Reports' : 'Report'; ?>
</a>
                </nav>
            </aside>

            <div class="groups-content">
                <h1>My Chat Reports</h1>
                <p>Here are the chat reports you have submitted.</p>

                <div class="groups-actions-header">
                     <a href="<?php echo URLROOT; ?>/chat/createreport" class="btn-create-group">
                        <i class="fas fa-plus-circle"></i> Create New Report
                    </a>
                </div>


                <div class="groups-grid">
                    <?php if (!empty($data['reports'])) : ?>
                        <?php foreach ($data['reports'] as $report) : ?>
                            <div class="group-card">
    <div class="group-details">
        <h3 class="group-title"><?php echo htmlspecialchars($report->category); ?></h3>
        <div class="group-info">
            <p class="group-category">
                <i class="fas fa-flag"></i>
                Status: <span class="status <?php echo htmlspecialchars(strtolower($report->status)); ?>"><?php echo htmlspecialchars(ucfirst($report->status)); ?></span>
            </p>
            <p class="group-creator">
                <i class="fas fa-clock"></i>
                Reported: <?php echo date('F j, Y, g:i a', strtotime($report->created_at)); ?>
            </p>
        </div>
        <div class="group-actions">
            <a href="<?php echo URLROOT; ?>/chat/viewreport/<?php echo $report->id; ?>" class="btn-view-group">View Details</a>
        </div>
    </div>
</div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <!-- No Reports Placeholder -->
                        <div class="no-groups">
                            <p>You have not submitted any chat reports yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
<style>
   .groups-content {
    padding: 20px;
}

.groups-actions-header {
    margin-bottom: 20px;
    display: flex;
    justify-content: flex-start;
}

.btn-create-group {
    background: linear-gradient(135deg, #800080, #6a006a);
    color: #ffffff;
    padding: 10px 20px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: background 0.3s ease, transform 0.1s ease;
}

.btn-create-group:hover {
    background: linear-gradient(135deg, #6a006a, #550055);
    transform: translateY(-2px);
}

.btn-create-group i {
    font-size: 0.9rem;
}

.groups-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.group-card {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    padding: 20px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    width: 100%;
    box-sizing: border-box;
}

.group-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
}

.group-details {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.group-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #800080;
    margin: 0;
    text-transform: lowercase;
}

.group-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
    font-size: 0.9rem;
}

.group-info i {
    font-size: 0.8rem;
    margin-right: 5px;
    color: #7f8c8d;
}

.group-info .group-category {
    color: #34495e;
    display: inline-flex;
    align-items: center;
}

.group-info .group-category .status {
    font-weight: 600; /* Bold for emphasis */
    font-size: 0.95rem; /* Slightly larger */
    margin-left: 5px; /* Small space after "Status:" */
}

/* Color coding for statuses */
.group-info .group-category .status.pending {
    color: #e67e22; /* Orange for Pending */
}

.group-info .group-category .status.validated {
    color: #28a745; /* Green for Validated */
}

.group-info .group-category .status.dismissed {
    color: #e74c3c; /* Red for Dismissed */
}

.group-info .group-creator {
    color: #7f8c8d;
}

.group-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.btn-view-group {
    background: linear-gradient(135deg, #800080, #6a006a);
    color: #ffffff;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    transition: background 0.3s ease, transform 0.1s ease, box-shadow 0.2s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.btn-view-group:hover {
    background: linear-gradient(135deg, #6a006a, #550055);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.btn-view-group:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.member-count {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    font-size: 0.9rem;
    color: #555;
}

.member-count i {
    font-size: 0.8rem;
    margin-right: 5px;
    color: #7f8c8d;
}

.member-count span {
    color: #000000;
    font-weight: 500;
    margin-left: 20px;
}

/* Placeholder for no reports */
.no-groups {
    text-align: center;
    padding: 20px;
    color: #666;
}
    </style>

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