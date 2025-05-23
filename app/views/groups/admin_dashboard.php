<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/groups/groups.css">
    <title>Groups Admin Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        switch ($_SESSION['user_role_id']) {
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>
        <main class="admin-groups-main">
            <div class="admin-header">
                <h1>Group Management Dashboard</h1>
                <div class="search-container">
                    <input type="search" id="searchGroup" placeholder="Search groups..." class="search-input">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="admin-actions">
                <a href="<?php echo URLROOT; ?>/groups/reported" class="btn-reported">
                    <i class="fas fa-flag"></i> Reported Groups
                </a>
                <a href="<?php echo URLROOT; ?>/groups/create" class="btn-create">
                    <i class="fas fa-plus"></i> Create New Group
                </a>
            </div>

            <div class="groups-stats">
                <div class="stat-card">
                    <div class="stat-info">
                        <h3><i class="fas fa-users"></i> Total Groups</h3>
                        <p><?php echo count($data['groups']); ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3><i class="fas fa-user-check"></i> Active Members</h3>
                        <p><?php echo isset($data['active_members']) ? $data['active_members'] : 0; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3><i class="fas fa-comments"></i> Total Discussions</h3>
                        <p><?php echo isset($data['total_discussions']) ? $data['total_discussions'] : 0; ?></p>
                    </div>
                </div>
            </div>
            <div class="groups-grid">
                <?php foreach ($data['groups'] as $group): ?>
                    <div class="group-card">
                        <div class="group-image">
                            <img src="data:<?php echo $group->image_type; ?>;base64,<?php echo base64_encode($group->image_data); ?>" alt="<?php echo $group->group_name; ?>">
                        </div>
                        <div class="group-details">
                            <div class="group-info-section">
                                <h2 class="group-title"><?php echo $group->group_name; ?></h2>
                                <div class="group-info">
                                    <p><i class="fas fa-users"></i> <?php echo $this->groupsModel->getMemberCount($group->group_id); ?> members</p>
                                    <p><i class="fas fa-calendar"></i> Created: <?php echo date('M d, Y', strtotime($group->created_date)); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="group-actions">
                            <a href="<?php echo URLROOT; ?>/groups/viewgroup/<?php echo $group->group_id; ?>" class="btnviewgroup">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo URLROOT; ?>/groups/update/<?php echo $group->group_id; ?>" class="btn-update-group">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo URLROOT; ?>/groups/reported_messages/<?php echo $group->group_id; ?>" class="btn-reports-group">
                                <i class="fas fa-flag"></i>
                            </a>
                            <form action="<?php echo URLROOT; ?>/groups/delete/<?php echo $group->group_id; ?>" method="POST" style="display: inline;">
                                <button type="submit" class="btndeletegroup" onclick="return confirm('Are you sure you want to delete this group?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="<?php echo URLROOT; ?>/js/groups_admin.js"></script>
</body>

</html>