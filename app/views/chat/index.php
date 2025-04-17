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
                </nav>
            </aside>

            <div class="groups-content">
                <h1>My Chats</h1>
                <?php flash('chat_message'); ?>
                
                <form class="groups-search" method="GET" action="<?php echo URLROOT; ?>/chat/index">
                    <input type="text" name="search" placeholder="Search chats...">
                    <button type="submit">Search</button>
                </form>
                
                <p>Connect and communicate with residents, admins, and community members!</p>
                
                <div class="groups-grid">
                    <?php if (!empty($data['chats'])): ?>
                        <?php foreach ($data['chats'] as $chatItem): ?>
                            <div class="group-card">
                                <div class="group-details">
                                    <?php 
                                    // Handle either object or array format for otherUser
                                    $otherUser = $chatItem['otherUser'];
                                    $name = is_object($otherUser) ? $otherUser->name : $otherUser['name'];
                                    $userId = is_object($otherUser) ? $otherUser->id : $otherUser['id'];
                                    $profilePic = is_object($otherUser) ? ($otherUser->profile_picture ?? '') : ($otherUser['profile_picture'] ?? '');
                                    ?>
                                    
                                    <?php if (!empty($profilePic)): ?>
                                        <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" class="profile-image">
                                    <?php endif; ?>
                                    
                                    <h3 class="group-title"><?php echo htmlspecialchars($name); ?></h3>
                                    
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
                                    
                                    <?php if (!empty($messageText)): ?>
                                        <p class="last-message">
                                            <?php 
                                            echo htmlspecialchars(substr($messageText, 0, 50));
                                            if (strlen($messageText) > 50) echo '...'; 
                                            ?>
                                        </p>
                                    <?php else: ?>
                                        <p class="last-message">No messages yet.</p>
                                    <?php endif; ?>
                                    
                                    <?php if ($chatItem['unreadCount'] > 0): ?>
                                        <span class="unread-badge"><?php echo $chatItem['unreadCount']; ?></span>
                                    <?php endif; ?>
                                    
                                    <div class="group-actions">
                                        <a href="<?php echo URLROOT; ?>/chat/viewChat/<?php echo $userId; ?>" class="btn-view-group">View Chat</a>
                                    </div>
                                </div>
                            </div>
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
