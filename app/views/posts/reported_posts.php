<!-- app/views/forums/reported_posts.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/forums.css">
    <title>Reported Posts | <?php echo SITENAME; ?></title>
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
            <h1>Reported Posts</h1>
            <?php if (($_SESSION['user_role_id'] == 2) || ($_SESSION['user_role_id'] == 3)): ?>
                <a href="<?php echo URLROOT; ?>/posts/index" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Posts
                </a>
            <?php endif; ?>
            <?php if (empty($data['reported_posts'])) : ?>
                <p>No reported posts found.</p>
            <?php else : ?>
                <div class="reported-comments-list">
                    <?php foreach ($data['reported_posts'] as $post) : ?>
                        <div class="comment-card">
                            <div class="comment-header">
                                <span class="comment-author"><?php echo $post->author_name; ?></span>
                                <span class="comment-date"><?php echo date('F j, Y g:i A', strtotime($post->created_at)); ?></span>
                                <div class="comment-actions">
                                    <a href="<?php echo URLROOT; ?>/posts/ignore_report/<?php echo $post->id; ?>" class="btn-ignore-report">Ignore Report</a>
                                    <a href="<?php echo URLROOT; ?>/posts/viewpost/<?php echo $post->id; ?>" class="btn-ignore-report" style="background: #cddf07">View Post</a>
                                </div>
                            </div>
                            <div class="comment-footer">
                                <span class="comment-report-reason">Reported by: <?php echo $post->reporter_name; ?> for: <?php echo $post->reason; ?></span>
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