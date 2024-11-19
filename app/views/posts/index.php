<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/posts/posts.css">
    <title>Community Posts | <?php echo SITENAME; ?></title>
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

        <main class="posts-main">
            <aside class="posts-sidebar">
                <h2>Posts Navigation</h2>
                <nav class="posts-nav">
                    <a href="<?php echo URLROOT; ?>/posts/index" class="btn-posts active">All Posts</a>
                    <a href="<?php echo URLROOT; ?>/posts/create" class="btn-create-post">Create Post</a>
                    <a href="<?php echo URLROOT; ?>/posts/my_posts" class="btn-my-posts">My Posts</a>
                </nav>
            </aside>

            <div class="posts-content">
                <h1>Community Posts</h1>

                <!-- Create Post Quick Access -->
                <div class="create-post-card">
                    <img src="<?php echo URLROOT; ?>/img/default-avatar.png" alt="Profile" class="post-avatar">
                    <a href="<?php echo URLROOT; ?>/posts/create" class="create-post-link">
                        What's on your mind?
                    </a>
                </div>

                <!-- Posts Feed -->
                <div class="posts-feed">
                    <?php foreach ($data['posts'] as $post): ?>
                        <div class="post-card" data-post-id="<?php echo $post->id; ?>">
                            <div class="post-header">
                                <img src="<?php echo URLROOT; ?>/img/default-avatar.png" alt="Profile" class="post-avatar">
                                <div class="post-meta">
                                    <h3><?php echo $post->creator_name; ?></h3>
                                    <span class="post-date"><?php echo date('F j, Y g:i A', strtotime($post->created_at)); ?></span>
                                </div>
                                <?php if (
                                    $_SESSION['user_id'] == $post->user_id ||
                                    $_SESSION['user_role_id'] == 3 ||
                                    ($_SESSION['user_role_id'] == 2 && $post->creator_role_id == 1)
                                ): ?>
                                    <button class="delete-post" data-post-id="<?php echo $post->id; ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </div>

                            <div class="post-content">
                                <p><?php echo nl2br(htmlspecialchars($post->content)); ?></p>

                                <?php if (!empty($post->images)): ?>
                                    <div class="post-images">
                                        <?php foreach ($post->images as $image): ?>
                                            <img src="data:<?php echo $image->image_type; ?>;base64,<?php echo base64_encode($image->image_data); ?>"
                                                alt="Post image" class="post-image">
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="post-actions">
                                <div class="reaction-buttons">
                                    <button class="like-btn <?php echo $post->user_reaction === true ? 'active' : ''; ?>"
                                        data-post-id="<?php echo $post->id; ?>">
                                        <i class="fas fa-thumbs-up"></i>
                                        <span class="likes-count"><?php echo $post->likes_count; ?></span>
                                    </button>
                                    <button class="dislike-btn <?php echo $post->user_reaction === false ? 'active' : ''; ?>"
                                        data-post-id="<?php echo $post->id; ?>">
                                        <i class="fas fa-thumbs-down"></i>
                                        <span class="dislikes-count"><?php echo $post->dislikes_count; ?></span>
                                    </button>
                                </div>
                                <button class="comment-btn" data-post-id="<?php echo $post->id; ?>">
                                    <i class="fas fa-comment"></i>
                                    <span class="comments-count"><?php echo count($post->comments); ?> Comments</span>
                                </button>
                            </div>

                            <!-- Comments Section -->
                            <div class="comments-section" id="comments-<?php echo $post->id; ?>">
                                <div class="comment-form">
                                    <img src="<?php echo URLROOT; ?>/img/default-avatar.png" alt="Profile" class="comment-avatar">
                                    <form class="add-comment-form" data-post-id="<?php echo $post->id; ?>">
                                        <input type="text" name="content" placeholder="Write a comment..." required>
                                        <button type="submit">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="comments-list">
                                    <?php foreach ($post->comments as $comment): ?>
                                        <div class="comment" data-comment-id="<?php echo $comment->id; ?>">
                                            <img src="<?php echo URLROOT; ?>/img/default-avatar.png" alt="Profile" class="comment-avatar">
                                            <div class="comment-content">
                                                <div class="comment-header">
                                                    <strong><?php echo $comment->user_name; ?></strong>
                                                    <span class="comment-date">
                                                        <?php echo date('F j, Y g:i A', strtotime($comment->created_at)); ?>
                                                    </span>
                                                </div>
                                                <p><?php echo htmlspecialchars($comment->content); ?></p>
                                            </div>
                                            <?php if (
                                                $_SESSION['user_id'] == $comment->user_id ||
                                                $_SESSION['user_role_id'] == 3 ||
                                                ($_SESSION['user_role_id'] == 2 && $comment->user_role_id == 1)
                                            ): ?>
                                                <button class="delete-comment" data-comment-id="<?php echo $comment->id; ?>">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (empty($data['posts'])): ?>
                    <div class="no-posts">
                        <p>No posts yet. Be the first to share something!</p>
                        <a href="<?php echo URLROOT; ?>/posts/create" class="btn-create-post">Create Post</a>
                    </div>
                <?php endif; ?>

                <!-- Pagination -->
                <?php if (isset($data['current_page'])): ?>
                    <div class="pagination">
                        <?php if ($data['current_page'] > 1): ?>
                            <a href="<?php echo URLROOT; ?>/posts/index?page=<?php echo $data['current_page'] - 1; ?>" class="pagination-link">Previous</a>
                        <?php endif; ?>

                        <span class="current-page">Page <?php echo $data['current_page']; ?></span>

                        <?php if (!empty($data['posts'])): ?>
                            <a href="<?php echo URLROOT; ?>/posts/index?page=<?php echo $data['current_page'] + 1; ?>" class="pagination-link">Next</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom JS for post interactions -->
    <script src="<?php echo URLROOT; ?>/js/posts.js"></script>
</body>

</html>