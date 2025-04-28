<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/posts/posts.css">
    <title>Community Posts | <?php echo SITENAME; ?></title>
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
                    <h1>Community Posts</h1>
                    <p>Share and explore community updates!</p>
                </div>
                <div class="btn-container">
                    <a href="<?php echo URLROOT; ?>/posts/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Post
                    </a>
                    <a href="<?php echo URLROOT; ?>/posts/myposts" class="btn btn-secondary">
                        <i class="fas fa-list"></i> My Posts
                    </a>
                    <?php if ($_SESSION['user_role_id'] >= 2) : ?>
                        <a href="<?php echo URLROOT; ?>/posts/reported_posts" class="btn btn-primary" style="background:#cddf07">
                            Post Reports
                        </a>
                    <?php endif ?>
                </div>
            </div>


            <div class="posts-feed">
                <div class="posts-search">
                    <form method="GET" action="<?php echo URLROOT; ?>/posts">
                        <input type="text" name="search" placeholder="Search posts..."
                            value="<?php echo isset($data['search']) ? htmlspecialchars($data['search']) : ''; ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </form>
                </div>

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
                                    <button class="btn-react btn-like <?php echo ($post->user_reaction === 'like') ? 'active' : ''; ?>"
                                        data-post-id="<?php echo $post->id; ?>"
                                        data-reaction-type="like">
                                        <i class="fas fa-thumbs-up"></i>
                                        <span class="like-count"><?php echo $post->likes; ?></span>
                                    </button>
                                    <button class="btn-react btn-dislike <?php echo ($post->user_reaction === 'dislike') ? 'active' : ''; ?>"
                                        data-post-id="<?php echo $post->id; ?>"
                                        data-reaction-type="dislike">
                                        <i class="fas fa-thumbs-down"></i>
                                        <span class="dislike-count"><?php echo $post->dislikes; ?></span>
                                    </button>
                                </div>

                                <div class="post-details">
                                    <a href="<?php echo URLROOT; ?>/posts/viewpost/<?php echo $post->id; ?>"
                                        class="btn btn-view">
                                        <i class="fas fa-comment"></i>
                                        Comments (<?php echo $post->comment_count; ?>)
                                    </a>

                                    <?php if ($post->created_by == $_SESSION['user_id'] || $data['is_admin']) : ?>
                                        <div class="post-management">
                                            <?php if ($post->created_by == $_SESSION['user_id']) : ?>
                                                <a href="<?php echo URLROOT; ?>/posts/update/<?php echo $post->id; ?>"
                                                    class="btn btn-edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            <?php endif; ?>
                                            <button class="btn btn-delete delete-post"
                                                data-post-id="<?php echo $post->id; ?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <a href="<?php echo URLROOT; ?>/posts/reportPost/<?php echo $post->id; ?>"
                                            class="btn btn-edit" style="background: #cddf07">
                                            <i class="fas fa-edit"></i> Report
                                        </a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="no-posts">
                        <p>No posts found. Be the first to create one!</p>
                    </div>
                <?php endif; ?>
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
</body>

</html>