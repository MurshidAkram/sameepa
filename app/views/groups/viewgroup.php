
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>Book Club | <?php echo SITENAME; ?></title>
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

        <main class="groups-main">
            <aside class="groups-sidebar">
                <h2>Group Navigation</h2>
                <nav class="groups-nav">
                    <a href="<?php echo URLROOT; ?>/groups/index" class="btn-created-group">Groups</a>
                    <a href="<?php echo URLROOT; ?>/groups/create" class="btn-created-group">Create Group</a>
                    <a href="<?php echo URLROOT; ?>/groups/joined" class="btn-joined-groups">Joined Groups</a>
                    <a href="<?php echo URLROOT; ?>/groups/my_groups" class="btn-my-groups">My Groups</a>
                </nav>
            </aside>
              <div class="group-view-container">
                  <div class="top-actions">
                      <a href="<?php echo URLROOT; ?>/groups" class="back-button">
                          <i class="fas fa-arrow-left"></i> Back to Groups
                      </a>
                      <?php if ($_SESSION['user_role_id'] == 2): ?>
                          <button class="adminremovegrp" onclick="deleteGroup()">
                              <i class="fas fa-trash"></i> Delete Group
                          </button>
                      <?php endif; ?>
                  </div>
                <div class="group-view-content">
                    <div class="group-image-section">
                        <img src="<?php echo URLROOT; ?>/img/default-group.jpg" alt="Book Club" class="group-main-image">

                        <div class="group-creator-info">
                            <i class="fas fa-user-circle"></i>
                            <span>Created by John Doe</span>
                        </div>
                    </div>

                    <div class="group-details-section">
                        <h1 class="group-title">Book Club</h1>

                        <div class="group-meta">
                            <div class="meta-item">
                                <i class="fas fa-tag"></i>
                                <span>Literature</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-users"></i>
                                <span>15 Members</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>Created - July 15, 2023</span>
                            </div>
                        </div>

                        <div class="group-description">
                            <h2>About This Group</h2>
                            <p>A community of book lovers who meet regularly to discuss various literary works. We explore different genres and authors while sharing our thoughts and perspectives.</p>
                        </div>
                          <button id="joinButton" class="join-button" data-group-id="1" data-is-joined="false">
                              Join Group
                          </button>
                          <!-- Add this button after the join button in the group-details-section -->
                          <button id="groupChatButton" class="group-chat-button" onclick="window.location.href='<?php echo URLROOT; ?>/groups/chat/1'">
                              <i class="fas fa-comments"></i> Group Chat
                          </button>
                      </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script>
        document.getElementById('joinButton')?.addEventListener('click', async function() {
            const button = this;
            const groupId = button.dataset.groupId;
            const isJoined = button.dataset.isJoined === 'true';

            if (confirm(isJoined ? 'Leave this group?' : 'Join this group?')) {
                button.textContent = isJoined ? 'Join Group' : 'Leave Group';
                button.dataset.isJoined = isJoined ? 'false' : 'true';
                button.classList.toggle('joined');
            }
        });
        function deleteGroup(groupId) {
            if (confirm('Are you sure you want to delete this group?')) {
                // Delete functionality would go here
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>
