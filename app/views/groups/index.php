<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>Community Groups | <?php echo SITENAME; ?></title>
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

            <div class="groups-content">
                <div class="groups-header">
                    <h1>Community Groups</h1>
                    <div class="search-container">
                        <input type="search" id="searchGroups" placeholder="Search groups..." class="search-input">
                        <button class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <p>Connect with like-minded community members in various interest groups!</p>

                <div class="groups-grid">
                    <?php foreach ($data['groups'] as $group): ?>
                        <div class="group-card">
                            <div class="group-image">
                                <img src="data:<?php echo $group->image_type; ?>;base64,<?php echo base64_encode($group->image_data); ?>"
                                alt="<?php echo $group->group_name; ?>">
                            </div>
                            <div class="group-details">
                                <h3 class="group-title"><?php echo $group->group_name; ?></h3>
                                <div class="group-info">
                                    <p class="group-category">
                                        <i class="fas fa-tag"></i>
                                        <?php echo $group->group_category; ?>
                                    </p>
                                    <p class="group-creator">
                                        <i class="fas fa-user"></i>
                                        By <?php echo $group->creator_name; ?>
                                    </p>
                                </div>
                                <div class="group-actions">
                                    <span class="member-count">
                                        <i class="fas fa-users"></i>
                                        <?php echo $this->groupsModel->getMemberCount($group->group_id); ?> Members
                                    </span>
                                    <a href="<?php echo URLROOT; ?>/groups/viewgroup/<?php echo $group->group_id; ?>" 
                                        class="btn-view-group">View Group</a>
                                    <?php if (in_array($_SESSION['user_role_id'], [2, 3])): ?>
                                        <button class="btn-delete-group" 
                                                onclick="deleteGroup(<?php echo $group->id; ?>)">
                                            Delete Group
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (empty($data['groups'])): ?>
                    <div class="no-groups">
                        <p>No groups found. Be the first to create one!</p>
                        <a href="<?php echo URLROOT; ?>/groups/create" class="btn-create-group">Create Group</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        function deleteGroup(groupId) {
            if (confirm('Are you sure you want to delete this group?')) {
                fetch(`<?php echo URLROOT; ?>/groups/delete/${groupId}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to delete group');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the group');
                });
            }
        }
        document.getElementById('searchGroups').addEventListener('input', function(e) {
            const searchText = e.target.value.toLowerCase();
            const groupCards = document.querySelectorAll('.group-card');
            
            groupCards.forEach(card => {
                const groupName = card.querySelector('.group-title').textContent.toLowerCase();
                const groupCategory = card.querySelector('.group-category').textContent.toLowerCase();
                card.style.display = (groupName.includes(searchText) || groupCategory.includes(searchText)) ? '' : 'none';
            });
        });

    </script>
</body>

</html>
