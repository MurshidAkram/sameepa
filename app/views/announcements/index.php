<!-- app/views/announcements/index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <!-- <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/announcements/announcements.css"> -->
    <title>Community Announcements | <?php echo SITENAME; ?></title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
        color: #333;
    }

    .dashboard-container {
        display: flex;
        flex-direction: row;
        min-height: 100vh;
    }

    main {
        flex: 1;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin: 20px;
    }

    .announcements-header h1 {
        font-size: 28px;
        color: #800080;
        margin-bottom: 5px;
    }

    .announcements-header p {
        font-size: 14px;
        color: #555;
        margin-bottom: 20px;
    }

    .btn {
        padding: 10px 15px;
        margin-bottom: 30px;
        background-color: #800080;
        color: #fff;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #660066;
    }

    .btn:active {
        background-color: #4d004d;
    }

    .announcements-search {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .announcements-search input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        margin-right: 10px;
    }

    .announcements-search button {
        background-color: #800080;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-top: 30px;
    }

    .announcements-search button:hover {
        background-color: #660066;
    }

    .announcement-card {
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background-color: #fff;
        margin-bottom: 15px;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
    }

    .announcement-content h2 {
        font-size: 20px;
        color: #800080;
        margin-bottom: 10px;
    }

    .announcement-meta {
        font-size: 12px;
        color: #777;
        margin-bottom: 10px;
    }

    .announcement-preview {
        font-size: 14px;
        line-height: 1.6;
        color: #333;
        margin-bottom: 15px;
    }

    .announcement-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .reaction-buttons .btn-react {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        /* background-color: #800080; */
        color: black;
        border: none;
        border-radius: 5px;
        padding: 5px 10px;
        margin-right: 5px;
        font-size: 14px;
        cursor: pointer;
    }

    .reaction-buttons .btn-react.active {
        background-color: #660066;
    }

    .reaction-buttons .btn-react:hover {
        background-color: #660066;
    }

    .management-buttons .btn {
        margin-right: 10px;
    }

    .no-announcements {
        text-align: center;
        font-size: 16px;
        color: #555;
        margin-top: 20px;
    }
    .btn-edit {
        background-color: #0066cc;
        color: #fff;
    }

    .btn-edit:hover {
        background-color: #004999;
    }

    .btn-delete {
        background-color: #cc0000;
        color: #fff;
    }

    .btn-delete:hover {
        background-color: #990000;
    }
</style>

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

            <div class="announcements-search">
                <input type="text" id="search-announcements" placeholder="Search announcements...">
                <button class="btn btn-primary" onclick="searchAnnouncements()">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>

            <?php //flash('announcement_message'); ?>

            <div class="announcements-list">
                <?php
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                $announcements = $this->announcementModel->getAllAnnouncements($searchTerm);
                ?>

                <?php if(!empty($announcements)) : ?>
                    <?php foreach($announcements as $announcement) : ?>
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

        // JavaScript for searching announcements
        function searchAnnouncements() {
            const searchTerm = document.getElementById('search-announcements').value;
            window.location.href = '<?php echo URLROOT; ?>/announcements/index?search=' + encodeURIComponent(searchTerm);
        }
    </script>
</body>
</html>