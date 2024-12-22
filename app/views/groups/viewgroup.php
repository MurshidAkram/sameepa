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
                      <?php if ($_SESSION['user_role_id'] == 2 || $_SESSION['user_id'] == $data['group']['created_by']): ?>
                          <button class="bdelview" onclick="deleteGroup(<?php echo $data['group']['group_id']; ?>)">
                              <i class="fas fa-trash"></i> Delete Group
                          </button>
                      <?php endif; ?>
                  </div>

                  <div class="group-view-content">
                      <div class="group-image-section">
                        <?php if ($data['group']['image_data']): ?>
                            <img src="data:<?php echo $data['group']['image_type']; ?>;base64,<?php echo base64_encode($data['group']['image_data']); ?>" 
                                alt="<?php echo $data['group']['group_name']; ?>" 
                                class="group-main-image">
                        <?php endif; ?>

                        <div class="group-creator-info">
                            <i class="fas fa-user-circle"></i>
                            <span>Created by <?php echo $data['group']['creator_name']; ?></span>
                        </div>
                    </div>
                      <div class="group-details-section">
                          <h1 class="group-title"><?php echo $data['group']['group_name']; ?></h1>

                          <div class="group-meta">
                              <div class="meta-item">
                                  <i class="fas fa-tag"></i>
                                  <span><?php echo $data['group']['group_category']; ?></span>
                              </div>
                              <div class="meta-item">
                                  <i class="fas fa-users"></i>
                                  <span><?php echo $data['member_count']; ?> Members</span>
                              </div>
                              <div class="meta-item">
                                  <i class="fas fa-calendar"></i>
                                  <span>Created - <?php echo date('F j, Y', strtotime($data['group']['created_date'])); ?></span>
                              </div>
                          </div>

                          <div class="group-description">
                              <h2>About This Group</h2>
                              <p><?php echo $data['group']['group_description']; ?></p>
                          </div>
                          <?php if ($data['group']['created_by'] != $_SESSION['user_id']): ?>
                                <button id="joinButton"
                                        class="join-button <?php echo $data['isJoined'] ? 'joined' : ''; ?>"
                                        data-group-id="<?php echo $data['group']['group_id']; ?>"
                                        data-is-joined="<?php echo $data['isJoined'] ? 'true' : 'false'; ?>">
                                    <?php echo $data['isJoined'] ? 'Leave Group' : 'Join Group'; ?>
                                </button>
                            <?php endif; ?>
                            <button id="groupChatButton" class="group-chat-button" 
                                    onclick="window.location.href='<?php echo URLROOT; ?>/groups/chat/<?php echo $data['group']['group_id']; ?>'">
                                <i class="fas fa-comments"></i> Group Chat
                            </button>
                        </div>
                    </div>
                </div>
              <script>
            document.getElementById('joinButton')?.addEventListener('click', async function() {
                const button = this;
                const groupId = button.dataset.groupId;
                const isJoined = button.dataset.isJoined === 'true';

                try {
                    const response = await fetch(`<?php echo URLROOT; ?>/groups/${isJoined ? 'leave' : 'join'}/${groupId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Update button state
                        button.dataset.isJoined = !isJoined;
                        button.classList.toggle('joined');
                        button.textContent = isJoined ? 'Join Group' : 'Leave Group';
                        
                        // Update member count with server-provided value
                        const memberCountElement = document.querySelector('.meta-item:nth-child(2) span');
                        memberCountElement.textContent = `${data.memberCount} Members`;
                    } else {
                        alert('Failed to update group participation. Please try again.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                }
            });
            function deleteGroup(groupId) {
                if (confirm('Are you sure you want to delete this group?')) {
                    fetch(`<?php echo URLROOT; ?>/groups/delete/${groupId}`, {
                        method: 'POST'
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.href = '<?php echo URLROOT; ?>/groups';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to delete group');
                    });
                }
            }
            </script>
            </main>
        </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>
