<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/posts/posts.css">
    <title>View Post | <?php echo SITENAME; ?></title>
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
            <div class="post-detail-container">
                <div class="post-card">
                    <div class="post-header">
                        <span class="post-creator">
                            <i class="fas fa-user"></i> <?php echo $data['post']['creator_name']; ?>
                        </span>
                        <span class="post-date">
                            <i class="fas fa-clock"></i>
                            <?php echo date('M d, Y H:i', strtotime($data['post']['created_at'])); ?>
                        </span>
                    </div>

                    <?php if ($data['post']['image_data']) : ?>
                        <div class="post-image">
                            <img src="<?php echo URLROOT; ?>/posts/image/<?php echo $data['post']['id']; ?>" alt="Post image">
                        </div>
                    <?php endif; ?>

                    <div class="post-content">
                        <p><?php echo htmlspecialchars($data['post']['description']); ?></p>
                    </div>

                    <div class="post-actions">
                        <div class="reaction-buttons">
                            <button class="btn-react btn-like <?php echo ($data['user_reaction'] === 'like') ? 'active' : ''; ?>"
                                data-post-id="<?php echo $data['post']['id']; ?>"
                                data-reaction-type="like">
                                <i class="fas fa-thumbs-up"></i>
                                <span class="like-count"><?php echo $data['post']['likes']; ?></span>
                            </button>
                            <button class="btn-react btn-dislike <?php echo ($data['user_reaction'] === 'dislike') ? 'active' : ''; ?>"
                                data-post-id="<?php echo $data['post']['id']; ?>"
                                data-reaction-type="dislike">
                                <i class="fas fa-thumbs-down"></i>
                                <span class="dislike-count"><?php echo $data['post']['dislikes']; ?></span>
                            </button>
                        </div>

                        <div class="post-management">
                            <?php if ($data['is_creator']) : ?>
                                <a href="<?php echo URLROOT; ?>/posts/update/<?php echo $data['post']['id']; ?>"
                                    class="btn btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            <?php elseif ($data['is_admin']) : ?>
                                <button class="btn btn-delete delete-post"
                                    data-post-id="<?php echo $data['post']['id']; ?>">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

                <div class="comments-section">
                    <h2>Comments</h2>
                    <div class="comment-form">
                        <form id="comment-form">
                            <textarea name="comment" placeholder="Write a comment..." required></textarea>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Post Comment
                            </button>
                        </form>
                    </div>

                    <div class="comments-list" id="comments-container">
                        <?php if (!empty($data['comments'])) : ?>
                            <?php foreach ($data['comments'] as $comment) : ?>
                                <div class="comment" data-comment-id="<?php echo $comment->id; ?>">
                                    <div class="comment-header">
                                        <span class="comment-user">
                                            <i class="fas fa-user"></i> <?php echo $comment->user_name; ?>
                                        </span>
                                        <span class="comment-date">
                                            <?php echo date('M d, Y H:i', strtotime($comment->created_at)); ?>
                                        </span>
                                    </div>
                                    <div class="comment-body">
                                        <?php echo htmlspecialchars($comment->comment); ?>
                                    </div>
                                    <?php
                                    $isCommentOwner = $comment->user_id == $_SESSION['user_id'];
                                    $isAdminOrSuperAdmin = in_array($_SESSION['user_role_id'], [2, 3]);
                                    ?>
                                    <?php if ($isCommentOwner || $isAdminOrSuperAdmin) : ?>
                                        <div class="comment-actions">
                                            <button class="btn btn-delete delete-comment"
                                                data-comment-id="<?php echo $comment->id; ?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="no-comments">
                                <p>No comments yet. Be the first to comment!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script>
        document.querySelectorAll('.btn-react').forEach(button => {
            button.addEventListener('click', async function() {
                const postId = this.dataset.postId;
                const reactionType = this.dataset.reactionType;

                try {
                    const response = await fetch(`<?php echo URLROOT; ?>/posts/react/${postId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `reaction_type=${reactionType}`
                    });

                    const data = await response.json();

                    if (data.success) {
                        location.reload();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });
        });

        document.querySelector('.delete-post')?.addEventListener('click', async function() {
            const postId = this.dataset.postId;

            if (confirm('Are you sure you want to delete this post?')) {
                try {
                    const response = await fetch(`<?php echo URLROOT; ?>/posts/delete/${postId}`, {
                        method: 'POST'
                    });

                    const data = await response.json();

                    if (data.success) {
                        window.location.href = '<?php echo URLROOT; ?>/posts/index';
                    } else {
                        alert(data.message || 'Failed to delete post');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the post');
                }
            }
        });

        document.getElementById('comment-form')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const commentTextarea = this.querySelector('textarea');
            const comment = commentTextarea.value.trim();
            const postId = <?php echo $data['post']['id']; ?>;

            if (comment) {
                try {
                    const response = await fetch(`<?php echo URLROOT; ?>/posts/comment/${postId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `comment=${encodeURIComponent(comment)}`
                    });

                    const data = await response.json();

                    if (data.success) {
                        location.reload();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        });

        document.querySelectorAll('.delete-comment').forEach(button => {
            button.addEventListener('click', async function() {
                const commentId = this.dataset.commentId;

                if (confirm('Are you sure you want to delete this comment?')) {
                    try {
                        const response = await fetch(`<?php echo URLROOT; ?>/posts/deleteComment/${commentId}`, {
                            method: 'POST'
                        });

                        const data = await response.json();

                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Failed to delete comment');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the comment');
                    }
                }
            });
        });
    </script>
</body>

</html>