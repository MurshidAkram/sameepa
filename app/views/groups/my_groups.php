
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title>My Groups | <?php echo SITENAME; ?></title>
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
                    <a href="<?php echo URLROOT; ?>/groups/my_groups" class="btn-my-groups active">My Groups</a>
                </nav>
            </aside>

            <div class="groups-content">
                <h1>My Groups</h1>
                <p>Manage the groups you have created</p>

                <div class="groups-grid">
                    <div class="group-card">
                        <div class="group-image">
                            <img src="<?php echo URLROOT; ?>/img/default-group.jpg" alt="Book Club">
                        </div>
                        <div class="group-details">
                            <h3 class="group-title">Book Club</h3>
                            <div class="group-info">
                                <p class="group-category">
                                    <i class="fas fa-tag"></i>
                                    Literature
                                </p>
                                <p class="group-members">
                                    <i class="fas fa-users"></i>
                                    15 Members
                                </p>
                            </div>
                            <div class="group-actions">
                                <button onclick="viewMembers(1)" class="btn-view-members">
                                    <i class="fas fa-users"></i>
                                    15 Members
                                </button>
                                <div class="group-management-buttons">
                                    <a href="<?php echo URLROOT; ?>/groups/update/1" class="btn-update-group">Update</a>
                                    <button onclick="deleteGroup(1)" class="btn-delete-group">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Members Modal -->
    <div id="membersModal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h2>Group Members</h2>
            <div id="membersList"></div>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script>
        function viewMembers(groupId) {
            const modal = document.getElementById('membersModal');
            const membersList = document.getElementById('membersList');
            
            // Dummy members data
            const members = [
                { name: "Sarah Johnson", joined_at: "2023-07-15", role: "Member" },
                { name: "Michael Chen", joined_at: "2023-07-16", role: "Moderator" },
                { name: "Emily Davis", joined_at: "2023-07-18", role: "Member" },
                { name: "David Wilson", joined_at: "2023-07-20", role: "Member" },
                { name: "Lisa Anderson", joined_at: "2023-07-22", role: "Member" }
            ];

            membersList.innerHTML = '';
            const ul = document.createElement('ul');
            
            members.forEach(member => {
                const li = document.createElement('li');
                li.textContent = `${member.name} (${member.role}) - Joined: ${member.joined_at}`;
                ul.appendChild(li);
            });
            
            membersList.appendChild(ul);
            modal.style.display = 'block';
        }

        function deleteGroup(groupId) {
            if (confirm('Are you sure you want to delete this group?')) {
                // Delete functionality would go here
            }
        }

        const modal = document.getElementById('membersModal');
        const span = document.getElementsByClassName('close')[0];

        span.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>

    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow: auto;
        }

        .modal-content {
            position: relative;
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: modalFadeIn 0.3s ease-out;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 28px;
            font-weight: bold;
            color: #666;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close:hover {
            color: #000;
        }

        #membersList {
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>

</html>
