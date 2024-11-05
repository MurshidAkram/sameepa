
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/view_forum.css">
    <title>View Forum | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>

        <main class="forum-main">
            <a href="<?php echo URLROOT; ?>/admin/forums" class="btn-back">← Back to Forums</a>
            <div class="forum-header">
                <h1 class="forum-title">Community Garden Ideas</h1>
                <div class="forum-meta">
                    <span class="forum-author">Posted by: John Doe</span>
                    <span class="forum-date">Created: June 15, 2023 at 14:30</span>
                </div>
                <p class="forum-description">
                    Share your ideas for our upcoming community garden project.Share your ideas for our upcoming community garden project.Share your ideas for our upcoming community garden project.Share your ideas for our upcoming community garden project.Share your ideas for our upcoming community garden project. 
                </p>
            </div>

            <div class="comments-section">
                <div class="comments-list">
                    <div class="comment">
                        <div class="comment-header">
                            <span class="comment-author">Jane Smith</span>
                            <span class="comment-date">June 16, 2023 14:45</span>
                        </div>
                        <p class="comment-content">I think we should include a section for herbs and medicinal plants.</p>
                        <div class="comment-actions">
                            <button class="btn-like">👍 15</button>
                            <button class="btn-dislike">👎 2</button>
                            <button class="btn-reply">Reply</button>
                        </div>
                        
                        <div class="comment-replies">
                            <div class="comment reply">
                                <div class="comment-header">
                                    <span class="comment-author">Mike Johnson</span>
                                    <span class="comment-date">June 16, 2023 15:00</span>
                                </div>
                                <p class="comment-content">Great idea! I can help with the herb selection.</p>
                                <div class="comment-actions">
                                    <button class="btn-like">👍 8</button>
                                    <button class="btn-dislike">👎 0</button>
                                    <button class="btn-reply">Reply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2>Comments</h2>
                <div class="comment-form">
                    <textarea placeholder="Add your comment..."></textarea>
                    <button class="btn-submit-comment">Post Comment</button>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>
