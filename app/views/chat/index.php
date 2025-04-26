<!-- app/views/chat/index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <title><?php echo $data['title']; ?> | <?php echo SITENAME; ?></title>
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
                <h2>Chat Navigation</h2>
                <?php $current_page = basename($_SERVER['REQUEST_URI']); ?>

                <nav class="groups-nav">
                    <a href="<?php echo URLROOT; ?>/chat/index" class="<?php echo ($current_page == 'index' || $current_page == 'chat') ? 'active' : ''; ?>">My Chats</a>
                    <a href="<?php echo URLROOT; ?>/chat/search" class="<?php echo ($current_page == 'search') ? 'active' : ''; ?>">Search Users</a>
                    <a href="<?php echo URLROOT; ?>/chat/requests" class="<?php echo ($current_page == 'requests') ? 'active' : ''; ?>">Chat Requests</a>
                    <a href="<?php echo ($_SESSION['user_role_id'] == 3) ? URLROOT . '/chat/report' : URLROOT . '/chat/myreports'; ?>" 
                       class="<?php echo ($current_page == (($_SESSION['user_role_id'] == 3) ? 'view Reports' : 'Report')) ? 'active' : ''; ?>">
                        <?php echo ($_SESSION['user_role_id'] == 3) ? 'Reports' : 'Report'; ?>
                    </a>
                </nav>
            </aside>

            <div class="groups-content">
                <h1>My Chats</h1>
                <?php flash('chat_message'); ?>

                <form class="groups-search" method="POST" action="<?php echo URLROOT; ?>/chat/index">
                    <input type="text" name="search" 
                           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                           placeholder="Search chats...">
                    <button type="submit">Search</button>
                </form>

                <p>Connect and communicate with residents, admins, and community members!</p>
                
                <div class="groups-grid">
                    <?php if (!empty($data['chats'])): ?>
                        <?php foreach ($data['chats'] as $chatItem): ?>
                            <?php 
                            // Handle either object or array format for otherUser
                            $otherUser = $chatItem['otherUser'];
                            $name = is_object($otherUser) ? $otherUser->name : $otherUser['name'];
                            $userId = is_object($otherUser) ? $otherUser->id : $otherUser['id'];
                            $profilePic = is_object($otherUser) ? ($otherUser->profile_picture ?? '') : ($otherUser['profile_picture'] ?? '');
                            
                            // Get user role
                            $roleId = is_object($otherUser) ? ($otherUser->role_id ?? '') : ($otherUser['role_id'] ?? '');
                            $roleName = '';
                            
                            switch ($roleId) {
                                case 1:
                                    $roleName = 'Resident';
                                    $roleColor = '#4caf50'; // Green
                                    break;
                                case 2:
                                    $roleName = 'Admin';
                                    $roleColor = '#2196f3'; // Blue
                                    break;
                                case 3:
                                    $roleName = 'Super Admin';
                                    $roleColor = '#800080'; // Purple
                                    break;
                                default:
                                    $roleName = 'User';
                                    $roleColor = '#757575'; // Grey
                            }
                            
                            // Handle last message time
                            $lastMessageTime = isset($chatItem['lastMessage']->created_at) 
                                ? date('H:i', strtotime($chatItem['lastMessage']->created_at)) 
                                : '';
                            ?>
                            
                            <a href="<?php echo URLROOT; ?>/chat/viewChat/<?php echo $userId; ?>" class="chat-card-link">
                                <div class="group-card">
    <div class="name-image">
        <?php if (!empty($profilePic)): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($profilePic); ?>" alt="Chat with <?php echo htmlspecialchars($name); ?>" style="border-radius: 50%; object-fit: cover; border: 1px solid #eaeaea;">
        <?php else: ?>
            <div class="profile-image" style="background-color: #DDD; display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%;">
                <span style="font-size: 8px; color: #888;"><?php echo strtoupper(substr($name, 0, 1)); ?></span>
            </div>
        <?php endif; ?>
    </div>
    <div class="group-details">
        <div class="chat-header">
            <div class="name-role-container">
                <h3 class="group-title"><?php echo htmlspecialchars($name); ?></h3>
                <span class="user-role" style="background-color: <?php echo $roleColor; ?>;">
                    <?php echo $roleName; ?>
                </span>
            </div>
            <span class="chat-time"><?php echo $lastMessageTime; ?></span>
        </div>
        
        <?php 
        // Handle either object or array format for lastMessage
        $lastMessage = $chatItem['lastMessage'];
        $messageText = '';
        
        if (is_object($lastMessage) && isset($lastMessage->message)) {
            $messageText = $lastMessage->message;
        } elseif (is_array($lastMessage) && isset($lastMessage['message'])) {
            $messageText = $lastMessage['message'];
        }
        ?>
        
        <p class="last-message">
            <?php 
            if (!empty($messageText)) {
                echo htmlspecialchars(substr($messageText, 0, 50));
                if (strlen($messageText) > 50) echo '...';
            } else {
                echo 'No messages yet.';
            }
            ?>
        </p>
        
        <?php if ($chatItem['unreadCount'] > 0): ?>
            <span class="unread-badge"><?php echo $chatItem['unreadCount']; ?></span>
        <?php endif; ?>
    </div>
