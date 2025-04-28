<!-- File location: views/posts/myposts.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/posts/posts.css">
    <title>Post | <?php echo SITENAME; ?></title>
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

        <main class="posts-main">
            <div class="posts-header">
                <div>
                    <h1>My Posts</h1>
                    <p>View and manage your community posts</p>
                </div>
                <a href="<?php echo URLROOT; ?>/posts/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Post
                </a>
                <a href="<?php echo URLROOT; ?>/posts" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All Posts
                </a>
            </div>

            <div class="posts-feed">
                <?php if (!empty($data['posts'])) : ?>
                    <?php foreach ($data['posts'] as $post) : ?>
                        <div class="post-card">
                            <div class="post-header">
                                <span class="post-creator">
                                    <i class="fas fa-user"></i> <?php echo $post->creator_name; ?>
                                </span>
                                <span class="post-date">
                                    <i class="fas fa-clock"></i>
                                    <?php echo date('M d, Y H:i', strtotime($post->created_at)); ?>
                                </span>
                            </div>

                            <?php if ($post->image_data) : ?>
                                <div class="post-image">
                                    <img src="<?php echo URLROOT; ?>/posts/image/<?php echo $post->id; ?>"
                                        alt="Post image">
                                </div>
                            <?php endif; ?>

                            <div class="post-content">
                                <p><?php echo htmlspecialchars($post->description); ?></p>
                            </div>

                            <div class="post-actions">
                                <div class="reaction-buttons">
                                    <span class="likes">
                                        <i class="fas fa-thumbs-up"></i> <?php echo $post->likes; ?> Likes
                                    </span>
                                    <span class="dislikes">
                                        <i class="fas fa-thumbs-down"></i> <?php echo $post->dislikes; ?> Dislikes
                                    </span>
                                </div>

                                <div class="post-management">
                                    <a href="<?php echo URLROOT; ?>/posts/viewpost/<?php echo $post->id; ?>"
                                        class="btn btn-view">
                                        <i class="fas fa-eye"></i> View
                                        (<?php echo $post->comment_count; ?> Comments)
                                    </a>
                                    <a href="<?php echo URLROOT; ?>/posts/update/<?php echo $post->id; ?>"
                                        class="btn btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button class="btn btn-delete delete-post"
                                        data-post-id="<?php echo $post->id; ?>">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="no-posts">
                        <p>You haven't created any posts yet.
                            <a href="<?php echo URLROOT; ?>/posts/create">Create your first post!</a>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

<script>
    document.querySelectorAll('.delete-post').forEach(button => {
        button.addEventListener('click', async function() {
            const postId = this.dataset.postId;

            if (confirm('Are you sure you want to delete this post?')) {
                try {
                    const response = await fetch(`<?php echo URLROOT; ?>/posts/delete/${postId}`, {
                        method: 'POST'
                    });

                    const data = await response.json();

                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to delete post');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the post');
                }
            }
        });
    });
</script>