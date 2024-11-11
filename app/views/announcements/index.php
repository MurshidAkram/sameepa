<!-- app/views/announcements/index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/announcements/announcements.css">
    <title>Community Announcements | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php 
        // Load appropriate side panel based on user role
        switch($_SESSION['user_role_id']) {
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
            <div class="announcements-header">
                <div>
                    <h1>Community Announcements</h1>
                    <p>Stay updated with the latest news and information from your community.</p>
                </div>
                <?php if($data['is_admin']) : ?>
                    <a href="<?php echo URLROOT; ?>/announcements/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Announcement
                    </a>
                <?php endif; ?>
            </div>

            <?php //flash('announcement_message'); ?>

            <div class="announcements-list">
                <?php if(!empty($data['announcements'])) : ?>
                    <?php foreach($data['announcements'] as $announcement) : ?>
                        <div class="announcement-card">
                            <div class="announcement-content">
                                <h2><?php echo $announcement->title; ?></h2>
                                <div class="announcement-meta">
                                    <span class="created-by">Posted by <?php echo $announcement->creator_name; ?></span>
                                    <span class="created-at"><?php echo date('M d, Y', strtotime($announcement->created_at)); ?></span>
                                </div>
                                <p class="announcement-preview">
                                    <?php 
                                    $preview = strlen($announcement->content) > 200 ? 
                                              substr($announcement->content, 0, 200) . '...' : 
                                              $announcement->content;
                                    echo $preview;
                                    ?>
                                </p>
                            </div>
                            
                            <div class="announcement-actions">
                                <div class="reaction-buttons">
                                    <button class="btn-react btn-like <?php echo ($data['user_reactions'][$announcement->id] ?? '') === 'like' ? 'active' : ''; ?>"
                                            data-announcement-id="<?php echo $announcement->id; ?>"
                                            data-reaction-type="like">
                                        <i class="fas fa-thumbs-up"></i>
                                        <span class="like-count"><?php echo $announcement->likes; ?></span>
                                    </button>
                                    <button class="btn-react btn-dislike <?php echo ($data['user_reactions'][$announcement->id] ?? '') === 'dislike' ? 'active' : ''; ?>"
                                            data-announcement-id="<?php echo $announcement->id; ?>"
                                            data-reaction-type="dislike">
                                        <i class="fas fa-thumbs-down"></i>
                                        <span class="dislike-count"><?php echo $announcement->dislikes; ?></span>
                                    </button>
                                </div>
                                
                                <div class="management-buttons">
                                    <a href="<?php echo URLROOT; ?>/announcements/viewannouncement/<?php echo $announcement->id; ?>" 
                                       class="btn btn-view">View Full</a>
                                    
                                    <?php if($data['is_admin']) : ?>
                                        <a href="<?php echo URLROOT; ?>/announcements/edit/<?php echo $announcement->id; ?>" 
                                           class="btn btn-edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form class="delete-form" action="<?php echo URLROOT; ?>/announcements/delete/<?php echo $announcement->id; ?>" 
                                              method="post" style="display: inline;">
                                            <button type="submit" class="btn btn-delete" 
                                                    onclick="return confirm('Are you sure you want to delete this announcement?');">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="no-announcements">
                        <p>No announcements available at this time.</p>
                    </div>
                <?php endif; ?>
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