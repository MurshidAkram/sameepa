<!-- app/views/forums/index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/forums.css">
    <title>Community Forums | <?php echo SITENAME; ?></title>
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

        <main class="forums-main">
            <h1>Community Forums</h1>
            <p>Engage in open discussions with your community members!</p>

            <div class="forums-actions">
                <a href="<?php echo URLROOT; ?>/forums/create" class="btn-create-forum">Create New Forum</a>
                <a href="<?php echo URLROOT; ?>/forums/myforums" class="btn-my-forums">My Forums</a>

            </div>

            <div class="forums-list">
                <?php foreach ($data['forums'] as $forum) : ?>
                    <div class="forum-card">
                        <h2 class="forum-title"><?php echo $forum->title; ?></h2>
                        <p class="forum-description"><?php echo $forum->description; ?></p>
                        <div class="forum-details">
                            <span class="forum-creator">Created by: <?php echo $this->getUserNameById($forum->created_by); ?></span>
                            <span class="forum-comments-index">💬: <?php echo $this->getCommentCountByForumId($forum->id); ?></span>
                        </div>
                        <div class="forum-actions">
                            <?php if ($_SESSION['user_role_id'] == 2) : ?>
                                <a href="<?php echo URLROOT; ?>/forums/view_forum/<?php echo $forum->id; ?>" class="btn-view-forum">View</a>
                            <?php else : ?>
                                <a href="<?php echo URLROOT; ?>/forums/view_forum/<?php echo $forum->id; ?>" class="btn-view-forum2">View Forum</a>
                            <?php endif; ?>
                            <?php if ($_SESSION['user_role_id'] >= 2) : ?>
                                <a href="<?php echo URLROOT; ?>/forums/delete/<?php echo $forum->id; ?>" class="btn-delete-forum" onclick="return confirm('Are you sure you want to delete this forum?')">Delete</a>
                                <a href="<?php echo URLROOT; ?>/forums/reported_comments/<?php echo $forum->id; ?>" class="btn-reported-comments">Reports</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>