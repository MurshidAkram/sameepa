<!-- app/views/announcements/view.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/announcements/announcements.css">
    <title>View Announcement | <?php echo SITENAME; ?></title>
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

        <main>
            <div class="view-announcement-container">
                <div class="page-header">
                    <h1><?php echo $data['announcement']['title']; ?></h1>
                    <a href="<?php echo URLROOT; ?>/announcements/index" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Announcements
                    </a>
                </div>

                <div class="announcement-details">
                    <div class="announcement-meta">
                        <span class="created-by">Posted by <?php echo $data['announcement']['creator_name']; ?></span>
                        <span class="created-at"><?php echo date('F d, Y \a\t h:i A', strtotime($data['announcement']['created_at'])); ?></span>
                    </div>

                    <div class="announcement-full-content">
                        <?php echo nl2br(htmlspecialchars($data['announcement']['content'])); ?>
                    </div>

                    <div class="announcement-actions">
                        <div class="reaction-buttons">
                            <button class="btn-react btn-like <?php echo ($data['user_reaction']['reaction_type'] ?? '') === 'like' ? 'active' : ''; ?>"
                                data-announcement-id="<?php echo $data['announcement']['id']; ?>"
                                data-reaction-type="like">
                                <i class="fas fa-thumbs-up"></i>
                                <span class="like-count"><?php echo $data['announcement']['likes']; ?></span>
                            </button>
                            <button class="btn-react btn-dislike <?php echo ($data['user_reaction']['reaction_type'] ?? '') === 'dislike' ? 'active' : ''; ?>"
                                data-announcement-id="<?php echo $data['announcement']['id']; ?>"
                                data-reaction-type="dislike">
                                <i class="fas fa-thumbs-down"></i>
                                <span class="dislike-count"><?php echo $data['announcement']['dislikes']; ?></span>
                            </button>
                        </div>

                        <?php if (in_array($_SESSION['user_role_id'], [2, 3])) : ?>
                            <div class="admin-actions">
                                <a href="<?php echo URLROOT; ?>/announcements/edit/<?php echo $data['announcement']['id']; ?>"
                                    class="btn btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form class="delete-form" action="<?php echo URLROOT; ?>/announcements/delete/<?php echo $data['announcement']['id']; ?>"
                                    method="post" style="display: inline;">
                                    <button type="submit" class="btn btn-delete"
                                        onclick="return confirm('Are you sure you want to delete this announcement?');">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // JavaScript for handling reactions
        document.querySelectorAll('.btn-react').forEach(button => {
            button.addEventListener('click', async function() {
                const announcementId = this.dataset.announcementId;
                const reactionType = this.dataset.reactionType;

                try {
                    const response = await fetch(`<?php echo URLROOT; ?>/announcements/react/${announcementId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `reaction_type=${reactionType}`
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Reload the page to update the counts
                        location.reload();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>
</body>

</html>