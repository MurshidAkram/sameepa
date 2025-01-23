<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>Reported Groups | <?php echo SITENAME; ?></title>
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

        <main class="reported-main">
            <div class="top-page">
                <?php if ($_SESSION['user_role_id'] == 2): ?>
                    <a href="<?php echo URLROOT; ?>/groups/admin_dashboard" class="back-button">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?php echo URLROOT; ?>/groups" class="back-button">
                        <i class="fas fa-arrow-left"></i> Back to Groups
                    </a>
                <?php endif; ?>
            </div>

            <h1>Reported Groups</h1>

            <?php if (empty($data['reported_groups'])) : ?>
                <p>No reported groups found.</p>
            <?php else : ?>
                <div class="reported-groups-list">
                    <?php foreach ($data['reported_groups'] as $group) : ?>
                        <div class="comment-card">
                            <div class="comment-header">
                                <span class="comment-author"><?php echo $group->group_name; ?></span>
                                <span class="comment-date"><?php echo date('F j, Y g:i A', strtotime($group->created_at)); ?></span>
                                <div class="comment-actions">
                                    <form action="<?php echo URLROOT; ?>/groups/delete/<?php echo $group->group_id; ?>" method="POST" style="display: inline;">
                                        <button type="submit" class="btndelcomment" onclick="return confirm('Are you sure you want to delete this group?')">
                                            Delete Group
                                        </button>
                                    </form>
                                    <a href="<?php echo URLROOT; ?>/groups/ignore_report/<?php echo $group->id; ?>" class="btn-ignore-report">Ignore Report</a>
                                </div>
                            </div>
                            <p class="comment-content"><?php echo $group->group_description; ?></p>
                            <div class="comment-footer">
                                <span class="comment-report-reason">Reported by: <?php echo $group->reporter_name; ?> for: <?php echo $group->reason; ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
