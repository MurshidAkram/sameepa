<!-- app/views/forums/view_forum.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/forums.css">
    <title><?php echo $data['forum']['title']; ?> | <?php echo SITENAME; ?></title>
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
            <h1><?php echo $data['forum']['title']; ?></h1>
            <p><?php echo $data['forum']['description']; ?></p>

            <div class="forum-comments">
                <h2>Comments</h2>

                <form action="<?php echo URLROOT; ?>/forums/view_forum/<?php echo $data['forum']['id']; ?>" method="POST" class="comment-form">
                    <textarea name="comment" placeholder="Add a comment..." class="form-control"></textarea>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </form>

                <?php foreach ($data['comments'] as $comment) : ?>
                    <div class="comment-card">
                        <div class="comment-header">
                            <span class="comment-author"><?php echo $this->getUserNameById($comment->user_id); ?></span>
                            <span class="comment-date"><?php echo date('F j, Y g:i A', strtotime($comment->created_at)); ?></span>
                            <?php if ($_SESSION['user_id'] == $comment->user_id || $_SESSION['user_role_id'] >= 2) : ?>
                                <div class="comment-actions">
                                    <?php if ($comment->reported) : ?>
                                        <a href="<?php echo URLROOT; ?>/forums/ignore_report/<?php echo $comment->id; ?>" class="btn-ignore-report">Ignore Report</a>
                                    <?php else : ?>
                                        <a href="<?php echo URLROOT; ?>/forums/delete_comment/<?php echo $comment->id; ?>" class="btn-delete-comment">Delete</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <p class="comment-content"><?php echo $comment->comment; ?></p>
                        <div class="comment-footer">
                            <a href="<?php echo URLROOT; ?>/forums/report_comment/<?php echo $comment->id; ?>" class="btn-report-comment">Report</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>