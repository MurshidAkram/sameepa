<!-- app/views/forums/reported_comments.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/forums.css">
    <title>Reported Comments | <?php echo SITENAME; ?></title>
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

        <main class="forums-main">
            <h1>Reported Comments</h1>
            <?php if ($_SESSION['user_role_id'] == 2): ?>
                <a href="<?php echo URLROOT; ?>/forums/index" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Forums
                </a>
            <?php else: ?>
                <a href="<?php echo URLROOT; ?>/forums" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Forums
                </a>
            <?php endif; ?>

            <?php if (empty($data['reported_comments'])) : ?>
                <p>No reported comments found.</p>
            <?php else : ?>
                <div class="reported-comments-list">
                    <?php foreach ($data['reported_comments'] as $comment) : ?>
                        <div class="comment-card">
                            <div class="comment-header">
                                <span class="comment-author"><?php echo $this->getUserNameById($comment->user_id); ?></span>
                                <span class="comment-date"><?php echo date('F j, Y g:i A', strtotime($comment->created_at)); ?></span>
                                <div class="comment-actions">
                                    <a href="<?php echo URLROOT; ?>/forums/delete_reported_comment/<?php echo $comment->id; ?>" class="btn-delete-comment">Delete</a>
                                    <a href="<?php echo URLROOT; ?>/forums/ignore_report/<?php echo $comment->id; ?>" class="btn-ignore-report">Ignore Report</a>
                                </div>
                            </div>
                            <p class="comment-content"><?php echo $comment->comment; ?></p>
                            <div class="comment-footer">
                                <span class="comment-report-reason">Reported by: <?php echo $this->getUserNameById($comment->reported_by); ?> for: <?php echo $comment->reason; ?></span>
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