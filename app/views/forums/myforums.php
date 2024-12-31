<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/forums.css">
    <title>My Forums | <?php echo SITENAME; ?></title>
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
            <h1>My Forums</h1>
            <p>View and manage forums you've created</p>

            <div class="forums-actions">
                <a href="<?php echo URLROOT; ?>/forums/create" class="btn-create-forum">Create New Forum</a>
                <a href="<?php echo URLROOT; ?>/forums" class="btn-my-forums">← Back to All Forums</a>
            </div>

            <div class="forums-list">
                <?php if (empty($data['forums'])) : ?>
                    <div class="no-forums">
                        <p>You haven't created any forums yet.</p>
                    </div>
                <?php else : ?>
                    <?php foreach ($data['forums'] as $forum) : ?>
                        <div class="forum-card">
                            <h2 class="forum-title"><?php echo $forum->title; ?></h2>
                            <p class="forum-description"><?php echo $forum->description; ?></p>
                            <div class="forum-details">
                                <span class="forum-date">Created: <?php echo date('F j, Y', strtotime($forum->created_at)); ?></span>
                                <span class="forum-comments-index">💬: <?php echo $this->getCommentCountByForumId($forum->id); ?></span>
                            </div>
                            <div class="forum-actions">
                                <a href="<?php echo URLROOT; ?>/forums/view_forum/<?php echo $forum->id; ?>" class="btn-view-forum">View Forum</a>
                                <!-- Change this line in myforums.php -->
                                <a href="<?php echo URLROOT; ?>/forums/deletemyForum/<?php echo $forum->id; ?>" class="btn-delete-forum" onclick="return confirm('Are you sure you want to delete this forum?');">Delete</a> <?php if ($_SESSION['user_role_id'] >= 2) : ?>
                                    <a href="<?php echo URLROOT; ?>/forums/reported_comments/<?php echo $forum->id; ?>" class="btn-reported-comments">Reported Comments</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>