</div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-groups">
                            <p>No active chats yet.</p>
                            <a href="<?php echo URLROOT; ?>/chat/search" class="btn-view-group">Start a New Chat</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
<style>
    /* WhatsApp-style Chat Cards */
.groups-grid {
    display: flex;
    flex-direction: column;
    gap: 1px;
    background-color: #f0f2f5;
    border-radius: 8px;
    overflow: hidden;
    margin-top: 20px;
}

.chat-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.group-card {
    display: flex;
    align-items: center;
    background-color: white;
    padding: 12px 15px;
    border-bottom: 1px solid #f0f2f5;
    transition: background-color 0.2s ease;
    cursor: pointer;
}

.group-card:hover {
    background-color: #f5f5f5;
}

.group-card:last-child {
    border-bottom: none;
}

.name-image {
    margin-right: 15px;
    display: flex;
    align-items: center;
}

.name-image img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid #eaeaea;
    visibility: visible;
    opacity: 1;
}

.name-image .profile-image {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #DDD;
    display: flex;
    align-items: center;
    justify-content: center;
    visibility: visible;
    opacity: 1;
}

.name-image .profile-image span {
    font-size: 14px;
    color: #888;
    visibility: visible;
    opacity: 1;
}

.group-details {
    display: flex;
    flex: 1;
    flex-direction: column;
    justify-content: center;
    overflow: hidden;
    position: relative;
}

.chat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}

.name-role-container {
    display: flex;
    align-items: center;
    max-width: 70%;
}

.group-title {
    color: #1f1f1f;
    font-size: 16px;
    font-weight: 500;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-role {
    font-size: 10px;
    color: white;
    padding: 2px 6px;
    border-radius: 10px;
    margin-left: 8px;
    font-weight: 500;
    text-transform: uppercase;
    display: inline-block;
}

.chat-time {
    font-size: 12px;
    color: #667781;
}

.last-message {
    color: #667781;
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin: 0;
    padding-right: 25px;
}

.unread-badge {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background-color: #800080;
    color: white;
    font-size: 12px;
    font-weight: bold;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Search bar styling */
.groups-search {
    display: flex;
    gap: 10px;
    margin: 20px 0;
    max-width: 100%;
}

.groups-search input {
    flex: 1;
    padding: 12px 15px;
    border: none;
    border-radius: 8px;
    background-color: #f0f2f5;
    font-size: 15px;
}

.groups-search input:focus {
    outline: none;
    background-color: #e9edef;
}

.groups-search button {
    padding: 10px 20px;
    background-color: #800080;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.groups-search button:hover {
    background-color: #9a009a;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .groups-main {
        flex-direction: column;
        padding: 1rem;
    }
    
    .groups-sidebar {
        margin-bottom: 1rem;
    }
    
    .groups-search {
        flex-direction: column;
    }
    
    .name-role-container {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .user-role {
        margin-left: 0;
        margin-top: 2px;
    }
}

/* Empty state styling */
.no-groups {
    text-align: center;
    padding: 3rem;
    background: #fff;
    border-radius: 8px;
    color: #667781;
    margin-top: 2rem;
}

.no-groups p {
    margin-bottom: 1rem;
    font-size: 16px;
}

.no-groups .btn-view-group {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
}

.btn-view-group {
    background-color: #800080;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 6px 12px;
    text-decoration: none;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-view-group:hover {
    background-color: #9a009a;
}
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const links = document.querySelectorAll(".groups-nav a");

        links.forEach(link => {
            link.addEventListener("click", function() {
                // Remove active class from all links
                links.forEach(l => l.classList.remove("active"));

                // Add active class to the clicked link
                this.classList.add("active");
            });
        });
    });
</script>
</html>